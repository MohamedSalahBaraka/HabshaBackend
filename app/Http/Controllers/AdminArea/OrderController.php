<?php

namespace App\Http\Controllers\AdminArea;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\CustomNotification;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    use Upload, ModelSort;
    private $key = 'order';
    private $keys = 'orders';
    private $user;
    private $unauthorizeMessage = "You Are Not Authorize For This Action";
    private $path = 'AdminArea.Order.';
    public function construct()
    {
        $this->user = auth()->user();
        abort_if(!$this->user->type === 'admin', 403, $this->unauthorizeMessage);
    }
    public function Data(Request $request)
    {
        $this->construct();
        $orders = Order::whereHas('delivary', function ($q) {
            $q->whereNotNull('delivaries.captin_id');
        });
        $vars = $this->sortData($request, $orders);
        $vars['title'] = 'البيانات المتاحة';
        return view($this->path . 'View', $vars);
    }

    public function markAsPaid($id)
    {
        $this->construct();
        $order = Order::findOrFail($id);
        $order->paid = true;
        $order->save();
        if (!is_null($order->restaurant)) {
            Notification::send($order->restaurant, new CustomNotification('دفع الرسوم', 'تم تأكيد دفع الرسوم على الطلب'));
        }
        return back()->with('success', 'Saved successfully');
    }
    public function User(Request $request)
    {
        $this->construct();
        abort_if(!request()->has('user_id'), 500, 'something is off');
        $orders = Order::where('user_id', $request->integer('user_id'));
        $vars = $this->sortData($request, $orders);
        $vars['title'] = 'البيانات المتاحة';
        return view($this->path . 'View', $vars);
    }
    public function restaurant(Request $request)
    {
        $this->construct();
        abort_if(!request()->has('restaurant_id'), 500, 'something is off');
        $orders = Order::where('restaurant_id', $request->integer('restaurant_id'));
        $vars = $this->sortData($request, $orders);
        $vars['title'] = 'البيانات المتاحة';
        return view($this->path . 'View', $vars);
    }
    public function cancel($id)
    {
        $this->construct();
        $order = Order::findOrFail($id);
        $this->reverseProperty($order, 'cancel');
        if (!is_null($order->delivary)) {
            $this->reverseProperty($order->delivary, 'cancel');
            if (!is_null($order->delivary->captin)) {
                Notification::send($order->delivary->captin, new CustomNotification('الغاء الطلب', 'تم طلب الغاء طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
            }
        }
        if (!is_null($order->restaurant)) {
            Notification::send($order->restaurant, new CustomNotification('الغاء الطلب', 'تم طلب الغاء طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
        }
        return back()->with('success', 'Saved successfully');
    }
    public function New(Request $request)
    {
        $this->construct();
        $orders = Order::whereHas('delivary', function ($q) {
            $q->whereNull('delivaries.captin_id');
        })->where('cancel', 0);
        $vars = $this->sortData($request, $orders);
        $vars['title'] = 'البيانات المتاحة';
        return view($this->path . 'View', $vars);
    }
    public function show($id)
    {
        $this->construct();
        $order = Order::findOrFail($id);
        return view($this->path . 'Show', compact(['order']));
    }
    public function Delete($id)
    {
        $this->construct();
        $order = Order::findOrFail($id);
        if (!is_null($order->delivary)) {
            $this->reverseProperty($order->delivary, 'cancel');
            if (!is_null($order->delivary->captin)) {
                Notification::send($order->delivary->captin, new CustomNotification('حذف الطلب', 'تم طلب حذف طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
            }
        }
        if (!is_null($order->restaurant)) {
            Notification::send($order->restaurant, new CustomNotification('حذف الطلب', 'تم طلب حذف طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
        }
        if (!is_null($order->user)) {
            Notification::send($order->user, new CustomNotification('حذف الطلب', 'تم طلب حذف طلب من قبل المستخدم رجاءاً افتح التطبيق لمعرفة التفاصيل'));
        }
        $this->parmentlyDeleteModel($order);
        return back()->with('success', 'Saved successfully');
    }
}