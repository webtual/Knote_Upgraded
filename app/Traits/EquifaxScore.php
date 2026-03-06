<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\CreditScoreEventLogs;
use Illuminate\Support\Facades\Request;

trait EquifaxScore
{
    
    public function company_enquiry($application_id){
        
        $application_data = Application::find($application_id);
        
        $random = strtoupper(Str::random(8));
        
        $username = config('constants.equifax_username');
        $password = config('constants.equifax_password');
        
        $equifax_mode = config('constants.equifax_mode');
        if($equifax_mode == 0){
            $equifax_company_enquiry_url = config('constants.equifax_company_enquiry_test');
        }else{
            $equifax_company_enquiry_url = config('constants.equifax_company_enquiry_live');
        }
        
        Log::info('equifax_company_enquiry_url', ['request' => $equifax_company_enquiry_url]);

        $clientReference = $application_data->user->customer_no;
        $clientReferenceHeader = $random;
        $companyNumber = $application_data->abn_or_acn;
        $enquiryAmount = $application_data->amount_request;
        $accountType = 'L';
        $creditType = 'COMMERCIAL';
        $scoringRequired = 'yes';
        $enrichmentRequired = 'yes';
        $ppsrRequired = 'yes';

        $soapBody = <<<XML
<soapenv:Envelope xmlns:wsa="http://www.w3.org/2005/08/addressing" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:vh="http://vedaxml.com/soap/header/v-header-v1-8.xsd">
    <soapenv:Header>
        <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken>
                <wsse:Username>{$username}</wsse:Username>
                <wsse:Password>{$password}</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
        <wsa:To>https://vedaxml.com/sys2/company-enquiry-v3-2</wsa:To>
        <wsa:Action>http://vedaxml.com/companyEnquiry/ServiceRequest</wsa:Action>
    </soapenv:Header>
    <soapenv:Body>
        <cenq:request request-type="REPORT" client-reference="{$clientReferenceHeader}" xmlns:cenq="http://vedaxml.com/vxml2/company-enquiry-v3-2.xsd">
            <ns2:subject role="principal" xmlns:ns2="http://vedaxml.com/vxml2/company-enquiry-v3-2.xsd">
                <ns2:australian-company-number>{$companyNumber}</ns2:australian-company-number>
            </ns2:subject>
            <ns2:current-historic-flag xmlns:ns2="http://vedaxml.com/vxml2/company-enquiry-v3-2.xsd">current-and-historical</ns2:current-historic-flag>
            <ns2:enquiry type="credit-enquiry" xmlns:ns2="http://vedaxml.com/vxml2/company-enquiry-v3-2.xsd">
                <ns2:account-type code="{$accountType}">LEASING</ns2:account-type>
                <ns2:enquiry-amount currency-code="AUD">{$enquiryAmount}</ns2:enquiry-amount>
                <ns2:client-reference>{$clientReference}</ns2:client-reference>
            </ns2:enquiry>
            <ns2:collateral-information xmlns:ns2="http://vedaxml.com/vxml2/company-enquiry-v3-2.xsd">
                <ns2:credit-type>{$creditType}</ns2:credit-type>
                <ns2:scoring-required>{$scoringRequired}</ns2:scoring-required>
                <ns2:enrichment-required>{$enrichmentRequired}</ns2:enrichment-required>
                <ns2:ppsr-required>{$ppsrRequired}</ns2:ppsr-required>
            </ns2:collateral-information>
        </cenq:request>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        
        Log::info('company_enquiry Equifax SOAP request', ['request' => $soapBody]);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $equifax_company_enquiry_url,
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
        
        Log::info('company_enquiry Equifax SOAP response', ['response' => $response]);
        
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
        $body = $xml->children($namespaces['SOAP-ENV'] ?? '')->Body ?? null;
        
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
            $CreditScoreEventLogs->name = 'Company Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->is_error = 1;
            $CreditScoreEventLogs->error_string = $faultString;
            $CreditScoreEventLogs->score_pdf = null;
            $CreditScoreEventLogs->save();
            
        
            Log::error("company_enquiry Equifax SOAP Fault", [
                'faultcode' => $faultCode,
                'faultstring' => $faultString,
                'enquiry_id' => $enquiryId
            ]);
            
            return response()->json(['status' => 401, 'message' => $faultString, 'data' => '']);
        } else {
            
            $responseNode = $body ? $body->children($namespaces['cenq'] ?? '')->response ?? null : null;
            
            $enquiryId = null;
            $bureau_score = null;
            
            if ($responseNode) {
                $cenqChildren = $responseNode->children($namespaces['cenq'] ?? '');
            
                if (isset($cenqChildren->{'company-enquiry-report'}->{'organisation-report-header'}->{'request-id'})) {
                    $enquiryId = (string) $cenqChildren->{'company-enquiry-report'}->{'organisation-report-header'}->{'request-id'};
                }
                
                if (isset($cenqChildren->{'company-enquiry-report'}->{'company-response'}->{'score'}->{'bureau-score'})) {
                    $bureau_score = (string) $cenqChildren->{'company-enquiry-report'}->{'company-response'}->{'score'}->{'bureau-score'};
                }
                
            }
            
            Log::info('company_enquiry Equifax SOAP bureau_score', ['bureau_score' => $bureau_score]);
            
            Log::info('company_enquiry Equifax enquiryId', ['enquiryId' => $enquiryId]);
            
            $application_data = Application::find($application_id);
            $application_data->business_score = $bureau_score;
            $application_data->company_enquiry_at = now();
            $application_data->save();
            
            $CreditScoreEventLogs = new CreditScoreEventLogs;
            $CreditScoreEventLogs->enquiry_id = $enquiryId;
            $CreditScoreEventLogs->status = 'success';
            $CreditScoreEventLogs->score = $bureau_score;
            $CreditScoreEventLogs->name = 'Company Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->score_pdf = null;
            $CreditScoreEventLogs->save();
            
            Log::info('p_start_time', ['ST' => now()]);
            sleep(20);
            Log::info('p_end_time', ['ET' => now()]);
            $this->company_previous_enquiry($enquiryId, $application_id, $CreditScoreEventLogs->id);
            
            return response()->json(['status' => 200, 'message' => 'Success', 'data' => '']);
        }
    }
    
    public function company_previous_enquiry($enquiryId, $application_id, $id) {
        
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
        <vh:ConfigurationName>COMPANY-ENQUIRY</vh:ConfigurationName>     
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

        
        Log::info('company_previous_enquiry Equifax SOAP request', ['request' => $soapBody]);
        
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
        
        Log::info('company_previous_enquiry Equifax SOAP response', ['response' => $response]);
        
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
            $CreditScoreEventLogs->name = 'Company Previous Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->score_pdf = null;
            $CreditScoreEventLogs->is_error = 1;
            $CreditScoreEventLogs->error_string = $faultString;
            $CreditScoreEventLogs->save();
        
            Log::error("company_previous_enquiry Equifax SOAP Fault", [
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
            $fileName = 'company_previous_enquiry_' . time() . '.pdf';
            $relativePath = "credit_score/$fileName";
            Storage::put("public/$relativePath", $pdf);
        
            CreditScoreEventLogs::where('id', $id)->update([
                'score_pdf' => '/credit_score/' . $fileName,
            ]);
            
            $CreditScoreEventLogs = new CreditScoreEventLogs;
            $CreditScoreEventLogs->enquiry_id = $enquiryId;
            $CreditScoreEventLogs->status = 'success';
            $CreditScoreEventLogs->name = 'Company Previous Enquiry';
            $CreditScoreEventLogs->provider = 'Equifax';
            $CreditScoreEventLogs->application_id = $application_id;
            $CreditScoreEventLogs->ip_address = Request::ip();
            $CreditScoreEventLogs->request_information = $soapBody;
            $CreditScoreEventLogs->response_information = $response;
            $CreditScoreEventLogs->score_pdf = '/credit_score/' . $fileName;
            $CreditScoreEventLogs->save();
            
            return response()->json(['status' => 200, 'message' => 'Success', 'data' => '']);
            
        }
    }

}
