<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Inertia\Inertia;


class EmployeeController extends Controller
{
    public function index(){
        $company = Company::all();
        $employees = Employee::all();
        return Inertia::render('/', [
            'companies' => $company,
            'employees' => $employees
        ]);
    }
}
