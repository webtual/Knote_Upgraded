<?php

namespace App\Traits;


trait AbnAcn
{
    function search_abn_acn($abn_acn_number, $type)
    {
		$type = ($type == 'ABN') ? 'SearchByABNv201408' : 'SearchByASICv201408';
       	$endpoint = "http://abr.business.gov.au/abrxmlsearch/AbrXmlSearch.asmx/".$type;
        $client = new \GuzzleHttp\Client();
        
        $response = $client->request('GET', $endpoint, ['query' => [
            'searchString' => $abn_acn_number, 
            'includeHistoricalDetails' => 'Y',
            'authenticationGuid' => config('constants.abn_acn_guid')
        ]]);
		
		$statusCode = $response->getStatusCode();
        if($statusCode == 200){
            $xml = simplexml_load_string($response->getBody());
            //$json = json_encode($xml);
            //$result = json_decode($json, TRUE);
            return json_encode(array('status' => 200, 'message' => 'Success', 'data' => $xml));
        }else{
            return json_encode(array('status' => 404, 'message' => 'Not Found'));
        }

    }

  




}
