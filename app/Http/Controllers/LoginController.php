<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Services\YahooService;
use App\Services\TwitterService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $yahooService;
    protected $twitterService;

    public function __construct(YahooService $yahooService, TwitterService $twitterService){
        $this->yahooService = $yahooService;
        $this->twitterService = $twitterService;
    }
    public function index(Request $request){
        // $yahooUrl = $this->yahooService->getLoginBaseUrl();
        // $twitterUrl = $this->twitterService->getLoginBaseUrl();
        $company = Company::all();
        $employees = Employee::all();
        return view('layouts.app', compact('company', 'employees'));
    }

    public function yahooLogin(Request $request){
        $code = $request->code;
        $token = $this->yahooService->getYahooToken($code);
        $profile = $this->yahooService->getUserProfile($token['access_token']);
        dd($profile);
    }

    public function twitterLogin(Request $request){
        $code = $request->code;
        $token = $this->twitterService->getTwitterToken($code);
        $profile = $this->twitterService->getUserProfile($token['access_token']);
        dd($profile);
    }
}
