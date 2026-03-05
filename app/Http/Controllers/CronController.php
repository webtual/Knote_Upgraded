<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Application;
use Carbon\Carbon;
use App\Jobs\IncompleteLoanApplication;
use App\Jobs\DeuDateLoanApplication;

class CronController extends Controller
{
    
    public function status_due_application(Request $request){
        try {
            $result = DB::transaction(function () {
                $statusConditions = [
                    2 => 4, 4 => 4, 6 => 4, // Completed, Under Review, Assessment: 4 hours
                    9 => 24, // Fast Track: 24 hours
                    12 => 72 // Full Assessment: 72 hours
                ];
                
                $applications = Application::with(['user', 'current_status', 'latest_status_history'])
                    ->whereIn('status_id', array_keys($statusConditions))
                    ->whereNull('reminder_sent_at') // Ensure only unsent reminders are considered
                    ->get();
                
                foreach ($applications as $application) {
                    $userEmail = $application->user->email ?? null;
                    $latestStatus = $application->latest_status_history;
                    
                    if ($userEmail && $latestStatus) {
                        $hoursDiff = now()->diffInHours($latestStatus->created_at);
                        $requiredHours = $statusConditions[$latestStatus->status_id] ?? PHP_INT_MAX;
    
                        // Send mail only if the required time has passed and no reminder has been sent
                        if ($hoursDiff >= $requiredHours) {
                            dispatch(new DeuDateLoanApplication($application))->delay(now()->addSeconds(5));
    
                            // Update the reminder_sent_at timestamp to avoid duplicate emails
                            $applicationss = Application::find($application->id);
                            $applicationss->reminder_sent_at = now();
                            $applicationss->save();
                        }
                    }
                }
    
                return response()->json([
                    'status' => 200,
                    'message' => 'The cron job for reminder due date applications has executed successfully.',
                    'data' => (object)[]
                ]);
            });
    
            return $result;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => $e->getMessage(),
                'data' => (object)[]
            ]);
        }
    }


    public function __status_due_application(Request $request){
        try {
            $result = DB::transaction(function () {
                $statusConditions = [
                    2 => 4, 4 => 4, 6 => 4, // Completed, Under Review, Assessment: 4 hours
                    9 => 24, // Fast Track: 24 hours
                    12 => 72 // Full Assessment: 72 hours
                ];
                
                $applications = Application::with(['user', 'current_status', 'latest_status_history'])
                    ->whereIn('status_id', array_keys($statusConditions))
                    ->get();
                
                foreach ($applications as $application) {
                    $userEmail = $application->user->email ?? null;
                    $latestStatus = $application->latest_status_history;
                    if ($userEmail && $latestStatus) {
                        $hoursDiff = now()->diffInHours($latestStatus->created_at);
    
                        if ($hoursDiff >= ($statusConditions[$latestStatus->status_id] ?? PHP_INT_MAX)) {
                            
                            dispatch(new DeuDateLoanApplication($application))->delay(now()->addSeconds(5));
                        }
                    }
                }
    
                return response()->json([
                    'status' => 200,
                    'message' => 'The cron job for reminder due date applications has executed successfully.',
                    'data' => (object)[]
                ]);
            });
    
            return $result;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => $e->getMessage(),
                'data' => (object)[]
            ]);
        }
    }
    
    public function incomplete_application(Request $request){
        
        try {
            $result = DB::transaction(function () use ($request) {
                
                $data = Application::select('*')->where('status_id', 1)->whereDate('created_at', Carbon::yesterday())->orderBy('id', 'DESC')->get();
                
                foreach ($data as $val){
                    
                    $application = Application::with('user')->find($val->id);
                    
                    if($application->user->email != null){
                        
                        dispatch(new IncompleteLoanApplication($application))->delay(now()->addSeconds(10));
                    }
                }
                
                return response()->json(['status' => 200, 'message' => 'The cron job for incomplete applications has executed successfully.', 'data' => (object)[]]);
            });

            return $result;
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => (object)[]]);
        }
        
    }
    
}
   