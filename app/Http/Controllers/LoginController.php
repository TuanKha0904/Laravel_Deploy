<?php

namespace App\Http\Controllers;

use App\Services\YahooService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $yahooService;

    public function __construct(YahooService $yahooService){
        $this->yahooService = $yahooService;
    }
    public function index(Request $request){
        $yahooUrl = $this->yahooService->getLoginBaseUrl();
        return view('welcome', compact('yahooUrl'));
    }

    public function dashBoard(){
        return view('dashboard');
    }

    public function yahooLogin(Request $request){
        $code = $request->code;
        $token = $this->yahooService->getYahooToken($code);
        $profile = $this->yahooService->getUserProfile($token['access_token']);
        dd($profile);
    }
}
