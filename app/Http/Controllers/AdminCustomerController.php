<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ParseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminCustomerController extends Controller
{
    use ParseTrait;

    public function index()
    {
        if(request()->filled('search')) {
            $customers = User::with('addresses')
                ->where('role', '<>', 'admin')
                ->latest()
                ->search($this->parseHyphens(request(['search'])))
                ->paginate(25);

            return view('admins.customers.index', compact('customers'));
        }

        $cache_key = 'admin:customer:' . User::count();
        $customers = Cache::remember($cache_key, '300', function() {
            return User::with('addresses')
                ->where('role', '<>', 'admin')
                ->latest()
                ->paginate(25);
        });
        return view('admins.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        return view('admins.customers.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $updateInfo = $request->validate([
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id), 'max:18', 'regex:/^[a-zA-Z0-9_]+$/'],       // alphanumeric and underscore only
            'name' => ['required', 'max:32'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['required', Rule::unique('users', 'phone_number')->ignore($user->id), 'regex:/^0\d{8,12}$/'],   // validate phone numbers that can contain leading 0, followed by 8 or 12 digits
        ]);

        $user->update($updateInfo);
        Cache::forget('admin:customer:' . $user->count());

        return redirect()->route('admin.customers.show', $user->username)
            ->with('success', "User {$user->name} updated");
    }

    public function destroy(Request $request, User $user)
    {
        if(!Hash::check($request->input('password'), auth()->user()->password)) {
            return back()->with('error', 'Incorrect password');
        }

        $user->delete();
        return redirect()->route('admin.customers')->with('success', "User {$user->name} removed");
    }
}
