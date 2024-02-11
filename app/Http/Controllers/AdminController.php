<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    } // End Method
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } // End Method

    public function AdminLogin()
    {
        return view('admin.admin_login');
    } // End Method

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    } // End Method

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        // Check if image is present in the request
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $imageName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $imageName);
            $data['photo'] = $imageName;
        }
        dd($data);
        $data->save();
        return redirect()->back()->with('success', 'Profile updated successfully');
    } // End Method

    public function AdminProfileUpdate(Request $request, $id)
    {
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        // Check if image is present in the request
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $imageName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $imageName);
            $data->photo = $imageName;
        }
        $data->save();
        $notification = array(
            'message' => 'Admin Profile Update Successfully',
            'alert-type' => "success"
        );
        return redirect()->back()->with($notification);
    } // End Method

    public function AdminChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    } // End Method

    public function AdminUpdatePassword(Request $request)
    {
        // Validation 
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password', 
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            $notification = array(
                'message' => "Old password doesn't match",
                'alert-type' => "error"
            );
            return back()->with($notification);
        }

        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        $notification = array(
            'message' => "Password changed successfully",
            'alert-type' => "success"
        );
        return back()->with($notification);
    }
}
