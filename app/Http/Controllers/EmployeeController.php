<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        $company = Company::all();
        $employees = Employee::all();
        return view('employees', compact('company', 'employees'));
    }
}
