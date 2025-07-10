<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Timesheet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create some regular employees
        $employee1User = User::create([
            'name' => 'John Employee',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $employee2User = User::create([
            'name' => 'Jane Employee',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create employee records
        $employee1 = Employee::create([
            'user_id' => $employee1User->id,
            'employee_id' => 'EMP0001',
            'first_name' => 'John',
            'last_name' => 'Employee',
            'position' => 'Software Developer',
            'department' => 'IT',
            'phone' => '555-123-4567',
            'is_active' => true,
        ]);

        $employee2 = Employee::create([
            'user_id' => $employee2User->id,
            'employee_id' => 'EMP0002',
            'first_name' => 'Jane',
            'last_name' => 'Employee',
            'position' => 'HR Specialist',
            'department' => 'Human Resources',
            'phone' => '555-987-6543',
            'is_active' => true,
        ]);

        // Create some timesheet entries for John
        // Yesterday's completed timesheet
        Timesheet::create([
            'employee_id' => $employee1->id,
            'clock_in' => Carbon::yesterday()->setHour(9)->setMinute(0),
            'clock_out' => Carbon::yesterday()->setHour(17)->setMinute(0),
            'status' => 'completed'
        ]);

        // Today's active timesheet
        Timesheet::create([
            'employee_id' => $employee1->id,
            'clock_in' => Carbon::today()->setHour(9)->setMinute(0),
            'status' => 'active'
        ]);

        // Create some timesheet entries for Jane
        // Previous week timesheets
        for ($i = 5; $i >= 1; $i--) {
            Timesheet::create([
                'employee_id' => $employee2->id,
                'clock_in' => Carbon::now()->subDays($i)->setHour(8)->setMinute(30),
                'clock_out' => Carbon::now()->subDays($i)->setHour(16)->setMinute(30),
                'status' => 'completed'
            ]);
        }
    }
}
