<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use PhotoUploadTrait;

    public function profile(User $user)
    {
        $orders = $user->orders()->latest()->get();

        return view('users.profile', compact('user', 'orders'));
    }

    public function edit(User $user)
    {
        if($user->role == 'admin') 
        {
            return redirect()->route('admin.show', $user->username)->with('success', 'Redirected to Admin Panel');
        }

        $addresses = $user->addresses;

        return view('users.edit', compact('user', 'addresses'));
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

    public function destroy(User $user)
    {
        $user->delete();
        auth()->logout();

        /** remove all the data from current session */
        session()->flush();

        return redirect()->route('login')
            ->with('delete', 'Sad to see you go :(');
    }

    protected function updateInfo(Request $request, User $user)
    {
        $updateInfo = $request->validate([
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id), 'max:18', 'regex:/^[a-zA-Z0-9_]+$/'],       // alphanumeric and underscore only
            'name' => ['required', 'max:32'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['required', Rule::unique('users', 'phone_number')->ignore($user->id), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
        ]);

        $user->update($updateInfo);

        return redirect()->route('profile', $user->username)
            ->with('success', 'Profile Updated Successfully');
    }

    protected function updatePassword(Request $request, User $user)
    {
        $updatePassword = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return back()->withInput()->withErrors(['old_password' => 'Incorrect password']);
        }

        // If old password is correct, update the user's password
        $user->password = $updatePassword['password'];
        $user->save();

        return redirect()->route('profile', $user->username)
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

        return redirect()->route('profile', $user->username)
            ->with('success', 'Profile Updated Successfully');
    }
}
