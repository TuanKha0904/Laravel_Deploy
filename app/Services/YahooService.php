<?php

namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class YahooService
{
    public function getLoginBaseUrl()
    {
        try {
            $url = config('yahoo.yahoo_authorize_uri') . '?';
            $url .= 'client_id=' . urlencode(env('YAHOO_APP_CLIENT_ID'));
            $url .= '&response_type=code';
            $url .= '&redirect_uri=' . urlencode(route('login.yahoo.callback'));
            $url .= '&scope=openid';
            $url .= '&nonce=111122233344';
            return $url;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function getYahooToken($code)
    {
        $client = new Client();
        $response = $client->post(config("yahoo.yahoo_access_token_uri"), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => route('login.yahoo.callback'),
                'client_id' => env('YAHOO_APP_CLIENT_ID'),
                'client_secret' => env('YAHOO_APP_CLIENT_SECRET')
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getUserProfile($token)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $client->get( config('yahoo.yahoo_profile_uri'), [
            'headers' => $headers
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}