<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leave;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Leave::create([
            'employee_id' => 1,
            'username' => 'johndoe',
            'application_id' => 'uuid-1',
            'total_leave' => 5,
            'start_date' => '2024-08-28',
            'end_date' => '2024-09-01',
            'start_half' => 'AM',
            'end_half' => 'PM',
            'on_date' => '2024-08-27',
            'on_time' => '10:00:00',
            'leave_type' => 'VL',
        ]);

        Leave::create([
            'employee_id' => 2,
            'username' => 'janesmith',
            'application_id' => 'uuid-2',
            'total_leave' => 3,
            'start_date' => '2024-09-05',
            'end_date' => '2024-09-07',
            'start_half' => 'PM',
            'end_half' => 'AM',
            'on_date' => '2024-09-04',
            'on_time' => '14:00:00',
            'leave_type' => 'SL',
        ]);

    }
}