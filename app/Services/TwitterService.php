<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class TwitterService
{
    public function getLoginBaseUrl()
    {
        try {
            $url = config('twitter.twitter_authorize_uri') . '?';
            $url .= 'response_type=code';
            $url .= '&client_id=' . env('TWITTER_APP_CLIENT_ID');
            $url .= '&redirect_uri=' . route('login.twitter.callback');
            $url .= '&scope=tweet.read%20users.read';
            $url .= '&state=state';
            $url .= '&code_challenge=challenge';
            $url .= '&code_challenge_method=plain';
            return $url;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTwitterToken($code)
    {
        $client = new Client();
        $response = $client->post(config('twitter.twitter_token_uri'), [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',  
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => route('login.twitter.callback'),
                'client_id' => env('TWITTER_APP_CLIENT_ID'),
                'code_verifier' => 'challenge'
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getUserProfile($token)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
        $response = $client->get(config('twitter.twitter_profile_uri'), [
            'headers' => $headers,
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
