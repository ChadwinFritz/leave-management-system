<?php 

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminLeaveTypeController extends Controller
{
    /**
     * Display the list of leave types.
     */
    public function index()
    {
        $leaveTypes = LeaveType::all();
        return view('admin.leave_types.index', ['leaveTypes' => $leaveTypes]);
    }

    /**
     * Show the form to add a new leave type.
     */
    public function create()
    {
        return view('admin.leave_types.create');
    }

    /**
     * Store a new leave type.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'leavedays' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.leave_types.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        LeaveType::create([
            'type' => $request->input('type'),
            'leavedays' => $request->input('leavedays'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.leave_types.index');
    }

    /**
     * Show the form to edit an existing leave type.
     */
    public function edit($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        return view('admin.leave_types.edit', ['leaveType' => $leaveType]);
    }

    /**
     * Update an existing leave type.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'leavedays' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.leave_types.edit', ['id' => $id])
                             ->withErrors($validator)
                             ->withInput();
        }

        $leaveType = LeaveType::findOrFail($id);
        $leaveType->update([
            'type' => $request->input('type'),
            'leavedays' => $request->input('leavedays'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.leave_types.index');
    }

    /**
     * Delete a leave type.
     */
    public function destroy($id)
    {
        LeaveType::destroy($id);
        return redirect()->route('admin.leave_types.index');
    }

    /**
     * Display a listing of leave types.
     *
     * @return \Illuminate\Http\Response
     */
    public function listLeaveTypes()
    {
        // Fetch all leave types from the database
        $leaveTypes = LeaveType::all();

        // Return the view with leave types data
        return view('admin.leave_types', ['leaveTypes' => $leaveTypes]);
    }
}
