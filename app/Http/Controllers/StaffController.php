<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index()
    {
        $privileges = \App\Models\Privilege::all();
        return view('staff.index', compact('privileges'));
    }

    public function apiIndex()
    {
        $staffList = Staff::where('user_id', Auth::id())->get();
        
        $staffList->transform(function ($staff) {
            $staff->is_active = $staff->session_id && $staff->last_active_at && \Carbon\Carbon::parse($staff->last_active_at)->diffInMinutes(now()) <= 15;
            return $staff;
        });

        return response()->json($staffList);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'role' => 'required|string',
            'privileges' => 'nullable|array',
        ]);

        $staff = Staff::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'privileges' => $request->privileges ?? [],
            'otp' => null, // OTP will be generated during login process if implemented later
        ]);

        return response()->json(['success' => true, 'staff' => $staff]);
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,'.$staff->id,
            'role' => 'required|string',
            'privileges' => 'nullable|array',
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'privileges' => $request->privileges ?? [],
        ]);

        return response()->json(['success' => true, 'staff' => $staff]);
    }

    public function destroy($id)
    {
        $staff = Staff::where('user_id', Auth::id())->findOrFail($id);
        $staff->delete();

        return response()->json(['success' => true, 'message' => 'Staff deleted successfully.']);
    }

    public function saveOtp(Request $request, $id)
    {
        $staff = Staff::where('user_id', Auth::id())->findOrFail($id);
        $staff->update([
            'otp' => $request->otp
        ]);

        return response()->json(['success' => true]);
    }

    public function forceLogout($id)
    {
        $staff = Staff::where('user_id', Auth::id())->findOrFail($id);
        
        $staff->update([
            'session_id' => null,
            // We can leave last_active_at as is, since session_id being null will mark them offline
        ]);

        return response()->json(['success' => true, 'message' => 'Staff member has been logged out.']);
    }
}
