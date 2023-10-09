<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Delivary;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ModelSort, Upload;
    public function changePassword(Request $request)
    {

        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json(['message' => 'كلمة السر التي كتبتها لم تتوافق مع كلمة السر القديمة'], 403);
        }
        #Update the new Password
        User::find(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return response()->json(['message' => "تم تحديث كلمة السر بنجاح"]);
    }


    public function updateInfo(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $userw = User::where('phone', $request->input('phone'))->first();
        abort_if(!is_null($userw) && $user->id !== $userw->id, 422, 'رقم الهاتف مسجل لحساب آخر');
        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);
        if ($user->type == 'restaurant') {
            $path = $this->photoUploader($request);
            if (!is_null($path)) {
                $this->deleteFile($user->photo);
                $user->photo = $path;
                $user->save();
            }
        }
        return response()->json(['message' => 'تم الحفظ بنجاح']);
    }
    public function addresslist(Request $request)
    {
        $addresses = collect();
        $addresses = Address::whereHas('delivary', function ($q) {
            $q->where('delivaries.user_id', auth()->id());
        })->orWhereHas('delivarysent', function ($q) {
            $q->where('delivaries.user_id', auth()->id());
        });
        $addresses = $addresses->distinct('neighbourhood')->with(['city'])->get();
        return response()->json(['addresses' => $addresses]);
    }
    public function getAddress(Request $request)
    {
        abort_if(!request()->has('type'), 500, 'something is off');
        $user = User::find(auth()->id());
        $cities = City::all();
        $type = $request->string('type');
        $add = Address::find($user->$type);
        return response()->json(['address' => $add, 'cities' => $cities]);
    }
    public function getAddressDelivary()
    {
        $user = User::find(auth()->id());
        $address = $user->address;
        $addressSent = $user->addressSent;
        $cities = City::all();
        return response()->json(['address' => $address, 'cities' => $cities, 'addressSent' => $addressSent]);
    }
    public function getAddressFood()
    {
        $user = User::find(auth()->id());
        $address = $user->addressFood;
        $cities = City::all();
        return response()->json(['address' => $address, 'cities' => $cities,]);
    }
    public function updateAddress(Request $request)
    {
        abort_if(!request()->has('type'), 500, 'something is off');
        $user = User::find(auth()->id());
        $type = $request->input('type');
        $address = $user->$type;
        if (is_null($address)) {
            $address = Address::create([
                'name' => $request->input('name'),
                'neighbourhood' => $request->input('neighbourhood'),
                'city_id' => $request->input('city'),
                'details' => $request->input('details'),
                'phone' => $request->input('phone'),
            ]);
            $user->$type = $address->id;
            $user->save();
        } else {
            $address = Address::find($address)->update([
                'name' => $request->input('name'),
                'neighbourhood' => $request->input('neighbourhood'),
                'city_id' => $request->input('city'),
                'details' => $request->input('details'),
                'phone' => $request->input('phone'),
            ]);
        }
        return response()->json(['message' => 'تم الحفظ بنجاح']);
    }

}