<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Markdown;
use Illuminate\Container\Container;

use App\ApplicationDocuments;
use App\EmailTemplate;
use App\Application;
use App\TeamSize;
use App\User;
use App\ApprovedDocuments;
use App\ApplicationApprovedDocuments;
use App\Mail\DocumentUpdate;
use Mail;
use Illuminate\Support\Facades\Log;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class ApplicationDocumentController extends Controller
{
    
    public function generate_documents_sel(Request $request){
        $application_id = $request->application_id;
        $application_id_array = explode(',', $request->doc_sected_vals);
    
        $application = Application::with('application_approved_document')->whereId($application_id)->first();
        $application_number = $application->application_number;
    
        // Hard delete existing records for selected documents
        ApplicationApprovedDocuments::where('application_id', $application_id)
            ->whereIn('approved_document_id', $application_id_array)
            ->forceDelete();
    
        // Fetch the approved documents
        $ApprovedDocumentsData = ApprovedDocuments::where('status', 1)
            ->whereIn('id', $application_id_array)
            ->orderBy('sort_by', 'ASC')
            ->get();
            
        //dd($ApprovedDocumentsData);
    
        foreach ($ApprovedDocumentsData as $val) {
            $approved_document_id = $val->id;
            $document_file = $val->document_file;
            $document_name = $val->document_name;
    
            $file_name = $this->make_documents($application_id, $application_number, $document_file, $document_name);
    
            $ApplicationApprovedDocumenS = new ApplicationApprovedDocuments();
            $ApplicationApprovedDocumenS->approved_document_id = $approved_document_id;
            $ApplicationApprovedDocumenS->application_id = $application_id;
            $ApplicationApprovedDocumenS->file_name = $file_name;
            $ApplicationApprovedDocumenS->save();
        }
    
        return response()->json(['status' => 200, 'message' => 'Documents have been successfully generated']);
    }

    public function generate_documents(Request $request){
        
        $application_id = $request->application_id;
        
        $application = Application::with('application_approved_document')->whereid($application_id)->first();
        $application_number = $application->application_number;
        
        $application_approved_document_data = $application->application_approved_document;
        
        if(sizeof($application_approved_document_data) != 0){
            
            foreach ($application_approved_document_data as $val){
                $document_id = $val->id;
                $approved_document_id = $val->approved_document_id;
                $approved_document_file_name = $val->file_name;
                
                $ApprovedDocumentsData = ApprovedDocuments::find($approved_document_id);
                $document_file = $ApprovedDocumentsData->document_file;
                $document_name = $ApprovedDocumentsData->document_name;
                    
                $file_name = $this->make_documents($application_id,$application_number,$document_file,$document_name);
                    
                $ApplicationApprovedDocumenS = ApplicationApprovedDocuments::find($document_id);
                $ApplicationApprovedDocumenS->file_name = $file_name;
                $ApplicationApprovedDocumenS->save();
                
            }    
            
        }else{
            
            $ApprovedDocumentsData = ApprovedDocuments::where('status', 1)->orderBy('sort_by', 'ASC')->get();
            
            foreach ($ApprovedDocumentsData as $val){
                $approved_document_id = $val->id;
                $document_file = $val->document_file;
                $document_name = $val->document_name;
                
                $file_name = $this->make_documents($application_id,$application_number,$document_file,$document_name);
                
                $ApplicationApprovedDocumenS = new ApplicationApprovedDocuments;
                $ApplicationApprovedDocumenS->approved_document_id = $approved_document_id;
                $ApplicationApprovedDocumenS->application_id = $application_id;
                $ApplicationApprovedDocumenS->file_name = $file_name;
                $ApplicationApprovedDocumenS->save();
            }
            
        }
        
        return response()->json(['status' => 200, 'message' => 'Document has been successfully generated']);
    }
    
    public function my_make_documents($application_id,$application_number,$document_file,$document_name){
        
        for ($k = 1; $k <= 2; $k++) {
            
            $document_file = '/docs_file/Knote_template_Finance_Offer_merged_Document_Generated_Tokens_' . $k . '.docx';    
            $document_name = 'Knote_template_Finance_Offer_merged_Document_Generated_Tokens_' . $k;
            
            $apply_for = config('constants.apply_for');
            $paymentTypes = [
                1 => 'Principal And Interest',
                2 => 'Interest Only',
                3 => 'Interest Capitalized',
            ];
                                    
            $templatePath = public_path('storage'.$document_file);
            
            // Check if template file exists
            if (!file_exists($templatePath)) {
                throw new \Exception("Template file not found at: " . $templatePath);
            }
            
            $templateProcessor = new TemplateProcessor($templatePath);
    
            $variables = $templateProcessor->getVariables();
            
            $application_data = Application::find($application_id);
            
            if (!$application_data) {
                throw new \Exception("Application not found for ID: " . $application_id);
            }
            
            $abn_or_acn = $application_data->abn_or_acn;
            $apply_for = $apply_for[$application_data->apply_for];
            
            $account_keeping_fees = $application_data->account_keeping_fees;
            $application_fee = $application_data->application_fee;
            $documentation_fee = $application_data->documentation_fee;
            $application_number = $application_data->application_number;
            $applied_annual_interest = $application_data->applied_annual_interest;
            $applied_interest_rate_per_month = $application_data->applied_interest_rate_per_month;
            $brokerage_amount = $application_data->brokerage_amount;
            $brokerage_fee = $application_data->brokerage_fee;
            $business_address = $application_data->business_address;
            $business_email = $application_data->business_email;
            $business_name = $application_data->business_name;
            $business_phone = $application_data->business_phone;
            $created_at = display_date_format($application_data->created_at);
            $diligence_research_fee = $application_data->diligence_research_fee;
            
            if($application_data->discharge_fee == 'noval'){
                $discharge_fee = $application_data->discharge_fee_val;
            }else{
                $discharge_fee = $application_data->discharge_fee;
            }
            
            $document_reference_number = $application_data->document_reference_number;
            $facility_limit = number_format($application_data->facility_limit, 2);
            $facility_term = $application_data->facility_term;
            $grantor_descriptions = $application_data->grantor_descriptions;
            $interest_capitalized = number_format($application_data->interest_capitalized);
            $land_address_descriptions = $application_data->land_address_descriptions;
            $land_description = $application_data->land_description;
            $lender_disbursement_fee = $application_data->lender_disbursement_fee;
            $lvr_current = $application_data->lvr_current;
            $minimum_term_months = $application_data->minimum_term_months;
            $monthly_acc_fee = $application_data->monthly_acc_fee;
            $mortgage_type_descriptions = $application_data->mortgage_type_descriptions;
            $part_land_affected = $application_data->part_land_affected;
            $payment_type = $paymentTypes[$application_data->payment_type] ?? '';
            $repayment_amount = $application_data->repayment_amount;
            $repayment_description = $application_data->repayment_description;
            $settlement_conditions_descriptions = $application_data->settlement_conditions_descriptions;
            $valuation_fee = $application_data->valuation_fee;
            
            $contact_no = '1300 056 683';
            $current_date = date('d-m-Y');
            
            $user_data = User::find($application_data->user_id);
            
            $email = $user_data->email;
            $name = $user_data->name;
            $phone = $user_data->phone;
            
            $team_size_data = TeamSize::where("application_id", $application_id)->orderBy('id', 'ASC')->get();
            
            // Check if the first index exists before accessing it
            $director_address = isset($team_size_data[0]['address']) ? $team_size_data[0]['address'] : '';
            $director_email_address = isset($team_size_data[0]['email_address']) ? $team_size_data[0]['email_address'] : '';
            $director_firstname = isset($team_size_data[0]['firstname']) ? $team_size_data[0]['firstname'] : '';
            $director_lastname = isset($team_size_data[0]['lastname']) ? $team_size_data[0]['lastname'] : '';
            $director_mobile = isset($team_size_data[0]['mobile']) ? $team_size_data[0]['mobile'] : '';
            $director_position = isset($team_size_data[0]['position']) ? $team_size_data[0]['position'] : '';
            $capacity = isset($team_size_data[0]['capacity']) ? $team_size_data[0]['capacity'] : '';
            $locality = isset($team_size_data[0]['locality']) ? $team_size_data[0]['locality'] : '';
            $postcode = isset($team_size_data[0]['postcode']) ? $team_size_data[0]['postcode'] : '';
            $state = isset($team_size_data[0]['state']) ? $team_size_data[0]['state'] : '';
            $street_name = isset($team_size_data[0]['street_name']) ? $team_size_data[0]['street_name'] : '';
            $street_number = isset($team_size_data[0]['street_number']) ? $team_size_data[0]['street_number'] : '';
            $street_type = isset($team_size_data[0]['street_type']) ? $team_size_data[0]['street_type'] : '';
            
            // Check if the second index exists before accessing it
            $director_firstname_2 = isset($team_size_data[1]['firstname']) ? $team_size_data[1]['firstname'] : '';
            $director_lastname_2 = isset($team_size_data[1]['lastname']) ? $team_size_data[1]['lastname'] : '';
            $director_position_2 = isset($team_size_data[1]['position']) ? $team_size_data[1]['position'] : '';
            $director_address_2 = isset($team_size_data[1]['address']) ? $team_size_data[1]['address'] : '';
            $director_email_address_2 = isset($team_size_data[1]['email_address']) ? $team_size_data[1]['email_address'] : '';
            $director_mobile_2 = isset($team_size_data[1]['mobile']) ? $team_size_data[1]['mobile'] : '';
            $capacity_2 = isset($team_size_data[1]['capacity']) ? $team_size_data[1]['capacity'] : '';
            $locality_2 = isset($team_size_data[1]['locality']) ? $team_size_data[1]['locality'] : '';
            $postcode_2 = isset($team_size_data[1]['postcode']) ? $team_size_data[1]['postcode'] : '';
            $state_2 = isset($team_size_data[1]['state']) ? $team_size_data[1]['state'] : '';
            $street_name_2 = isset($team_size_data[1]['street_name']) ? $team_size_data[1]['street_name'] : '';
            $street_number_2 = isset($team_size_data[1]['street_number']) ? $team_size_data[1]['street_number'] : '';
            $street_type_2 = isset($team_size_data[1]['street_type']) ? $team_size_data[1]['street_type'] : '';
            
            // Check if the third index exists before accessing it
            $director_firstname_3 = isset($team_size_data[2]['firstname']) ? $team_size_data[2]['firstname'] : '';
            $director_lastname_3 = isset($team_size_data[2]['lastname']) ? $team_size_data[2]['lastname'] : '';
            $director_position_3 = isset($team_size_data[2]['position']) ? $team_size_data[2]['position'] : '';
            $director_address_3 = isset($team_size_data[2]['address']) ? $team_size_data[2]['address'] : '';
            $director_email_address_3 = isset($team_size_data[2]['email_address']) ? $team_size_data[2]['email_address'] : '';
            $director_mobile_3 = isset($team_size_data[2]['mobile']) ? $team_size_data[2]['mobile'] : '';
            $capacity_3 = isset($team_size_data[2]['capacity']) ? $team_size_data[2]['capacity'] : '';
            $locality_3 = isset($team_size_data[2]['locality']) ? $team_size_data[2]['locality'] : '';
            $postcode_3 = isset($team_size_data[2]['postcode']) ? $team_size_data[2]['postcode'] : '';
            $state_3 = isset($team_size_data[2]['state']) ? $team_size_data[2]['state'] : '';
            $street_name_3 = isset($team_size_data[2]['street_name']) ? $team_size_data[2]['street_name'] : '';
            $street_number_3 = isset($team_size_data[2]['street_number']) ? $team_size_data[2]['street_number'] : '';
            $street_type_3 = isset($team_size_data[2]['street_type']) ? $team_size_data[2]['street_type'] : '';
            
            // Check if the four index exists before accessing it
            $director_firstname_4 = isset($team_size_data[3]['firstname']) ? $team_size_data[3]['firstname'] : '';
            $director_lastname_4 = isset($team_size_data[3]['lastname']) ? $team_size_data[3]['lastname'] : '';
            $director_position_4 = isset($team_size_data[3]['position']) ? $team_size_data[3]['position'] : '';
            $director_address_4 = isset($team_size_data[3]['address']) ? $team_size_data[3]['address'] : '';
            $director_email_address_4 = isset($team_size_data[3]['email_address']) ? $team_size_data[3]['email_address'] : '';
            $director_mobile_4 = isset($team_size_data[3]['mobile']) ? $team_size_data[3]['mobile'] : '';
            $capacity_4 = isset($team_size_data[3]['capacity']) ? $team_size_data[3]['capacity'] : '';
            $locality_4 = isset($team_size_data[3]['locality']) ? $team_size_data[3]['locality'] : '';
            $postcode_4 = isset($team_size_data[3]['postcode']) ? $team_size_data[3]['postcode'] : '';
            $state_4 = isset($team_size_data[3]['state']) ? $team_size_data[3]['state'] : '';
            $street_name_4 = isset($team_size_data[3]['street_name']) ? $team_size_data[3]['street_name'] : '';
            $street_number_4 = isset($team_size_data[3]['street_number']) ? $team_size_data[3]['street_number'] : '';
            $street_type_4 = isset($team_size_data[3]['street_type']) ? $team_size_data[3]['street_type'] : '';
            
            if($application_data->payment_type == 3){
                $total_interest_capitalized = $repayment_amount;    
            }else{
                $total_interest_capitalized = "N/A";
            }
            
            
            // Define the dynamic values to replace placeholders
            $dynamicValues = [
                'application_number' => $application_number ?? '',
                'total_interest_capitalized'  => $total_interest_capitalized ?? '',
                'director_address_2' => $director_address_2 ?? '',
                'director_email_address_2' => $director_email_address_2 ?? '',
                'director_mobile_2' => $director_mobile_2 ?? '',
                'capacity_2' => $capacity_2 ?? '',
                'locality_2' => $locality_2 ?? '',
                'postcode_2' => $postcode_2 ?? '',
                'state_2' => $state_2 ?? '',
                'street_name_2' => $street_name_2 ?? '',
                'street_number_2' => $street_number_2 ?? '',
                'street_type_2' => $street_type_2 ?? '',
                'director_firstname_3' => $director_firstname_3 ?? '',
                'director_lastname_3' => $director_lastname_3 ?? '',
                'director_position_3' => $director_position_3 ?? '',
                'director_address_3' => $director_address_3 ?? '',
                'director_email_address_3' => $director_email_address_3 ?? '',
                'director_mobile_3' => $director_mobile_3 ?? '',
                'capacity_3' => $capacity_3 ?? '',
                'locality_3' => $locality_3 ?? '',
                'postcode_3' => $postcode_3 ?? '',
                'state_3' => $state_3 ?? '',
                'street_name_3' => $street_name_3 ?? '',
                'street_number_3' => $street_number_3 ?? '',
                'street_type_3' => $street_type_3 ?? '',
                'director_firstname_4' => $director_firstname_4 ?? '',
                'director_lastname_4' => $director_lastname_4 ?? '',
                'director_position_4' => $director_position_4 ?? '',
                'director_address_4' => $director_address_4 ?? '',
                'director_email_address_4' => $director_email_address_4 ?? '',
                'director_mobile_4' => $director_mobile_4 ?? '',
                'capacity_4' => $capacity_4 ?? '',
                'locality_4' => $locality_4 ?? '',
                'postcode_4' => $postcode_4 ?? '',
                'state_4' => $state_4 ?? '',
                'street_name_4' => $street_name_4 ?? '',
                'street_number_4' => $street_number_4 ?? '',
                'street_type_4' => $street_type_4 ?? '',
                'apply_for' => $apply_for ?? '',
                'repayment_description' => $repayment_description ?? '',
                'abn_or_acn' => $abn_or_acn ?? '',
                'account_keeping_fees' => $account_keeping_fees !== null ? number_format($account_keeping_fees, 0) : '',
                'application_fee' => $application_fee !== null ? number_format($application_fee, 0) : '',
                'documentation_fee' => $documentation_fee !== null ? number_format($documentation_fee, 0) : '',
                'applied_annual_interest' => $applied_annual_interest ?? '',
                'applied_interest_rate_per_month' => $applied_interest_rate_per_month ?? '',
                'brokerage_amount' => $brokerage_amount !== null ? number_format($brokerage_amount, 0) : '',
                'brokerage_fee' => $brokerage_fee !== null ? number_format($brokerage_fee, 0) : '',
                'facility_limit' => $facility_limit ?? '',
                'lvr_current' => $lvr_current ?? '',
                'valuation_fee' => $valuation_fee !== null ? number_format($valuation_fee, 0) : '',
                'repayment_amount' => $repayment_amount ?? '',
                'business_address' => $business_address ?? '',
                'business_email' => $business_email ?? '',
                'business_name' => $business_name ?? '',
                'business_phone' => $business_phone ?? '',
                'capacity' => $capacity ?? '',
                'contact_no' => $contact_no ?? '',
                'current_date' => $current_date ?? '',
                'created_at' => $created_at ?? '',
                'diligence_research_fee' => $diligence_research_fee !== null ? number_format($diligence_research_fee, 0) : '',
                'director_address' => $director_address ?? '',
                'director_email_address' => $director_email_address ?? '',
                'director_firstname' => $director_firstname ?? '',
                'director_firstname_2' => $director_firstname_2 ?? '',
                'director_lastname' => $director_lastname ?? '',
                'director_lastname_2' => $director_lastname_2 ?? '',
                'director_mobile' => $director_mobile ?? '',
                'director_position' => $director_position ?? '',
                'director_position_2' => $director_position_2 ?? '',
                'discharge_fee' => $discharge_fee ?? '',
                'document_reference_number' => $document_reference_number ?? '',
                'email' => $email ?? '',
                'facility_term' => $facility_term ?? '',
                'grantor_descriptions' => $grantor_descriptions ?? '',
                'interest_capitalized' => $interest_capitalized ?? '',
                'land_address_descriptions' => $land_address_descriptions ?? '',
                'land_description' => $land_description ?? '',
                'lender_disbursement_fee' => $lender_disbursement_fee ?? '',
                'locality' => $locality ?? '',
                'minimum_term_months' => $minimum_term_months ?? '',
                'monthly_acc_fee' => $monthly_acc_fee !== null ? number_format($monthly_acc_fee, 0) : '',
                'mortgage_type_descriptions' => $mortgage_type_descriptions ?? '',
                'name' => $name ?? '',
                'part_land_affected' => $part_land_affected ?? '',
                'payment_type' => $payment_type ?? '',
                'phone' => $phone ?? '',
                'postcode' => $postcode ?? '',
                'settlement_conditions_descriptions' => $settlement_conditions_descriptions ?? '',
                'state' => $state ?? '',
                'street_name' => $street_name ?? '',
                'street_number' => $street_number ?? '',
                'street_type' => $street_type ?? '',
            ];
            
            Log::info('Dynamic Values:', $dynamicValues);
            
            // Replace placeholders with dynamic values
            /*foreach ($dynamicValues as $placeholder => $value) {
                //$templateProcessor->setValue($placeholder, $value);
                $templateProcessor->setValue($placeholder, htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
                //$templateProcessor->setValue($placeholder, trim($value));
                //$templateProcessor->setValue($placeholder, htmlspecialchars($value, ENT_QUOTES));
            }*/
            
            foreach ($dynamicValues as $placeholder => $value) {
                if (!empty($value)) {
                    $cleanedValue = mb_convert_encoding(trim($value), 'UTF-8', 'auto');
                    //Log::info('cleanedValue: ', json_decode($cleanedValue));
                    $templateProcessor->setValue($placeholder, $cleanedValue);
                } else {
                    //Log::info('cleanedValue: ', 'N/A/C');
                    $templateProcessor->setValue($placeholder, '');
                }
            }
            
            //dd($templateProcessor);
            
            // Define the output file name and storage path
            $outputFileName = $application_number.'_'.$document_name.'.docx';
            $storageDirectory = public_path('storage/docs_file_gen');
            
            // Ensure directory exists
            if (!file_exists($storageDirectory)) {
                mkdir($storageDirectory, 0777, true);
            }
            
            $storagePath = $storageDirectory . '/' . $outputFileName;
            
            $store_file_path = '/docs_file_gen/'.$outputFileName;
    
            // Check if the file already exists and remove it
            if (file_exists($storagePath)) {
                unlink($storagePath);
            }
            
            //dd($templateProcessor);
            
            //Log::info('Dynamic Values:', [$templateProcessor]);
            
            // Save the new file
            $templateProcessor->saveAs($storagePath);
            
            // Validate generated document
            if (!file_exists($storagePath) || filesize($storagePath) === 0) {
                throw new \Exception("Generated document is invalid or empty.");
            }
        }

        //return $store_file_path;
    }
    
    public function __make_documents($application_id, $application_number, $document_file, $document_name){
        $templatePath = public_path('storage' . $document_file);
        $outputFileName = "{$application_number}_{$document_name}.docx";
        $storageDirectory = public_path('storage/application_document_file');
    
        if (!file_exists($storageDirectory)) {
            mkdir($storageDirectory, 0777, true);
        }
    
        $storagePath = "{$storageDirectory}/{$outputFileName}";
    
        // Copy the template to avoid modifying the original file
        if (!copy($templatePath, $storagePath)) {
            throw new \Exception("Failed to copy template file.");
        }
    
        $zip = new \ZipArchive;
        if ($zip->open($storagePath) !== true) {
            throw new \Exception("Failed to open document template.");
        }
    
        $xml = $zip->getFromName('word/document.xml');
    
        if ($xml === false) {
            throw new \Exception("Could not read word/document.xml from template.");
        }
    
        Log::info("Original XML Extracted");
    
        $application_data = Application::with('user')->find($application_id);
        if (!$application_data) {
            throw new \Exception("Application not found for ID: " . $application_id);
        }
    
        $user = $application_data->user;
        $team_size_data = TeamSize::where("application_id", $application_id)->orderBy('id', 'ASC')->get();
    
        // Define replacements
        $replacements = [
            'application_number' => $application_number
        ];
    
        Log::info("Placeholders found: " . json_encode($replacements));
    
        // **Fix for split placeholders in XML**  
        $xml = preg_replace_callback(
            '/{{(.*?)}}/',
            function ($matches) use ($replacements) {
                $key = trim($matches[1]); // Get the placeholder name
                return htmlspecialchars($replacements[$key] ?? 'N/A', ENT_XML1 | ENT_QUOTES, 'UTF-8');
            },
            $xml
        );
    
        Log::info("Placeholders replaced in XML.");
    
        // Save updated XML into document
        $zip->deleteName('word/document.xml');
        $zip->addFromString('word/document.xml', $xml);
        $zip->close();
    
        if (!file_exists($storagePath) || filesize($storagePath) === 0) {
            throw new \Exception("Generated document is invalid or empty.");
        }
    
        return "/application_document_file/{$outputFileName}";
    }

    public function make_documents($application_id,$application_number,$document_file,$document_name){
        
        $apply_for = config('constants.apply_for');
        $paymentTypes = [
            1 => 'Principal And Interest',
            2 => 'Interest Only',
            3 => 'Interest Capitalized',
        ];
                                
        $templatePath = public_path('storage'.$document_file);
        
        // Check if template file exists
        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found at: " . $templatePath);
        }
        
        $templateProcessor = new TemplateProcessor($templatePath);
        
        /*$templateProcessor->saveAs(storage_path('app/test_output.docx'));
        die;*/

        $variables = $templateProcessor->getVariables();
        
        $application_data = Application::find($application_id);
        
        if (!$application_data) {
            throw new \Exception("Application not found for ID: " . $application_id);
        }
        
        $abn_or_acn = $application_data->abn_or_acn;
        $apply_for = $apply_for[$application_data->apply_for];
        
        $account_keeping_fees = $application_data->account_keeping_fees;
        $application_fee = $application_data->application_fee;
        $documentation_fee = $application_data->documentation_fee;
        $application_number = $application_data->application_number;
        $applied_annual_interest = $application_data->applied_annual_interest;
        $applied_interest_rate_per_month = $application_data->applied_interest_rate_per_month;
        $brokerage_amount = $application_data->brokerage_amount;
        $brokerage_fee = $application_data->brokerage_fee;
        $business_address = $application_data->business_address;
        $business_email = $application_data->business_email;
        $business_name = $application_data->business_name;
        $business_phone = $application_data->business_phone;
        $created_at = display_date_format($application_data->created_at);
        $diligence_research_fee = $application_data->diligence_research_fee;
        
        if($application_data->discharge_fee == 'noval'){
            $discharge_fee = $application_data->discharge_fee_val;
        }else{
            $discharge_fee = $application_data->discharge_fee;
        }
        
        $document_reference_number = $application_data->document_reference_number;
        $facility_limit = number_format($application_data->facility_limit, 2);
        $facility_term = intval($application_data->facility_term);
        $grantor_descriptions = $application_data->grantor_descriptions;
        $interest_capitalized = number_format($application_data->interest_capitalized, 2);
        $land_address_descriptions = $application_data->land_address_descriptions;
        $land_description = $application_data->land_description;
        $lender_disbursement_fee = $application_data->lender_disbursement_fee;
        $lvr_current = $application_data->lvr_current;
        $minimum_term_months = $application_data->minimum_term_months;
        $monthly_acc_fee = $application_data->monthly_acc_fee;
        $mortgage_type_descriptions = $application_data->mortgage_type_descriptions;
        $part_land_affected = $application_data->part_land_affected;
        $payment_type = $paymentTypes[$application_data->payment_type] ?? '';
        $repayment_amount = $application_data->repayment_amount;
        $repayment_description = $application_data->repayment_description;
        $settlement_conditions_descriptions = $application_data->settlement_conditions_descriptions;
        $valuation_fee = $application_data->valuation_fee;
        
        $contact_no = '1300 056 683';
        $current_date = date('d-m-Y');
        
        $user_data = User::find($application_data->user_id);
        
        $email = $user_data->email;
        $name = $user_data->name;
        $phone = $user_data->phone;
        
        $team_size_data = TeamSize::where("application_id", $application_id)->orderBy('id', 'ASC')->get();
        
        // Check if the first index exists before accessing it
        $director_address = isset($team_size_data[0]['address']) ? $team_size_data[0]['address'] : '';
        $director_email_address = isset($team_size_data[0]['email_address']) ? $team_size_data[0]['email_address'] : '';
        $director_firstname = isset($team_size_data[0]['firstname']) ? $team_size_data[0]['firstname'] : '';
        $director_lastname = isset($team_size_data[0]['lastname']) ? $team_size_data[0]['lastname'] : '';
        $director_mobile = isset($team_size_data[0]['mobile']) ? $team_size_data[0]['mobile'] : '';
        $director_position = isset($team_size_data[0]['position']) ? $team_size_data[0]['position'] : '';
        $capacity = isset($team_size_data[0]['capacity']) ? $team_size_data[0]['capacity'] : '';
        $locality = isset($team_size_data[0]['locality']) ? $team_size_data[0]['locality'] : '';
        $postcode = isset($team_size_data[0]['postcode']) ? $team_size_data[0]['postcode'] : '';
        $state = isset($team_size_data[0]['state']) ? $team_size_data[0]['state'] : '';
        $street_name = isset($team_size_data[0]['street_name']) ? $team_size_data[0]['street_name'] : '';
        $street_number = isset($team_size_data[0]['street_number']) ? $team_size_data[0]['street_number'] : '';
        $street_type = isset($team_size_data[0]['street_type']) ? $team_size_data[0]['street_type'] : '';
        
        // Check if the second index exists before accessing it
        $director_firstname_2 = isset($team_size_data[1]['firstname']) ? $team_size_data[1]['firstname'] : '';
        $director_lastname_2 = isset($team_size_data[1]['lastname']) ? $team_size_data[1]['lastname'] : '';
        $director_position_2 = isset($team_size_data[1]['position']) ? $team_size_data[1]['position'] : '';
        $director_address_2 = isset($team_size_data[1]['address']) ? $team_size_data[1]['address'] : '';
        $director_email_address_2 = isset($team_size_data[1]['email_address']) ? $team_size_data[1]['email_address'] : '';
        $director_mobile_2 = isset($team_size_data[1]['mobile']) ? $team_size_data[1]['mobile'] : '';
        $capacity_2 = isset($team_size_data[1]['capacity']) ? $team_size_data[1]['capacity'] : '';
        $locality_2 = isset($team_size_data[1]['locality']) ? $team_size_data[1]['locality'] : '';
        $postcode_2 = isset($team_size_data[1]['postcode']) ? $team_size_data[1]['postcode'] : '';
        $state_2 = isset($team_size_data[1]['state']) ? $team_size_data[1]['state'] : '';
        $street_name_2 = isset($team_size_data[1]['street_name']) ? $team_size_data[1]['street_name'] : '';
        $street_number_2 = isset($team_size_data[1]['street_number']) ? $team_size_data[1]['street_number'] : '';
        $street_type_2 = isset($team_size_data[1]['street_type']) ? $team_size_data[1]['street_type'] : '';
        
        // Check if the third index exists before accessing it
        $director_firstname_3 = isset($team_size_data[2]['firstname']) ? $team_size_data[2]['firstname'] : '';
        $director_lastname_3 = isset($team_size_data[2]['lastname']) ? $team_size_data[2]['lastname'] : '';
        $director_position_3 = isset($team_size_data[2]['position']) ? $team_size_data[2]['position'] : '';
        $director_address_3 = isset($team_size_data[2]['address']) ? $team_size_data[2]['address'] : '';
        $director_email_address_3 = isset($team_size_data[2]['email_address']) ? $team_size_data[2]['email_address'] : '';
        $director_mobile_3 = isset($team_size_data[2]['mobile']) ? $team_size_data[2]['mobile'] : '';
        $capacity_3 = isset($team_size_data[2]['capacity']) ? $team_size_data[2]['capacity'] : '';
        $locality_3 = isset($team_size_data[2]['locality']) ? $team_size_data[2]['locality'] : '';
        $postcode_3 = isset($team_size_data[2]['postcode']) ? $team_size_data[2]['postcode'] : '';
        $state_3 = isset($team_size_data[2]['state']) ? $team_size_data[2]['state'] : '';
        $street_name_3 = isset($team_size_data[2]['street_name']) ? $team_size_data[2]['street_name'] : '';
        $street_number_3 = isset($team_size_data[2]['street_number']) ? $team_size_data[2]['street_number'] : '';
        $street_type_3 = isset($team_size_data[2]['street_type']) ? $team_size_data[2]['street_type'] : '';
        
        // Check if the four index exists before accessing it
        $director_firstname_4 = isset($team_size_data[3]['firstname']) ? $team_size_data[3]['firstname'] : '';
        $director_lastname_4 = isset($team_size_data[3]['lastname']) ? $team_size_data[3]['lastname'] : '';
        $director_position_4 = isset($team_size_data[3]['position']) ? $team_size_data[3]['position'] : '';
        $director_address_4 = isset($team_size_data[3]['address']) ? $team_size_data[3]['address'] : '';
        $director_email_address_4 = isset($team_size_data[3]['email_address']) ? $team_size_data[3]['email_address'] : '';
        $director_mobile_4 = isset($team_size_data[3]['mobile']) ? $team_size_data[3]['mobile'] : '';
        $capacity_4 = isset($team_size_data[3]['capacity']) ? $team_size_data[3]['capacity'] : '';
        $locality_4 = isset($team_size_data[3]['locality']) ? $team_size_data[3]['locality'] : '';
        $postcode_4 = isset($team_size_data[3]['postcode']) ? $team_size_data[3]['postcode'] : '';
        $state_4 = isset($team_size_data[3]['state']) ? $team_size_data[3]['state'] : '';
        $street_name_4 = isset($team_size_data[3]['street_name']) ? $team_size_data[3]['street_name'] : '';
        $street_number_4 = isset($team_size_data[3]['street_number']) ? $team_size_data[3]['street_number'] : '';
        $street_type_4 = isset($team_size_data[3]['street_type']) ? $team_size_data[3]['street_type'] : '';
            
        if($application_data->payment_type == 3){
            $total_interest_capitalized = $repayment_amount;
        }else{
            $total_interest_capitalized = "N/A";
        }
        
        
        // Define the dynamic values to replace placeholders
        $dynamicValues = [
            'total_interest_capitalized'  => $total_interest_capitalized ?? '',
            'application_number' => $application_number ?? '',
            'director_address_2' => $director_address_2 ?? '',
            'director_email_address_2' => $director_email_address_2 ?? '',
            'director_mobile_2' => $director_mobile_2 ?? '',
            'capacity_2' => $capacity_2 ?? '',
            'locality_2' => $locality_2 ?? '',
            'postcode_2' => $postcode_2 ?? '',
            'state_2' => $state_2 ?? '',
            'street_name_2' => $street_name_2 ?? '',
            'street_number_2' => $street_number_2 ?? '',
            'street_type_2' => $street_type_2 ?? '',
            'director_firstname_3' => $director_firstname_3 ?? '',
            'director_lastname_3' => $director_lastname_3 ?? '',
            'director_position_3' => $director_position_3 ?? '',
            'director_address_3' => $director_address_3 ?? '',
            'director_email_address_3' => $director_email_address_3 ?? '',
            'director_mobile_3' => $director_mobile_3 ?? '',
            'capacity_3' => $capacity_3 ?? '',
            'locality_3' => $locality_3 ?? '',
            'postcode_3' => $postcode_3 ?? '',
            'state_3' => $state_3 ?? '',
            'street_name_3' => $street_name_3 ?? '',
            'street_number_3' => $street_number_3 ?? '',
            'street_type_3' => $street_type_3 ?? '',
            'director_firstname_4' => $director_firstname_4 ?? '',
            'director_lastname_4' => $director_lastname_4 ?? '',
            'director_position_4' => $director_position_4 ?? '',
            'director_address_4' => $director_address_4 ?? '',
            'director_email_address_4' => $director_email_address_4 ?? '',
            'director_mobile_4' => $director_mobile_4 ?? '',
            'capacity_4' => $capacity_4 ?? '',
            'locality_4' => $locality_4 ?? '',
            'postcode_4' => $postcode_4 ?? '',
            'state_4' => $state_4 ?? '',
            'street_name_4' => $street_name_4 ?? '',
            'street_number_4' => $street_number_4 ?? '',
            'street_type_4' => $street_type_4 ?? '',
            'apply_for' => $apply_for ?? '',
            'repayment_description' => $repayment_description ?? '',
            'abn_or_acn' => $abn_or_acn ?? '',
            'account_keeping_fees' => $account_keeping_fees !== null ? number_format($account_keeping_fees, 0) : '',
            'application_fee' => $application_fee !== null ? number_format($application_fee, 0) : '',
            'documentation_fee' => $documentation_fee !== null ? number_format($documentation_fee, 0) : '',
            'applied_annual_interest' => $applied_annual_interest ?? '',
            'applied_interest_rate_per_month' => $applied_interest_rate_per_month ?? '',
            'brokerage_amount' => $brokerage_amount !== null ? number_format($brokerage_amount, 0) : '',
            'brokerage_fee' => $brokerage_fee !== null ? number_format($brokerage_fee, 0) : '',
            'facility_limit' => $facility_limit ?? '',
            'lvr_current' => $lvr_current ?? '',
            'valuation_fee' => $valuation_fee !== null ? number_format($valuation_fee, 0) : '',
            'repayment_amount' => $repayment_amount ?? '',
            'business_address' => $business_address ?? '',
            'business_email' => $business_email ?? '',
            'business_name' => $business_name ?? '',
            'business_phone' => $business_phone ?? '',
            'capacity' => $capacity ?? '',
            'contact_no' => $contact_no ?? '',
            'current_date' => $current_date ?? '',
            'created_at' => $created_at ?? '',
            'diligence_research_fee' => $diligence_research_fee !== null ? number_format($diligence_research_fee, 0) : '',
            'director_address' => $director_address ?? '',
            'director_email_address' => $director_email_address ?? '',
            'director_firstname' => $director_firstname ?? '',
            'director_firstname_2' => $director_firstname_2 ?? '',
            'director_lastname' => $director_lastname ?? '',
            'director_lastname_2' => $director_lastname_2 ?? '',
            'director_mobile' => $director_mobile ?? '',
            'director_position' => $director_position ?? '',
            'director_position_2' => $director_position_2 ?? '',
            'discharge_fee' => $discharge_fee ?? '',
            'document_reference_number' => $document_reference_number ?? '',
            'email' => $email ?? '',
            'facility_term' => $facility_term ?? '',
            'grantor_descriptions' => $grantor_descriptions ?? '',
            'interest_capitalized' => $interest_capitalized ?? '',
            'land_address_descriptions' => $land_address_descriptions ?? '',
            'land_description' => $land_description ?? '',
            'lender_disbursement_fee' => $lender_disbursement_fee ?? '',
            'locality' => $locality ?? '',
            'minimum_term_months' => $minimum_term_months ?? '',
            'monthly_acc_fee' => $monthly_acc_fee !== null ? number_format($monthly_acc_fee, 0) : '',
            'mortgage_type_descriptions' => $mortgage_type_descriptions ?? '',
            'name' => $name ?? '',
            'part_land_affected' => $part_land_affected ?? '',
            'payment_type' => $payment_type ?? '',
            'phone' => $phone ?? '',
            'postcode' => $postcode ?? '',
            'settlement_conditions_descriptions' => $settlement_conditions_descriptions ?? '',
            'state' => $state ?? '',
            'street_name' => $street_name ?? '',
            'street_number' => $street_number ?? '',
            'street_type' => $street_type ?? '',
        ];
        
        //Log::info('Dynamic Values:', $dynamicValues);
        
        // Replace placeholders with dynamic values
        /*foreach ($dynamicValues as $placeholder => $value) {
            //$templateProcessor->setValue($placeholder, $value);
            $templateProcessor->setValue($placeholder, htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
            //$templateProcessor->setValue($placeholder, trim($value));
            //$templateProcessor->setValue($placeholder, htmlspecialchars($value, ENT_QUOTES));
        }*/
        
        foreach ($dynamicValues as $placeholder => $value) {
            if (!empty($value)) {
                $cleanedValue = mb_convert_encoding(trim($value), 'UTF-8', 'auto');
                //Log::info('cleanedValue: ', json_decode($cleanedValue));
                $templateProcessor->setValue($placeholder, $cleanedValue);
            } else {
                //Log::info('cleanedValue: ', 'N/A/C');
                $templateProcessor->setValue($placeholder, '');
            }
        }
        
        
        //dd($templateProcessor);
        
        // Define the output file name and storage path
        $outputFileName = $application_number.'_'.$document_name.'.docx';
        $storageDirectory = public_path('storage/application_document_file');
        
        // Ensure directory exists
        if (!file_exists($storageDirectory)) {
            mkdir($storageDirectory, 0777, true);
        }
    
        $storagePath = $storageDirectory . '/' . $outputFileName;
        $store_file_path = '/application_document_file/'.$outputFileName;

        // Check if the file already exists and remove it
        if (file_exists($storagePath)) {
            unlink($storagePath);
        }
        
        //dd($templateProcessor);
        
        //Log::info('Dynamic Values:', [$templateProcessor]);
        
        // Save the new file
        $templateProcessor->saveAs($storagePath);
        
        // Validate generated document
        if (!file_exists($storagePath) || filesize($storagePath) === 0) {
            throw new \Exception("Generated document is invalid or empty.");
        }

        return $store_file_path;
    }
    
    public function generate_document_sample(Request $request){
        
        $templatePath = public_path('storage/documents/Finance-Offer-Template-Product-B.docx');
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        // Create a new TemplateProcessor instance
        $templateProcessor = new TemplateProcessor($templatePath);

        $variables = $templateProcessor->getVariables();

        $TermInMonths = 5;

        $boldValue = '<w:r><w:rPr><w:b/></w:rPr><w:t>' . $TermInMonths . '</w:t></w:r>';

        $terminmonth = $templateProcessor->setValue('param_10', $boldValue);
        // Define the dynamic values to replace placeholders
        $dynamicValues = [
            'param_1' => 'Test Company',
            'param_2' => 'Richardddddddddddddddd',
            'param_3' => 'Lee',
            'param_4' => 'ABC-824 753 556',
            'param_5' => 'APP123456',
            'param_6' => '1000',
            'param_7' => '2000000',
            'param_8' => '3000',
            'param_9' => '19-12-2024',
            'param_10' => $terminmonth,
        ];

        // Replace placeholders with dynamic values
        foreach ($dynamicValues as $placeholder => $value) {
            //$templateProcessor->setValue($placeholder, $value);
            $templateProcessor->setValue($placeholder, htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
        }
        // Define the output file name and storage path
        $outputFileName = time() . '-Finance-Offer-Template-Product-B.docx';
        $storageDirectory = public_path('storage/documents_new');
        $storagePath = $storageDirectory . '/' . $outputFileName;
    
        // Ensure the directory exists
        if (!file_exists($storageDirectory)) {
            if (!mkdir($storageDirectory, 0777, true) && !is_dir($storageDirectory)) {
                return response()->json(['error' => 'Failed to create directory: ' . $storageDirectory], 500);
            }
        }

        // Save the modified document to the storage path
        $templateProcessor->saveAs($storagePath);
        
        // Check if the file was saved successfully
        if (!file_exists($storagePath)) {
            return response()->json(['error' => 'Failed to save file at ' . $storagePath], 500);
        }
        
        // Return the document as a download response
        return response()->download($storagePath, $outputFileName)->deleteFileAfterSend(false);
    }
    
	public function customer_store_mail(Request $request){
	    
        if ($request->attachment_add) {
            $attachments = [];
    
            foreach ($request->attachment_add as $doc) {
                $file_extension = $doc->getClientOriginalExtension();
                $filename = $doc->getClientOriginalName();
                $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                $filename = strtolower(str_replace(' ', '_', $filename));
    
                $document = new ApplicationDocuments;
                $document->application_id = $request->application_id_val;
                $document->is_type = $request->is_type;
                $document->title = $filename;
                $document->user_id = auth()->id();
                $document->file_extension = $file_extension;
                $document->save();
    
                $document_name = $document->id . '_' . $filename . '.' . $file_extension;
                $path = $doc->storeAs('public/mail_document', $document_name);
    
                $attachments[] = asset('storage/mail_document/' . $document_name);
            }
    
            return response()->json([
                'status' => '201',
                'message' => 'Document has been successfully uploaded.',
                'attachments' => $attachments,
            ]);
        }
    
        return response()->json([
            'status' => '404',
            'message' => 'Please upload sending document.'
        ]);
    }

	public function customer_store(Request $request){

	    if($request->application_documents){
	        
	        $attachment = array();
	        
	    	foreach ($request->application_documents as $key => $doc) {
		        $file_extension = $doc->getClientOriginalExtension();
				$filename = $doc->getClientOriginalName();
		        $filename =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
	            $filename = strtolower(str_replace(' ', '_', $filename));

	            $document = new ApplicationDocuments;
	            $document->application_id = $request->application_id_val;
	            $document->is_type = $request->is_type;
	            $document->title = $filename;
	            $document->user_id = auth()->id();
	            $document->file_extension = $file_extension;
	            $document->save();

	            $document_name = $document->id.'_'.$filename.'.'.$file_extension;
                $doc->storeAs('public/mail_document',$document_name);
                
                $attachment[] = 'mail_document/'.$document_name;
			}	

			$html = "";
			$documents = ApplicationDocuments::whereapplication_id($request->application_id_val)->latest()->get();
            
            $application = Application::find($request->application_id_val);
            
			foreach ($documents as $key => $doc) {
				$attachment = ($doc->file_extension==null) ? '' : $doc->document_file_path();

				$html .= '
				<div class="mb-2 file-item">
				    <span>'.str_replace('_', ' ', $doc->title).'</span>
				    
					<div class="float-right">
						<a href="'.$doc->document_file_path().'" target="blank" class="text-success"><i class="mdi mdi-download mr-1 fs-22"></i></a>';
						if($doc->user_id == auth()->id()){
						    $html .= '<a href="javascript:;" class="upload-document-delete" data-id="'.$doc->id.'"><i class="mdi mdi-delete text-danger mr-1 fs-22"></i></a>';   
						}
					$html .= '	
					</div>
					<div class="">
    			        <span class="text-muted"><i class="flaticon2-time"></i> '.display_date_format($doc->created_at).'</span>
    				</div>
				</div>';
				
			}
        
	      	return response()->json(['status' => '201', 'message'=>'Document has been successfully uploaded.', 'html' => $html]);
	    }else{
	       return response()->json(['status' => '404', 'message'=>'Please upload sending document.']);
	    }
	}
	
	public function destroy(Request $request){
		$id = $request->id;
		$data = ApplicationDocuments::find($id);
	    if (!Storage::exists('storage/mail_document/'.$id.'_'.$data->title.'.'.$data->file_extension)) {
	        Storage::delete('storage/mail_document/'.$id.'_'.$data->title.'.'.$data->file_extension);
	    }
		$status = ApplicationDocuments::find($id)->delete();
		return response()->json(['status' => 200, 'message' => 'Document has been successfully deleted.']);
	}
	
	public function customer_destroy(Request $request){
		$id = $request->id;
		$data = ApplicationDocuments::find($id);
        if (!Storage::exists('storage/mail_document/'.$id.'_'.$data->title.'.'.$data->file_extension)) {
    		Storage::delete('storage/mail_document/'.$id.'_'.$data->title.'.'.$data->file_extension);
        }
		$status = ApplicationDocuments::find($id)->delete();
		return response()->json(['status' => 200, 'message' => 'Document has been successfully deleted.']);
	}
	
	/*public function generate_documents_sel(Request $request){
        
        $application_id = $request->application_id;
        
        $application_id_array = explode(',', $request->doc_sected_vals);
        
        $application = Application::with('application_approved_document')->whereid($application_id)->first();
        $application_number = $application->application_number;
        
        $ApprovedDocumentsData = ApprovedDocuments::where('status', 1)->whereIn('id', $application_id_array)->orderBy('sort_by', 'ASC')->get();
        
        foreach ($ApprovedDocumentsData as $val){
            $approved_document_id = $val->id;
            $document_file = $val->document_file;
            $document_name = $val->document_name;
            
            $file_name = $this->make_documents($application_id,$application_number,$document_file,$document_name);
            
            $ApplicationApprovedDocumenS = new ApplicationApprovedDocuments;
            $ApplicationApprovedDocumenS->approved_document_id = $approved_document_id;
            $ApplicationApprovedDocumenS->application_id = $application_id;
            $ApplicationApprovedDocumenS->file_name = $file_name;
            $ApplicationApprovedDocumenS->save();
        }
        
        return response()->json(['status' => 200, 'message' => 'Document has been successfully generated']);
    }*/
    
    /*public function store(Request $request){
	    if($request->application_documents){
	    	
	      	foreach ($request->application_documents as $key => $doc) {
		        $file_extension = $doc->getClientOriginalExtension();
				$filename = $doc->getClientOriginalName();
		        $filename =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
	            $filename = strtolower(str_replace(' ', '_', $filename));

	            $document = new ApplicationDocuments;
	            $document->application_id = $request->application_id;
	            $document->title = $filename;
	            $document->user_id = auth()->id();
	            $document->file_extension = $file_extension;
	            $document->save();

	            $document_name = $document->id.'_'.$filename.'.'.$file_extension;
                $doc->storeAs('public/mail_document',$document_name);
			}	

			$html = "";
			$documents = ApplicationDocuments::whereapplication_id($request->application_id)->latest()->get();

			foreach ($documents as $key => $doc) {
				$attachment = ($doc->file_extension==null) ? '' : $doc->document_file_path();

				$html .= '
				<div class="checkbox-list mb-6">
					<label for="document'.$key.'" class="checkbox">
						<input id="document'.$key.'" type="checkbox" data-parsley-multiple="document'.$key.'" class="my-cu-check-uncheck2" 
						name="sending-documents" 
                        data-attachment="'.$attachment.'"
                        data-file-extension="'.$doc->file_extension.'"
                        data-file-name="'.str_replace('_', ' ', $doc->title).'"
						>'.str_replace('_', ' ', $doc->title).'
						<span></span>
						<div class="float-right">
							<a href="'.$doc->document_file_path().'" target="blank">Download</a>';
							if($doc->user_id == auth()->id()){
						        $html .= '<span> | </span>
						        <a href="javascript:;" class="upload-document-delete" data-id="'.$doc->id.'">Delete</a>';   
						    }
						    
						$html .= '	
						</div>
						
						<div class="">
						     <span class="text-muted"><i class="flaticon2-time"></i>'.display_date_format($doc->created_at).'</span>
						</div>
						
					</label>
	  			</div>';
				
				
			
			}

	      	return response()->json(['status' => '201', 'message'=>'Document has been successfully uploaded.', 'html' => $html]);
	    }else{
	       return response()->json(['status' => '404', 'message'=>'Please upload sending document.']);
	    }
	}*/
	
}
