<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAnalytic;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    use PhotoUploadTrait;

    /** dashboard */
    public function index()
    {
        $visitors = UserAnalytic::filter('day', false)->get();
        $uniqueVisitors = UserAnalytic::filter('day', true)->get();

        /** key => value pairs day => users */
        $activeData = $visitors->pluck('users', 'day');
        $viewData = $visitors->pluck('views', 'day');
        $uniqueActiveData = $uniqueVisitors->pluck('unique_users', 'day');
        $uniqueViewData = $uniqueVisitors->pluck('unique_views', 'day');

        return view('admins.index', compact([
            'visitors',
            'uniqueVisitors',
            'activeData',
            'viewData',
            'uniqueActiveData',
            'uniqueViewData'
        ]));
    }

    public function show(User $user)
    {
        return view('admins.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $update_type = $request->input('update_type');

        if($update_type == 'image')
        {
            return $this->uploadImage($request, $user);
        }

        if($update_type == 'info')
        {
            return $this->updateInfo($request, $user);
        }

        if($update_type == 'password')
        {
            return $this->updatePassword($request, $user);
        }
    }

    protected function updateInfo(Request $request, User $user)
    {
        $updatedInfo = $request->validate([
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id), 'max:18', 'regex:/^[a-zA-Z0-9_]+$/'],       // alphanumeric and underscore only
            'name' => ['required', 'max:32'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['required', Rule::unique('users', 'phone_number')->ignore($user->id), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
        ]);

        $user->update($updatedInfo);

        return redirect()->route('admin.show', $user->username)
            ->with('success', 'Your profile has been updated successfully');
    }

    protected function updatePassword(Request $request, User $user)
    {
        $updatedPassword = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return back()->withInput()->withErrors(['old_password' => 'Incorrect password']);
        }

        // If old password is correct, update the user's password
        $user->password = $updatedPassword['password'];
        $user->save();

        return redirect()->route('admin.show', $user->username)
            ->with('success', 'Password updated successfully');
    }

    public function uploadImage(Request $request, User $user)
    {
        if($request->image == null) 
        {
            return back()->with('error', 'Failed to upload new image');
        }

        $imageData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,webp,svg,jpg|max:2048|dimensions:max_width=2000,max_height=2000', // Maximum file size of 2 MB, maximum dimensions of 2000x2000 pixels, and only JPEG and PNG files allowed
        ]);

        $storagePath = $this->upload($imageData['image']);
        $user->update(['image' => $storagePath]);

        return redirect()->route('admin.show', $user->username)
            ->with('success', 'Profile Updated Successfully');
    }
}
