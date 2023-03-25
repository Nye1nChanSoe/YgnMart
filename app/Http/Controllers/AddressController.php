<?php

namespace App\Http\Controllers;

use App\Events\UpdateDefaultAddress;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        /** sometimes | required -> if the field is present, then validation rules are applied */
        $address = $request->validate([
            'label' => 'sometimes | required  | max:20',
            'street' => 'sometimes | required | max:32 ',   
            'ward' => 'sometimes | required | numeric | max:1000',
            'township' => 'sometimes | required | alpha | max:20',
        ]);

        $user = auth()->user();
        $address['user_id'] = $user->id;

        if(!Address::where('user_id', $user->id)->exists())
        {
            $address['is_default'] = true;
        }

        Address::create($address);
        return redirect()->route('profile', ['user' => $user->username])
            ->with('success', 'Your address has been added successfully');
    }

    public function update(Request $request)
    {
        if($request->input('default_update') ?? false) 
        {
            return $this->updateDefaultAddress($request);
        }

        $id = $request->input('id');
        $address = $request->validate([
            'label' => 'sometimes | required  | max:20',
            'street' => 'sometimes | required | max:32 ',   
            'ward' => 'sometimes | required | numeric | max:1000',
            'township' => 'sometimes | required | alpha | max:20',
        ]);

        Address::find($id)->update($address);
        return redirect()->route('profile', ['user' => auth()->user()->username])
            ->with('success', 'Address updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        Address::find($id)->delete();

        return redirect()->route('profile', ['user' => auth()->user()->username])
            ->with('success', 'Address removed successfully');
    }

    public function updateDefaultAddress(Request $request)
    {
        $id = $request->input('default_address');
        Address::find($id)->update(['is_default' => true]);

        return redirect()->back()
            ->with('success', 'Default address is changed successfully');
    }
}
