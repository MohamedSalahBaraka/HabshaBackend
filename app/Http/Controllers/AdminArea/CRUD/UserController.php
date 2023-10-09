<?php

namespace App\Http\Controllers\AdminArea\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Delivary;
use App\Models\Order;
use App\Notifications\CustomNotification;
use App\Traits\ControllerNOTrait;
use App\Traits\ControllerTrait;
use App\Traits\ModelSort;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Upload, ModelSort;
    private $key = 'user';
    private $keys = 'users';
    private $user;
    private $unauthorizeMessage = "You Are Not Authorize For This Action";
    private $class = User::class;
    private $path = 'AdminArea.CRUD.User.';
    private $fillable = [
        'name',
        'phone',
    ];
    private function validator(array $data, $photo = false)
    {
        $photovaldation = ['image'];
        if ($photo)
            $photovaldation[] = 'required';
        return Validator::make($data, [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'phone' => ['required'],
            'password' => ['confirmed'],
            'photo' => $photovaldation,
        ], [
            'required' => "هذا الحقل مطلوب :attribute",
            'unique' => "رقم الهاتف محوز من قبل شخص آخر",
            'image' => 'قمت باختيار ملف ليس بصورة',
            'email' => 'يجب ان يكون ايميل صحيح',
            'min' => 'يجب ان لا تقل كلمة السر عن 8 حروف',
            'confirmed' => 'يجب ان تكون كلمة السر مطابقة للتأكيد'
        ]);
    }
    public function construct()
    {
        $this->user = auth()->user();
        abort_if(!$this->user->type === 'admin', 403, $this->unauthorizeMessage);
    }
    public function Data(Request $request)
    {
        $this->construct();
        abort_if(!$request->has('type'), 500, 'something is off');
        $users = User::where('type', $request->string('type'));
        $vars = $this->sortData($request, $users);
        $vars['title'] = 'البيانات المتاحة';
        $vars['type'] = $request->string('type');
        return view($this->path . 'View', $vars);
    }
    public function notifications()
    {
        abort_if(!request()->has('type'), 500, 'something is off');
        $var = ['type' => request()->string('type')];
        return view($this->path . 'notifications', $var);
    }
    public function sendNotifications()
    {
        abort_if(!request()->has('type'), 500, 'something is off');
        abort_if(!request()->has('body'), 500, 'something is off');
        abort_if(!request()->has('title'), 500, 'something is off');
        $users = User::where('type', request()->string('type'))->get();
        Notification::send($users, new CustomNotification(request()->string('title'), request()->string('body')));
        return back()->with('success', 'send successfully');
    }
    public function model(Request $request)
    {
        $this->construct();
        abort_if(!request()->has('view'), 500, 'something is off');
        $view = request()->string('view');
        if (!request()->has('id')) {
            $cities = City::all();
            $var = ['type' => request()->string('type'), 'cities' => $cities];
            return view($this->path . 'Create', $var);
        }
        $class = new $this->class;
        $model = $class::find(request()->integer('id'));
        if ($view == 'Show')
            return view($this->path . 'Show', [$this->key => $model]);
        if (method_exists($this, 'createOrEditAdditionalData')) {
            $var = $this->createOrEditAdditionalData([$this->key => $model]);
        } else {
            $var = [$this->key => $model];
        }
        return view($this->path . 'Edit', $var);
    }

    /**
     * Display a listing of the resource that has been archive.
     *
     */

    public function ParmentlyDelete($id)
    {
        $this->construct();
        $class = new $this->class;
        $model = $class::find($id);
        $this->parmentlyDeleteModel($model, true);
        return back()->with('success', 'Deleted successfully');
    }

    public function store(Request $request)
    {
        $this->construct();
        $this->validator($request->all())->validate();
        $path = $this->photoUploader($request);
        // dd($request->hasFile('photo'));
        $class = new $this->class;
        $model = $class::create($this->fillingAray($request, $path, ['type'], ['password' => Hash::make($request->input('password'))]));
        if ($model->type == 'restaurant') {
            $address = [
                'name' => $request->input('nameaddress'),
                'neighbourhood' => $request->input('neighbourhood'),
                'city_id' => $request->input('city'),
                'details' => $request->input('details'),
                'phone' => $request->input('phoneaddress'),
            ];
            $address = Address::create($address);
            $model->address_id = $address->id;
            $model->fee = $request->input('fee');
            $model->opening = $request->input('opening');
            $model->clothing = $request->input('clothing');
            $model->save();
        }
        return back()->with('success', 'Saved successfully');
    }
    public function Update(Request $request)
    {
        $this->construct();
        $this->validator($request->all())->validate();
        $class = new $this->class;
        $model = $class::find($request->input('id'));
        if (is_null($model)) {
            return back()->with('error', 'Error, try again');
        }
        $path = $this->photoUploader($request);
        if ($request->has('password') && $request->input('password') != '') {
            $model->update(['password' => Hash::make($request->input('password')),]);
        }
        if (!is_null($path))
            $this->deleteFile($model->photo);
        $model->update($this->fillingAray($request, $path));
        if ($model->type == 'restaurant') {
            $model->fee = $request->input('fee');
            $model->opening = $request->input('opening');
            $model->clothing = $request->input('clothing');
            $model->save();
        }
        return back()->with('success', 'Saved successfully');
    }
    public function addressStore(Request $request)
    {
        $this->construct();
        $user = User::whereId(request()->integer('id'))->first();
        $address = [
            'name' => $request->input('name'),
            'neighbourhood' => $request->input('neighbourhood'),
            'city_id' => $request->input('city'),
            'details' => $request->input('details'),
            'phone' => $request->input('phone'),
        ];
        $addressSent = [
            'name' => $request->input('nameSent'),
            'neighbourhood' => $request->input('neighbourhoodSent'),
            'city_id' => $request->input('citySent'),
            'details' => $request->input('detailsSent'),
            'phone' => $request->input('phoneSent'),
        ];
        $addressFood = [
            'name' => $request->input('nameFood'),
            'neighbourhood' => $request->input('neighbourhoodFood'),
            'city_id' => $request->input('cityFood'),
            'details' => $request->input('detailsFood'),
            'phone' => $request->input('phoneFood'),
        ];
        if (is_null($user->address)) {
            $address = Address::create($address);
            $user->address_id = $address->id;
        } else {
            $user->address->update($address);
        }
        if (is_null($user->addressSent)) {
            $address = Address::create($addressSent);
            $user->address_sent_id = $address->id;
        } else {
            $user->addressSent->update($addressSent);
        }
        if (is_null($user->addressFood)) {
            $address = Address::create($addressFood);
            $user->address_food_id = $address->id;
        } else {
            $user->addressFood->update($addressFood);
        }
        $user->save();
        return back()->with('success', 'Saved successfully');
    }
    public function address()
    {
        $this->construct();
        $user = User::whereId(request()->integer('user_id'))->with(['address', 'addressSent', 'addressFood'])->first();
        $cities = City::all();
        $var = [$this->key => $user, 'cities' => $cities];
        return view($this->path . 'Address', $var);
    }

    public function markAsPaid($id)
    {
        $user = User::findOrFail($id);
        if ($user->type == 'captin') {
            $models = Delivary::where('paid', 0)->where('captin_id', $user->id)->get();
        } else {
            $models = Order::where('paid', 0)->where('restaurant_id', $user->id)->get();
        }
        foreach ($models as $model) {
            $model->paid = true;
            $model->save();
        }
        return back()->with('success', 'Saved successfully');
    }
}