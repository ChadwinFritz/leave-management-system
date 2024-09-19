<?php

namespace App\Services;

use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class LeaveService
{
    public function getEachLeaveCount($userId, $leaveTypeId)
    {
        return Leave::where('user_id', $userId)
            ->where('leave_type_id', $leaveTypeId)
            ->count();
    }
}
