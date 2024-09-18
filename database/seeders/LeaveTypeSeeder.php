<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeaveType::create([
            'code' => 'VL',
            'name' => 'Vacation Leave',
            'has_limit' => true,
            'limit' => 15,
        ]);

        LeaveType::create([
            'code' => 'SL',
            'name' => 'Sick Leave',
            'has_limit' => true,
            'limit' => 10,
        ]);

        LeaveType::create([
            'code' => 'ML',
            'name' => 'Maternity Leave',
            'has_limit' => false,
            'limit' => null,
        ]);

        LeaveType::create([
            'code' => 'PL',
            'name' => 'Paternity Leave',
            'has_limit' => false,
            'limit' => null,
        ]);

        LeaveType::create([
            'code' => 'EL',
            'name' => 'Emergency Leave',
            'has_limit' => true,
            'limit' => 5,
        ]);

        LeaveType::create([
            'code' => 'STL',
            'name' => 'Study Leave',
            'has_limit' => true,
            'limit' => 30,
        ]);

        LeaveType::create([
            'code' => 'CL',
            'name' => 'Compensatory Leave',
            'has_limit' => true,
            'limit' => 10,
        ]);
    }
}
