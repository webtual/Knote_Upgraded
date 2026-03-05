<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Application;
use App\TeamSize;
use App\CreditScoreEventLogs;
use Illuminate\Support\Facades\Request;

trait EquifaxScoreseeker
{
    
    public function company_user_score_seeker_enquiry($application_id, $team_size_id){
        
        $application_data = Application::find($application_id);
        $team_size_data = TeamSize::find($team_size_id);
        
        $random = strtoupper(Str::random(8));
        
        $username = config('constants.equifax_username');
        $password = config('constants.equifax_password');
        
        $equifax_mode = config('constants.equifax_mode');
        if($equifax_mode == 0){
            $equifax_company_user_score_seeker_enquiry_url = config('constants.equifax_company_user_score_seeker_enquiry_test');
        }else{
            $equifax_company_user_score_seeker_enquiry_url = config('constants.equifax_company_user_score_seeker_enquiry_live');
        }
        
        Log::info('equifax_company_user_score_seeker_enquiry_url', ['request' => $equifax_company_user_score_seeker_enquiry_url]);

        $clientReference = $application_data->user->customer_no;
        $clientReferenceHeader = $random;
        $companyNumber = $application_data->abn_or_acn;
        $enquiryAmount = $application_data->amount_request;
        $accountType = 'PF';
        $operator_id = 'K001';
        $operator_name = 'KNOTE';
        $permission_type_code = 'XY';
        $product_data_level_code = 'N';
        $scorecard_id_1 = 'VSA_2.0_XY_NR';
        $scorecard_id_2 = 'VS_1.1_XY_NR';
        $relationship_code = '1';
        $enquiry_client_reference = $random;
        $family_name = $team_size_data->firstname;
        $first_given_name = $team_size_data->lastname;
        $p_unit_number = '1';
        $drivers_licence = $team_size_data->license_number;
        $gender = $team_size_data->gender;
        $date_of_birth = $team_size_data->dob;
        $employer = $application_data->business_name;
        $address = $team_size_data->address;
        

$soapBody = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vh="http://vedaxml.com/soap/header/v-header-v1-10.xsd" xmlns:scor="http://vedaxml.com/vxml2/score-seeker-v1-0.xsd">
   <soapenv:Header xmlns:wsa="http://www.w3.org/2005/08/addressing">
      <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
         <wsse:UsernameToken>
            <wsse:Username>{$username}</wsse:Username>
			<wsse:Password>{$password}</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
      <wsa:To>https://vedaxml.corp.dmz/sys2/soap11/score-seeker-v1-0</wsa:To>
      <wsa:Action>http://vedaxml.com/score-seeker/EnquiryRequest</wsa:Action>
   </soapenv:Header>
   <soapenv:Body>
      <scor:request>
         <scor:enquiry-header>
            <scor:client-reference>{$clientReferenceHeader}</scor:client-reference>
            <scor:operator-id>{$operator_id}</scor:operator-id>
            <scor:operator-name>{$operator_name}</scor:operator-name>
            <scor:permission-type-code>{$permission_type_code}</scor:permission-type-code>
            <scor:product-data-level-code>{$product_data_level_code}</scor:product-data-level-code>
         </scor:enquiry-header>
         <scor:score-type>
            <scor:what-if>
               <scor:requested-scores>
                  <scor:scorecard-id>{$scorecard_id_1}</scor:scorecard-id>
                  <scor:scorecard-id>{$scorecard_id_2}</scor:scorecard-id>
                  </scor:requested-scores>
               <scor:enquiry>
                  <scor:account-type-code>{$accountType}</scor:account-type-code>
                  <scor:enquiry-amount currency-code="AUD">{$enquiryAmount}</scor:enquiry-amount>
                  <scor:relationship-code>{$p_unit_number}</scor:relationship-code>
                  <scor:enquiry-client-reference>{$enquiry_client_reference}</scor:enquiry-client-reference>
               </scor:enquiry>
            </scor:what-if>
            </scor:score-type>
         <scor:subject-identity>
            <scor:current-name>
               <scor:family-name>{$family_name}</scor:family-name>
               <scor:first-given-name>{$first_given_name}</scor:first-given-name>
            </scor:current-name>
            <scor:addresses>
               <scor:address type="C">
			      <scor:unformatted-address>{$address}</scor:unformatted-address>
               </scor:address>
            </scor:addresses>
            <scor:drivers-licence>
               <scor:number>{$drivers_licence}</scor:number>
            </scor:drivers-licence>
            <scor:gender-code>{$gender}</scor:gender-code>
            <scor:date-of-birth>{$date_of_birth}</scor:date-of-birth>
            <scor:employment>
               <scor:employer type="C">
                  <scor:name>{$employer}</scor:name>
               </scor:employer>
            </scor:employment>
         </scor:subject-identity>
      </scor:request>
   </soapenv:Body>
</soapenv:Envelope>
XML;
        
        Log::info('company_user_score_seeker_enquiry Equifax SOAP request', ['request' => $soapBody]);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $equifax_company_user_score_seeker_enquiry_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $soapBody,
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml;charset=UTF-8'
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
          
        Log::info('company_user_score_seeker_enquiry Equifax SOAP response', ['response' => $response]);
        
        if ($error || $httpCode == 524) {
            return response()->json([
                'status' => 401,
                'message' => $httpCode == 524 
                    ? 'The request timed out while waiting for a response from Equifax.' 
                    : $error,
                'data' => ''
            ]);
        }
        
        $xml = simplexml_load_string($response);
        
        $namespaces = $xml->getNamespaces(true);
        //$body = $xml->children($namespaces['SOAP-ENV'] ?? '')->Body ?? null;
        $body = $xml->children($namespaces['soapenv'] ?? '')->Body ?? null;
        
        $xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
        $faults = $xml->xpath('//soapenv:Fault') ?? null;
        
        if ($faults) {
            $fault = $faults[0];
            $faultCode = (string) $fault->faultcode ?? null;
            $faultString = (string) $fault->faultstring ?? null;
        
            preg_match('/\[(.*?)\]/', $faultString, $matches);
            $enquiryId = $matches[1] ?? null;
            
            $CreditScoreEventLogs = new CreditScoreEventLogs;
            $CreditScoreEventLogs->enquiry_id = null;
            $CreditScoreEventLogs->status = 'error';
            $CreditScoreEventLogs->name = 'ScoreSeeker Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->team_size_id = $team_size_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->is_error = 1;
            $CreditScoreEventLogs->error_string = $faultString;
            $CreditScoreEventLogs->score_pdf = null;
            $CreditScoreEventLogs->save();
            
        
            Log::error("company_user_score_seeker_enquiry Equifax SOAP Fault", [
                'faultcode' => $faultCode,
                'faultstring' => $faultString,
                'enquiry_id' => $enquiryId
            ]);
            
            return response()->json(['status' => 401, 'message' => $faultString, 'data' => '']);
        } else {
            
            $vsResponse = $body->children($namespaces['vs'] ?? '')->response ?? null;
            
            $enquiryId = null;
            $bureau_score = null;
            
            if ($vsResponse) {
                if ($vsResponse) {
                    if (isset($vsResponse->{'product-header'}->{'enquiry-id'})) {
                        $enquiryId = (string) $vsResponse->{'product-header'}->{'enquiry-id'};
                    }
            
                    if (isset($vsResponse->{'score-data'}->score[0]->{'score-masterscale'})) {
                        $bureau_score = (string) $vsResponse->{'score-data'}->score[0]->{'score-masterscale'};
                    }
                }
                
            }
            
            Log::info('company_user_score_seeker_enquiry Equifax SOAP bureau_score', ['bureau_score' => $bureau_score]);
            
            Log::info('company_user_score_seeker_enquiry Equifax enquiryId', ['enquiryId' => $enquiryId]);
            
            $TeamSize_data = TeamSize::find($team_size_id);
            $TeamSize_data->seeker_score = $bureau_score;
            $TeamSize_data->score_seeker_at = now();
            $TeamSize_data->save();
            
            $CreditScoreEventLogs = new CreditScoreEventLogs;
            $CreditScoreEventLogs->enquiry_id = $enquiryId;
            $CreditScoreEventLogs->status = 'success';
            $CreditScoreEventLogs->score = $bureau_score;
            $CreditScoreEventLogs->name = 'ScoreSeeker Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->team_size_id = $team_size_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->score_pdf = null;
            $CreditScoreEventLogs->save();
            
            Log::info('j_start_time', ['ST' => now()]);
            sleep(20);
            Log::info('j_end_time', ['ET' => now()]);
            
            $this->company_user_score_seeker_previous_enquiry($enquiryId, $application_id, $CreditScoreEventLogs->id, $team_size_id);
            
            return response()->json(['status' => 200, 'message' => 'Success', 'data' => '']);
        }
    }
    
