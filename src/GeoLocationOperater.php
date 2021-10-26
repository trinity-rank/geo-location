<?php

namespace Trinityrank\GeoLocation;

use \Request;
use App\Models\Operater;

class GeoLocationOperater
{
    /*
    Test IP addresses
    uk - 185.44.76.168
    it - 185.217.71.4
    fr - 143.244.57.123
    */


    // This is default admin token
    public static function api_call($api_token)
    {
        // User IP address
        $user_ip = Request::ip();
        // Default "admin" api token
        $api_token = $api_token ?? "d1FfPSYIUxQIuPcQa6k3UJ8LvCnDVkLSYvAaPsSKTb44A6smrn2hz77kE7H85g8PhzmvHYpTAlZ0vxGw";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://geo-location.test/api/location', // localhost project
            CURLOPT_URL => 'http://143.198.178.43/api/location',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>'{
                "ip": "'. $user_ip .'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. $api_token,
                'Content-Type: application/json'
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }


    public static function list($decorators, $api_token = null)
    {
        // List of operaters ID
        $tableElements = json_decode($decorators);

        // START check do we need to use geolocation API
        $operaters_geolocation_settings = false;

        foreach($tableElements as $index => $element)
        {
            $operater = Operater::whereId($element)->get();
            if( !empty(json_decode($operater[0]['geolocation_countries'])) ) {
                $operaters_geolocation_settings = true;
            }
        }

        if($operaters_geolocation_settings == false) {
            return $tableElements;
        }
        // END check
        
        // Get information according to user IP
        $geolocation = self::api_call($api_token);
        
        // If no results from API then return all
        if( !isset(json_decode($geolocation)->country_code) ) {
            return $tableElements;
        }

        // Get country code from API
        $country_code = json_decode($geolocation)->country_code;

        // Geo location show or hide some operater
        foreach($tableElements as $index => $element)
        {
            $operater = Operater::whereId($element)->get();
            $geolocation_option = json_decode($operater[0]['geolocation_option']);
            $geolocation_countries = json_decode($operater[0]['geolocation_countries']);

            // 1 = Show in
            if( $geolocation_option == 1 && !in_array($country_code, $geolocation_countries ) )
            {
                unset( $tableElements[$index] );
            }
            
            // 2 = Never show in
            if( $geolocation_option == 2 && in_array($country_code, $geolocation_countries) )
            {
                unset( $tableElements[$index] );
            }

        }

        return $tableElements;
    }

}