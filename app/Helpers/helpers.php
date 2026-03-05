<?php

if (!function_exists('getAddressDetails')) {
    function getAddressDetails($address){
        $apiKey = config('constants.google_map_api_key');

        $googleApiUrl = "https://maps.googleapis.com/maps/api/geocode/json";

        $url = $googleApiUrl . "?address=" . urlencode($address) . "&key=" . $apiKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            return [
                'success' => false,
                'message' => 'Error while calling Google API: ' . curl_error($ch),
            ];
        }

        curl_close($ch);

        $data = json_decode($response, true);
        
        //dd($data);

        if (isset($data['results'][0]['address_components'])) {
            $components = $data['results'][0]['address_components'];

            $addressDetails = [
                'street_number' => '',
                'street_name'   => '',
                'street_type'   => '',
                'locality'      => '',
                'state'         => '',
                'postcode'      => '',
            ];

            foreach ($components as $component) {
                if (in_array("street_number", $component['types'])) {
                    $addressDetails['street_number'] = $component['long_name'];
                }
                if (in_array("route", $component['types'])) {
                    $routeParts = explode(' ', $component['long_name']);
                    $addressDetails['street_name'] = implode(' ', array_slice($routeParts, 0, -1));
                    $addressDetails['street_type'] = end($routeParts);
                }
                if (in_array("locality", $component['types'])) {
                    $addressDetails['locality'] = $component['long_name'];
                }
                if (in_array("administrative_area_level_1", $component['types'])) {
                    $addressDetails['state'] = $component['short_name'];
                }
                if (in_array("postal_code", $component['types'])) {
                    $addressDetails['postcode'] = $component['long_name'];
                }
            }

            return [
                'success' => true,
                'data' => $addressDetails,
            ];
        }

        return [
            'success' => false,
            'message' => 'Unable to fetch address details. Please check the address.',
        ];
    }
}


if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($length = 12) {
        $slug = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/62))), 1, $length);
        return $slug;
    }
}

if ( ! function_exists('prep_url'))
{
    function prep_url($str = '')
    {
        if ($str === 'http://' OR $str === '')
        {
            return '';
        }
        $url = parse_url($str);
        if ( ! $url OR ! isset($url['scheme']))
        {
            return 'http://'.$str;
        }
        return $str;
    }
}

if (!function_exists('add_http')) {
    function add_http($slug){
        $ex = explode('-', $slug);
        return end($ex);
    }
}


if (!function_exists('get_id_in_slug')) {
    function get_id_in_slug($slug){
        $ex = explode('-', $slug);
        return end($ex);
    }
}


if (!function_exists('money_format_amount')) {
    function money_format_amount($value){
        return '$'.number_format($value);
    }
}

if (!function_exists('get_user_ip')) {
    function get_user_ip()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
}

 
if (!function_exists('message_phone_number')) {
    function message_phone_number($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);
        $phone = ltrim($phone, '0');
        return $phone;
    }
}


if (!function_exists('get_num_from_string')) {
    function get_num_from_string($string)
    {
        return preg_replace('/\D/', '', $string);
    }
}


if ( ! function_exists('cached_asset'))
{
    function cached_asset($path, $bustQuery = false)
    {
        // Get the full path to the asset.
        $realPath = public_path($path);
		// Get the last updated timestamp of the file.
        $timestamp = filemtime($realPath);
		return asset($path).'?v='.$timestamp;
    }
}


if ( ! function_exists('display_date_format'))
{
    function display_date_format($date)
    {
        if($date != ""){
    		return date('d-m-Y', strtotime($date));
    	}else{
    		return "";
    	}
	}
}

if ( ! function_exists('display_date_format_time'))
{
    function display_date_format_time($date)
    {
        if($date != ""){
    		return date('d-m-Y h:i A', strtotime($date));
    	}else{
    		return "";
    	}
	}
}


if ( ! function_exists('convert_date_format'))
{
    function convert_date_format($date)
    {
        if($date == ""){
            return "";
        }
        $ex_date = explode('-', $date);
        return $ex_date[2].'-'.$ex_date[1].'-'.$ex_date[0];
	}
}

if ( ! function_exists('indian_date_format'))
{
    function indian_date_format($date)
    {
        if($date == ""){
            return "";
        }
        $ex_date = explode('-', $date);
        return $ex_date[2].'-'.$ex_date[1].'-'.$ex_date[0];
	}
}


if ( ! function_exists('display_aus_phone'))
{
    function display_aus_phone($phone)
    {
        if($phone == ""){
            return "";
        }
        echo substr($phone, 0, 4).' '.substr($phone, 4, 3).' '.substr($phone,7);
	}
}

if ( ! function_exists('display_aus_landline'))
{
    function display_aus_landline($landline)
    {
        if($landline == ""){
            return "";
        }
        
        echo substr($landline, 0, 2).' '.substr($landline, 2, 4).' '.substr($landline,6);
        
        //echo substr($landline, 0, 4).' '.substr($landline, 4, 3).' '.substr($landline,7);
	}
}


if ( ! function_exists('sent_sms'))
{
    function sent_sms($phone, $text)
    {
        if($phone == ""){
            return "Please enter the phone.";
        }
        
        if(config('constants.sms_sent_flag') != 1){
            return "Please update the flag of sent sms.";
        }
        
        $phone = preg_replace('/\D/', '', $phone);
        $username = config('constants.sms_username');
        $password = config('constants.sms_password');
        $source   = config('constants.sms_source');
    	$http_url = config('constants.sms_url');
    	
    	
    	$ref = '';
    	$max_split = 4;
        $content =  'username='.rawurlencode($username).
                '&password='.rawurlencode($password).
                '&to='.rawurlencode($phone).
                '&from='.rawurlencode($source).
                '&message='.rawurlencode($text).
                '&maxsplit='.rawurlencode($max_split).
                '&ref='.rawurlencode($ref);
        $ch = curl_init($http_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec ($ch);
        curl_close ($ch);
		$response_lines = explode("\n", $output);
	    foreach($response_lines as $data_line){
	        $message_data = "";
	        $message_data = explode(':',$data_line);
	        if($message_data[0] == "OK"){
	            return "The message to ".$message_data[1]." was successful, with reference ".$message_data[2]."\n";
	        }elseif( $message_data[0] == "BAD" ){
	            return "The message to ".$message_data[1]." was NOT successful. Reason: ".$message_data[2]."\n";
	        }elseif( $message_data[0] == "ERROR" ){
	            return "There was an error with this request. Reason: ".$message_data[1]."\n";
	        }
	    }        
	}
}