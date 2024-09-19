<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class UserController extends Controller
{
    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }
    
    // Display the user dashboard
    public function getDashUser()
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return view('user.user_dashboard');
        }

        return Redirect::route('user.login');
    }

    // Display the user profile page
    public function getProfile()
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return view('user.user_profile');
        }

        return Redirect::route('user.login');
    }

    // Update user profile information
    public function updateProfile(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            // Validate the incoming request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Fetch the authenticated user
            $user = Auth::user();

            // Update user's basic profile information
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('profile_pictures', $filename, 'public');
                $user->profile_picture = $path;
            }

            // Update other profile-related fields
            $user->start_date = $request->input('start_date');
            $user->end_date = $request->input('end_date');

            // Save the updated user profile
            $user->save();

            return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
        }

        return Redirect::route('user.login');
    }

    // Handle profile leave dates (specific logic for leave management)
    public function postProfileLeaveDates(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            $upperDates = $request->input('upper_date');
            $lowerDates = $request->input('lower_date');
            $userId = Auth::id();

            if ($upperDates && $lowerDates && $userId) {
                $totalDays = 0;
                $actualLeaveDates = [];

                $upperDate = Carbon::parse($upperDates);
                $lowerDate = Carbon::parse($lowerDates)->addDay();
                $period = CarbonPeriod::create($upperDate, '1 day', $lowerDate);

                $userLeaves = LeaveApplication::where('employee_id', $userId)->get();

                foreach ($userLeaves as $leave) {
                    $startD = Carbon::parse($leave->start_date);
                    $endD = Carbon::parse($leave->end_date)->addDay();
                    $periodLeaveDate = CarbonPeriod::create($startD, '1 day', $endD);

                    foreach ($period as $date) {
                        foreach ($periodLeaveDate as $leaveDate) {
                            if ($date->toDateString() === $leaveDate->toDateString()) {
                                $actualLeaveDates[] = $date->toDateString();
                                $totalDays++;
                            }
                        }
                    }
                }

                return view('user.user_profile')
                    ->with('total_days', $totalDays)
                    ->with('leaveDates', $actualLeaveDates);
            }
        }

        return Redirect::route('user.login');
    }

    // Get the leave count for the authenticated user
    public function getEachLeaveCount($userId, $leaveTypeId)
    {
        return $this->leaveService->getEachLeaveCount($userId, $leaveTypeId);
    }
}
