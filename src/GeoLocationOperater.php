<?php

namespace Trinityrank\GeoLocation;

use \Request;
use App\Models\Operater;
use Illuminate\Support\Facades\Http;

class GeoLocationOperater
{
    /*
    API: https://ip-api.com/
    Usage: http://ip-api.com/json/24.48.0.1
    For more options see: https://ip-api.com/docs/api:json
    -----------------
    Test IP addresses
    uk - 185.44.76.168
    it - 185.217.71.4
    fr - 143.244.57.123
    */

    public static function api_call()
    {
        /**
         * @return object
         */
        // User IP address
        $user_ip = Request::ip() ?? '184.169.250.146';
        // $user_ip = '185.217.71.4';
        return Http::get("http://ip-api.com/json/" . $user_ip . "?fields=status,countryCode");
    }


    public static function list($operaters_id)
    {
        // List of operaters ID
        // $operaters_id = json_decode($operaters_id);

        // START check do we need to use geolocation API
        $operaters_geolocation_settings = false;

        foreach ($operaters_id as $index => $element) {
            $operater = Operater::whereId($element)->get();
            if (!empty(json_decode($operater[0]['geolocation_countries']))) {
                $operaters_geolocation_settings = true;
            }
        }

        if ($operaters_geolocation_settings == false) {
            return $operaters_id;
        }
        // END check

        // Get information according to user IP
        $geolocation = self::api_call();
        // If no results from API then return all

        if (!isset(json_decode($geolocation)->countryCode)) {
            return $operaters_id;
        }

        // Get country code from API
        $country_code = json_decode($geolocation)->countryCode;

        // Geo location show or hide some operater
        foreach ($operaters_id as $index => $element) {
            $operater = Operater::whereId($element)->get();
            $geolocation_option = json_decode($operater[0]['geolocation_option']);
            $geolocation_countries = json_decode($operater[0]['geolocation_countries']);

            // 1 = Show in
            if ($geolocation_option == 1 && !in_array($country_code, $geolocation_countries)) {
                unset($operaters_id[$index]);
            }

            // 2 = Never show in
            if ($geolocation_option == 2 && in_array($country_code, $geolocation_countries)) {
                unset($operaters_id[$index]);
            }
        }

        return $operaters_id;
    }
}
