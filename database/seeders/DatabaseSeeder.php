<?php

namespace Database\Seeders;

use App\Models\Employee; // تأكد من استدعاء موديل الموظف
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Employee::create([
            'employee_number' => 'EMP-2022-2004',
            'name'            => 'Admin',
            'email'           => 'admin@test.com',
            'password'        => Hash::make('123456789'), // ضع كلمة مرور مناسبة هنا
            'position'        => 'Manager',
            'salary'          => 50000000.00,
            'role'            => 'admin', // تأكد أن الحقل يقبل قيمة admin
        ]);
    }
}
