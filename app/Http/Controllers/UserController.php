<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile(User $user)
    {
        $orders = $user->orders()->latest()->get();

        return view('users.profile', compact('user', 'orders'));
    }

    public function edit(User $user)
    {
        $addresses = $user->addresses;

        return view('users.edit', compact('user', 'addresses'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $update = $request->input('update_type');

        if($update == 'info')
        {
            return $this->updateInfo($request, $user);
        }

        if($update == 'password')
        {
            return $this->updatePassword($request, $user);
        }
    }

    public function destroy()
    {
        User::find(auth()->id())->delete();
        
        auth()->logout();

        /** remove all the data from current session */
        session()->flush();

        return redirect()->route('login')->with('delete', 'Sad to see you go :(');
    }

    protected function updateInfo(Request $request, User $user)
    {
        $newUserInfo = $request->validate([
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id), 'max:18', 'regex:/^[a-zA-Z0-9_]+$/'],       // alphanumeric and underscore only
            'name' => ['required', 'max:32'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['required', Rule::unique('users', 'phone_number')->ignore($user->id), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
        ]);

        $user->update($newUserInfo);

        return redirect()->route('profile', ['user' => $user->username])->with('success', 'Your profile has been updated successfully');
    }

    protected function updatePassword(Request $request, User $user)
    {
        $newPassword = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        
        if (!Hash::check($request->input('old_password'), auth()->user()->password)) {
            return back()->withInput()->withErrors(['old_password' => 'Incorrect password']);
        }
        
        // If old password is correct, update the user's password
        $user->password = $newPassword['password'];
        $user->save();
        
        return redirect()->route('profile', ['user' => $user->username])->with('success', 'Password updated successfully');
    }
}
