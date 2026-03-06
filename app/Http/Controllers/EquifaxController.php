<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Application;
use App\Models\CreditScoreEventLogs;
use Carbon\Carbon;
use App\Jobs\IncompleteLoanApplication;
use App\Jobs\DeuDateLoanApplication;
use Illuminate\Support\Facades\Storage;

class EquifaxController extends Controller
{
    
    public function company_enquiry(Request $request){
        // Dynamic request input values
        $username = config('constants.equifax_username');
        $password = config('constants.equifax_password');
        
        $clientReference = $request->input('client_reference', 'Myref01V360');
        $clientReferenceHeader = $request->input('client_reference_header', 'Myref01');
        $companyNumber = $request->input('australian_company_number', '006261623');
        $enquiryAmount = $request->input('enquiry_amount', '4000');
        $accountType = 'L';
        $creditType = 'COMMERCIAL';
        $scoringRequired = 'yes';
        $enrichmentRequired = 'yes';
        $ppsrRequired = 'yes';

    // Build SOAP XML
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

    // cURL request
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://ctaau.vedaxml.com/cta/sys2/company-enquiry-v3-2',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $soapBody,
        CURLOPT_HTTPHEADER => [
            'Content-Type: text/xml;charset=UTF-8'
        ],
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return response()->json(['status' => 'error', 'message' => $error], 500);
    }

    // Load XML and parse the request-id
    $xml = simplexml_load_string($response);
    if (!$xml) {
        return response()->json(['status' => 'error', 'message' => 'Invalid XML response'], 500);
    }

    $namespaces = $xml->getNamespaces(true);
    $body = $xml->children($namespaces['soapenv'] ?? '')->Body ?? null;
    $responseNode = $body ? $body->children($namespaces['cenq'] ?? [])->response ?? null : null;

    $requestId = $responseNode->children($namespaces['cenq'] ?? [])->{'request-id'} ?? null;

    return response()->json([
        'status' => 'success',
        'request_id' => (string) $requestId,
        'raw_xml' => $response
    ]);
}

    public function company_previous_enquiry() {
    $soapBody = <<<'XML'
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:prev="http://vedaxml.com/vxml2/previous-enquiry-v1-0.xsd" xmlns:wsa="http://www.w3.org/2005/08/addressing" xmlns:vh="http://vedaxml.com/soap/header/v-header-v1-9.xsd">
    <soapenv:Header>
        <wsse:Security mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken>
                <wsse:Username>kltH7ChOja</wsse:Username>
                <wsse:Password>bi$LS4C3LB</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
        <wsa:To>https://vedaxml.com/sys2/previous-enquiry-v1</wsa:To>     
        <vh:ConfigurationName>COMPANY-ENQUIRY</vh:ConfigurationName>     
        <wsa:Action>http://vedaxml.com/previousEnquiry/ServiceRequest</wsa:Action>
    </soapenv:Header>
    <soapenv:Body>
        <prev:request>
            <prev:enquiryId>250519-F046D-95424</prev:enquiryId>
            <prev:contentType>application/pdf</prev:contentType>
        </prev:request>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $ch = curl_init();
    
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://ctaau.apiconnect.equifax.com.au/cta/sys2/previous-enquiry-v1',
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
                'Cookie: TS01d9be90=01832fa6b96b5aed9d390a270da6011625c911b7e854ae1b3f21221c4a1d4af79a9a7dc394c440b548abee3250221541395edfb938'
            ],
        ]);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => $error_msg], 500);
        }
    
        curl_close($ch);
    
        // Parse XML
        $xml = simplexml_load_string($response);
        $namespaces = $xml->getNamespaces(true);
    
        $body = $xml->children($namespaces['soapenv'])->Body ?? null;
        $pe = $body->children($namespaces['pe'] ?? $namespaces['prev'] ?? [])->response ?? null;
    
        if (!$pe) {
            return response()->json(['error' => 'Invalid response format. PDF not found.'], 500);
        }
    
        $binaryData = (string)$pe->binaryData;
    
        if (empty($binaryData)) {
            return response()->json(['error' => 'No PDF data found in response.'], 404);
        }
    
        // Decode and store
        $pdf = base64_decode($binaryData);
        $fileName = 'company_previous_enquiry_' . time() . '.pdf';
        $relativePath = "credit_score/$fileName";
        Storage::put("public/$relativePath", $pdf);
    
        // Save to model or use the path
        // $data->document_file = '/credit_score/' . $fileName;
    
        // Option 1: Download the file
        // $fullPath = storage_path('app/public/' . $relativePath);
        // return response()->download($fullPath)->deleteFileAfterSend(true);
    
        // Option 2: Return public URL (recommended for API use)
        return response()->json([
            'message' => 'PDF stored successfully.',
            'file_url' => asset('storage/' . $relativePath),
            'file_path' => '/credit_score/' . $fileName
        ]);
    }

    
}
   
