<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use PDF;
use App\TeamSize;

class LoanApplicationConsentCreatePDF implements ShouldQueue{
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $team_size_data;
    protected $application;

    public function __construct($team_size_data, $application){
        $this->team_size_data = $team_size_data;
        $this->application = $application;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        
        $application = $this->application;
        $team_size_data = $this->team_size_data;
    
        $file_name = $this->team_size_data->id."-".$this->application->application_number.".pdf";

        $viewLoad = view('admin.pdf.application-consent-pdf', compact('application','team_size_data'))->render();

        $pdf = PDF::loadHTML($viewLoad);
        
        Storage::put('public/consent/'.$file_name, $pdf->output());
        
        $team_data = TeamSize::where('id',$this->team_size_data->id)->first();
        $team_data->consent_pdf_file = 'consent/'.$file_name;
        $team_data->save();
        
        Log::info(PHP_EOL);
        Log::info('consent loan application message pdf created', [
            'application' => $this->application,
            'team_size_data' => $this->team_size_data
        ]);
        
    }
}
