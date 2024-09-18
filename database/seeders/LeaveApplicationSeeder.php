<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveApplication;

class LeaveApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeaveApplication::create([
            'employee_id' => 1,
            'name' => 'John Doe',
            'username' => 'johndoe',
            'leave_type' => 'VL',
            'start_date' => '2024-08-28',
            'end_date' => '2024-09-01',
            'start_half' => 'AM',
            'end_half' => 'PM',
            'number_of_days' => 4,
            'rejection_reason' => null,
            'reason' => 'Vacation trip to Hawaii',
            'total_leave' => 11,
            'status' => 'approved',
            'on_date' => '2024-08-27',
            'on_time' => '10:00:00',
        ]);

        LeaveApplication::create([
            'employee_id' => 2,
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'leave_type' => 'SL',
            'start_date' => '2024-09-05',
            'end_date' => '2024-09-07',
            'start_half' => 'PM',
            'end_half' => 'AM',
            'number_of_days' => 2.5,
            'rejection_reason' => null,
            'reason' => 'Feeling unwell',
            'total_leave' => 7.5,
            'status' => 'approved',
            'on_date' => '2024-09-04',
            'on_time' => '14:00:00',
        ]);

    }
}