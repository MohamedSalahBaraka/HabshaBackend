<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $user = User::where('phone', $request->input('phone'))->first();
        // return "we here";


        if (is_null($user)) {
            return response()->json([
                'phone' => 'رقم الهاتف غير صحيح',
                'password' => "",
                'type' => "",
            ], 422);
        }
        if (!Hash::check($request->string('password'), $user->password)) {
            return response()->json([
                'password' => 'كلمة السر خاطئة',
                'phone' => "",
                'type' => "",
            ], 422);
        }
        if ($request->string('type') != $user->type) {
            return response()->json([
                'password' => '',
                'phone' => "",
                'type' => "المستخدم مسجل لتطبيق آخر",
            ], 422);
        }
        $token = $user->createToken('apiToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        // $user = User::find(auth()->id());
        auth('sanctum')->user()->currentAccessToken()->delete();
        return response()->json(['message' => "you log out secssfuly"]);
    }
    public function user()
    {
        $user = User::find(auth()->id());
        return response()->json(['user' => $user]);
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => ['required', 'unique:users'],
        ], [
            'required' => "هذا الحقل مطلوب :attribute",
            'unique' => "رقم الهاتف محوز من قبل شخص آخر",
        ]);
    }
    public function register(Request $data)
    {

        $this->validator($data->all())->validate();
        $user = User::create([
            'name' => $data->input('name'),
            'phone' => $data->input('phone'),
            'type' => 'user',
            'password' => Hash::make($data->input('password')),
        ]);
        $token = $user->createToken('apiToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}