<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 10; $i++){
            Employee::create([
                'name' => 'Nguyen Van A' . $i,
                'email' => 'a@a.com',
                'phone' => '0123456789',
                'address' => 'Ha Noi',
                'company_id' => random_int(1, 3), 
            ]);
        }
    }
}
