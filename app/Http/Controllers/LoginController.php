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
    protected $employees;

    public function __construct(YahooService $yahooService, TwitterService $twitterService)
    {
        $this->yahooService = $yahooService;
        $this->twitterService = $twitterService;
    }
    public function index(Request $request)
    {
        // $yahooUrl = $this->yahooService->getLoginBaseUrl();
        // $twitterUrl = $this->twitterService->getLoginBaseUrl();
        $request->validate([
            'inputSearch' => [
                'required_if:option,1,2,3,4', 
            ],[
                'inputSearch.required_if' => 'Vui lý nhập thể tìm kiếm',
            ]
        ]);
        try {
            $companies = Company::all();
            $query = Employee::query(); // Sử dụng phương thức query() để tạo một đối tượng truy vấn mặc định
            if (request()->filled('company_id')) {
                $query->where('id', request()->company_id);
            }
            // Truy vấn theo các tùy chọn tìm kiếm nếu có
            if (request()->filled('option') && request()->filled('inputSearch')) {
                switch (request()->option) {
                    case '1':
                        $query->where('id', 'like', '%' . request()->inputSearch . '%');
                        break;
                    case '2':
                        $query->where('name', 'like', '%' . request()->inputSearch . '%');
                        break;
                    case '3':
                        $query->where('email', 'like', '%' . request()->inputSearch . '%');
                        break;
                    case '4':
                        $query->where('address', 'like', '%' . request()->inputSearch . '%');
                        break;
                    default:
                        break;
                }
            }
            // Thực hiện truy vấn và lấy kết quả
            $employees = $query->paginate(10);
            return view('layouts.app')
                ->with('companies', $companies)
                ->with('employees', $employees);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function yahooLogin(Request $request)
    {
        $code = $request->code;
        $token = $this->yahooService->getYahooToken($code);
        $profile = $this->yahooService->getUserProfile($token['access_token']);
        dd($profile);
    }

    public function twitterLogin(Request $request)
    {
        $code = $request->code;
        $token = $this->twitterService->getTwitterToken($code);
        $profile = $this->twitterService->getUserProfile($token['access_token']);
        dd($profile);
    }
}
