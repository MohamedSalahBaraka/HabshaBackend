<?php

namespace App\Http\Controllers\AdminArea;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Delivary;
use App\Models\Fees;
use App\Models\User;
use App\Notifications\CustomNotification;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DelivariesController extends Controller
{
    use Upload, ModelSort;
    private $key = 'delivary';
    private $keys = 'delivaries';
    private $user;
    private $unauthorizeMessage = "You Are Not Authorize For This Action";
    private $path = 'AdminArea.Delivary.';
    public function construct()
    {
        $this->user = auth()->user();
        abort_if(!$this->user->type === 'admin', 403, $this->unauthorizeMessage);
    }
    public function Data(Request $request)
    {
        $this->construct();
        $Delivarys = Delivary::where('paid', 1);
        $captins = User::where('type', 'captin')->get();
        $vars = $this->sortData($request, $Delivarys);
        $vars['title'] = 'البيانات المتاحة';
        $vars['captins'] = $captins;
        return view($this->path . 'View', $vars);
    }
    public function User(Request $request)
    {
        $this->construct();
        abort_if(!request()->has('user_id'), 500, 'something is off');
        $Delivarys = Delivary::where('user_id', $request->integer('user_id'));
        $captins = User::where('type', 'captin')->doesntHave('order')->get();
        $vars = $this->sortData($request, $Delivarys);
        $vars['title'] = 'البيانات المتاحة';
        $vars['captins'] = $captins;
        return view($this->path . 'View', $vars);
    }
    public function Captin(Request $request)
    {
        $this->construct();
        abort_if(!request()->has('captin_id'), 500, 'something is off');
        $Delivarys = Delivary::where('captin_id', $request->integer('captin_id'));
        $captins = User::where('type', 'captin')->doesntHave('order')->get();
        $vars = $this->sortData($request, $Delivarys);
        $vars['title'] = 'البيانات المتاحة';
        $vars['captins'] = $captins;
        return view($this->path . 'View', $vars);
    }

    public function New(Request $request)
    {
        $this->construct();
        $Delivarys = Delivary::where('paid', 0)->where('cancel', 0);
        $captins = User::where('type', 'captin')->get();
        $vars = $this->sortData($request, $Delivarys);
        $vars['title'] = 'البيانات الجديدة';
        $vars['captins'] = $captins;
        return view($this->path . 'View', $vars);
    }
    public function create()
    {
        $this->construct();
        $captins = User::where('type', 'captin')->get();
        $users = User::where('type', 'user')->get();
        $cities = City::all();
        return view($this->path . 'Create', compact(['captins', 'users', 'cities']));
    }
    public function edit($id)
    {
        $this->construct();
        $delivary = Delivary::findOrFail($id);
        $captins = User::where('type', 'captin')->get();
        $users = User::where('type', 'user')->get();
        $cities = City::all();
        return view($this->path . 'Edit', compact(['delivary', 'captins', 'users', 'cities']));
    }
    public function show($id)
    {
        $this->construct();
        $delivary = Delivary::findOrFail($id);
        $captins = User::where('type', 'captin')->get();
        return view($this->path . 'Show', compact(['delivary', 'captins']));
    }
    public function asginCaptin(Request $request)
    {
        $this->construct();
        $delivary = Delivary::findOrFail($request->integer('delivary'));
        $delivary->captin_id = $request->integer('captin');
        $delivary->save();
        if (!is_null($delivary->captin)) {
            Notification::send($delivary->captin, new CustomNotification(' تكليف جديد', 'تم تكليفك بمهمة توصيل جديدة افتح التطبيق للتعرف على التفاصيل'));
        }
        return back()->with('success', 'Saved successfully');
    }
    public function cancel($id)
    {
        $this->construct();
        $delivary = Delivary::findOrFail($id);
        $this->reverseProperty($delivary, 'cancel');
        if (!is_null($delivary->order)) {
            $this->reverseProperty($delivary->order, 'cancel');
            if (!is_null($delivary->order->restaurant)) {
                Notification::send($delivary->order->restaurant, new CustomNotification('الغاء الطلب', 'تم طلب الغاء طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
            }
        }
        if (!is_null($delivary->captin)) {
            Notification::send($delivary->captin, new CustomNotification('الغاء الطلب', 'تم طلب الغاء طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
        }
        return back()->with('success', 'Saved successfully');
    }
    public function markAsPaid($id)
    {
        $this->construct();
        $delivary = Delivary::findOrFail($id);
        $delivary->paid = true;
        $delivary->save();
        if (!is_null($delivary->captin)) {
            Notification::send($delivary->captin, new CustomNotification('دفع الرسوم', 'تم تأكيد دفع الرسوم على الطلب'));
        }
        return back()->with('success', 'Saved successfully');
    }
    public function Delete($id)
    {
        $this->construct();
        $delivary = Delivary::findOrFail($id);
        if (!is_null($delivary->order)) {
            $this->reverseProperty($delivary->order, 'cancel');
            if (!is_null($delivary->order->restaurant)) {
                Notification::send($delivary->order->restaurant, new CustomNotification('حذف الطلب', 'تم طلب حذف طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
            }
        }
        if (!is_null($delivary->captin)) {
            Notification::send($delivary->captin, new CustomNotification('حذف الطلب', 'تم طلب حذف طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
        }
        if (!is_null($delivary->user)) {
            Notification::send($delivary->user, new CustomNotification('حذف الطلب', 'تم طلب حذف طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
        }
        $this->parmentlyDeleteModel($delivary);
        return back()->with('success', 'Saved successfully');
    }
    public function store(Request $request)
    {
        $this->construct();
        $Fee = Fees::where('formcity', $request->integer('cityGet'))->where('tocity', $request->integer('citySent'))->first();
        abort_if(is_null($Fee), 404, 'something went worng');
        $delivary = Delivary::create([
            'user_id' => $request->input('user_id'),
            'package' => $request->input('package'),
            'captin_id' => $request->input('captin_id'),
            'price' => $Fee->price,
            'fee' => $Fee->fee,
        ]);
        $address = Address::create([
            'name' => $request->input('nameGet'),
            'neighbourhood' => $request->input('neighbourhoodGet'),
            'city_id' => $request->input('cityGet'),
            'details' => $request->input('detailsGet'),
            'phone' => $request->input('phoneGet'),
        ]);
        $delivary->address_get = $address->id;
        $address = Address::create([
            'name' => $request->input('nameSent'),
            'neighbourhood' => $request->input('neighbourhoodSent'),
            'city_id' => $request->input('citySent'),
            'details' => $request->input('detailsSent'),
            'phone' => $request->input('phoneSent'),
        ]);
        $delivary->address_sent = $address->id;
        $delivary->save();
        return back()->with('success', 'Saved successfully');
    }
    public function Update(Request $request)
    {
        $this->construct();
        $model = Delivary::find($request->input('model_id'));
        if (is_null($model)) {
            return back()->with('error', 'Error, try again');
        }
        $model->update([
            'user_id' => $request->input('user_id'),
            'package' => $request->input('package'),
            'captin_id' => $request->input('captin_id'),
        ]);
        if (!is_null($model->addressGet)) {
            $model->addressGet->update([
                'name' => $request->input('nameGet'),
                'neighbourhood' => $request->input('neighbourhoodGet'),
                'city' => $request->input('cityGet'),
                'details' => $request->input('detailsGet'),
                'phone' => $request->input('phoneGet'),
            ]);
        }
        if (!is_null($model->addressSent)) {
            $model->addressSent->update([
                'name' => $request->input('nameSent'),
                'neighbourhood' => $request->input('neighbourhoodSent'),
                'city' => $request->input('citySent'),
                'details' => $request->input('detailsSent'),
                'phone' => $request->input('phoneSent'),
            ]);
        }
        return back()->with('success', 'Saved successfully');
    }
}