    public function company_user_score_seeker_previous_enquiry($enquiryId, $application_id, $id, $team_size_id) {
        
        $username = config('constants.equifax_username');
        $password = config('constants.equifax_password');
        
        $equifax_mode = config('constants.equifax_mode');
        if($equifax_mode == 0){
            $equifax_previous_enquiry_url = config('constants.equifax_previous_enquiry_test');
        }else{
            $equifax_previous_enquiry_url = config('constants.equifax_previous_enquiry_live');
        }
        
        Log::info('equifax_previous_enquiry_url', ['request' => $equifax_previous_enquiry_url]);
        
    $soapBody = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:prev="http://vedaxml.com/vxml2/previous-enquiry-v1-0.xsd" xmlns:wsa="http://www.w3.org/2005/08/addressing" xmlns:vh="http://vedaxml.com/soap/header/v-header-v1-9.xsd">
    <soapenv:Header>
        <wsse:Security mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken>
                <wsse:Username>{$username}</wsse:Username>
                <wsse:Password>{$password}</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
        <wsa:To>https://vedaxml.com/sys2/previous-enquiry-v1</wsa:To>     
        <vh:ConfigurationName></vh:ConfigurationName>     
        <wsa:Action>http://vedaxml.com/previousEnquiry/ServiceRequest</wsa:Action>
    </soapenv:Header>
    <soapenv:Body>
        <prev:request>
            <prev:enquiryId>{$enquiryId}</prev:enquiryId>
            <prev:contentType>application/pdf</prev:contentType>
        </prev:request>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        
        Log::info('company_user_score_seeker_previous_enquiry Equifax SOAP request', ['request' => $soapBody]);
        
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $equifax_previous_enquiry_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $soapBody,
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml;charset=UTF-8',
            ],
        ]);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        Log::info('company_user_score_seeker_previous_enquiry Equifax SOAP response', ['response' => $response]);
        
        if ($error || $httpCode == 524) {
            return response()->json([
                'status' => 401,
                'message' => $httpCode == 524 
                    ? 'The request timed out while waiting for a response from Equifax.' 
                    : $error,
                'data' => ''
            ]);
        }
        
        // Parse XML
        $xml = simplexml_load_string($response);
        
        $namespaces = $xml->getNamespaces(true);
        
        $body = $xml->children($namespaces['soapenv'] ?? '')->Body ?? null;
        
        $xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
        $faults = $xml->xpath('//soapenv:Fault') ?? null;
        
        if ($faults) {
            $fault = $faults[0];
            $faultCode = (string) $fault->faultcode ?? null;
            $faultString = (string) $fault->faultstring ?? null;
            
            $CreditScoreEventLogs = new CreditScoreEventLogs;
            $CreditScoreEventLogs->enquiry_id = $enquiryId;
            $CreditScoreEventLogs->status = 'error';
            $CreditScoreEventLogs->name = 'ScoreSeeker Previous Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->team_size_id = $team_size_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->score_pdf = null;
            $CreditScoreEventLogs->is_error = 1;
            $CreditScoreEventLogs->error_string = $faultString;
            $CreditScoreEventLogs->save();
        
            Log::error("company_user_score_seeker_previous_enquiry Equifax SOAP Fault", [
                'faultcode' => $faultCode,
                'faultstring' => $faultString,
                'enquiry_id' => $enquiryId
            ]);
            
            return response()->json(['status' => 401, 'message' => $faultString, 'data' => '']);
            
        } else {
            
            $body = $xml->children($namespaces['soapenv'])->Body ?? null;
            $pe = $body->children($namespaces['pe'] ?? $namespaces['prev'] ?? [])->response ?? null;
        
            if (!$pe) {
                return response()->json(['status' => 401, 'message' => 'Invalid response format. PDF not found.', 'data' => '']);
            }
        
            $binaryData = (string)$pe->binaryData;
        
            if (empty($binaryData)) {
                return response()->json(['status' => 401, 'message' => 'No PDF data found in response.', 'data' => '']);
            }
        
            // Decode and store
            $pdf = base64_decode($binaryData);
            $fileName = 'company_user_score_seeker_enquiry_' . time() . '.pdf';
            $relativePath = "credit_score/$fileName";
            Storage::put("public/$relativePath", $pdf);
        
            CreditScoreEventLogs::where('id', $id)->update([
                'score_pdf' => '/credit_score/' . $fileName,
            ]);
            
            $CreditScoreEventLogs = new CreditScoreEventLogs;
            $CreditScoreEventLogs->enquiry_id = $enquiryId;
            $CreditScoreEventLogs->status = 'success';
            $CreditScoreEventLogs->name = 'ScoreSeeker Previous Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->team_size_id = $team_size_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->score_pdf = '/credit_score/' . $fileName;
            $CreditScoreEventLogs->save();
            
            return response()->json(['status' => 200, 'message' => 'Success', 'data' => '']);
            
        }
    }
    
}