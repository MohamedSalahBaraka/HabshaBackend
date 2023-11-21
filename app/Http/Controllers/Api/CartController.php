<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Delivary;
use App\Models\Fees;
use App\Notifications\CustomNotification;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Message;
use App\Models\Order;
use App\Models\DishOrder;
use Illuminate\Support\Facades\Notification;

class CartController extends Controller
{
    use Upload, ModelSort;
    public function addDish(Request $request)
    {
        $id = Auth::id();
        Cart::create([
            'user_id' => $id,
            'dish_id' => $request->input('dish_id'),
            'size_id' => $request->input('size_id'),
            'count' => $request->input('count'),
        ]);
        return response()->json(['message' => 'done']);
    }
    public function removeDish($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return response()->json(['message' => 'done']);
    }
    public function removeAllCart()
    {
        $id = Auth::id();
        $carts = Cart::where('user_id', $id)->get();
        foreach ($carts as $cart) {
            $cart->delete();
        }
        return response()->json(['message' => 'done']);
    }
    public function getCart()
    {
        $id = Auth::id();
        $carts = Cart::where('user_id', $id)->with(['dish.category', 'size'])->get();
        return response()->json(['carts' => $carts]);
    }
    public function delivaryPriceorder(Request $request)
    {
        $id = Auth::id();
        $carts = Cart::where('user_id', $id)->with('dish')->get();
        if ($carts->count() > 0) {
            $cartSplited = [];
            foreach ($carts as $cart) {
                if (!is_null($cart->dish)) {
                    if (!is_null($cart->dish->user)) {
                        $cartSplited[$cart->dish->user->id][] = $cart;
                    }
                }
            }
            $orders = 0;
            $price = 0;
            foreach ($cartSplited as $cartsuser) {
                $x = $cartsuser[0];
                $user = $x->dish->user;
                if (!is_null($user->address)) {
                    $Fee = Fees::where('formcity', $user->address->city_id)->where('tocity', $request->integer('citySent'))->first();
                    $orders++;
                    $price += $Fee->price;
                }
            }
        }
        return response()->json(['orders' => $orders, 'price' => $price]);
    }
    public function delivaryPricedelivary(Request $request)
    {
        $Fee = Fees::where('formcity', $request->integer('cityGet'))->where('tocity', $request->integer('citySent'))->first();
        $price = 0;
        if (!is_null($Fee))
            $price = $Fee->price;

        return response()->json(['price' => $price]);
    }
    public function getCities()
    {
        $cities = City::all();
        return response()->json(['cities' => $cities]);
    }
    public function PlaceADelivary(Request $request)
    {

        $id = Auth::id();
        $Fee = Fees::where('formcity', $request->integer('cityGet'))->where('tocity', $request->integer('citySent'))->first();
        abort_if(is_null($Fee), 404, 'something went worng');
        $delivary = Delivary::create([
            'user_id' => $id,
            'package' => $request->input('package'),
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
        return response()->json(['message' => 'done']);
    }
    public function formersDelivarycaptin()
    {
        $id = Auth::id();
        $delivaries = Delivary::where('captin_id', $id)->with(['captin', 'addressSent.city', 'addressGet.city'])->get();
        return response()->json(['delivaries' => $delivaries]);
    }
    public function formersDelivary()
    {
        $id = Auth::id();
        $delivaries = Delivary::where('user_id', $id)->with(['captin', 'addressSent.city', 'addressGet.city'])->doesntHave('order')->get();
        return response()->json(['delivaries' => $delivaries]);
    }
    public function delivarycancel($id)
    {
        $delivary = Delivary::findOrFail($id);
        $array = ["new", "الكابتن في الطريق",  'استلم', 'الكابتن سلم'];
        if (array_search($delivary->delivary_status, $array) < 2) {

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
            return response()->json(['message' => 'done']);
        }
        return response()->json(['message' => 'cannot cancel too late', 422]);
    }
    public function ordercancel($id)
    {
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
    public function delivaryProgress()
    {
        abort_if(!request()->has('id'), 500, 'something is off');
        $delivary = Delivary::findOrFail(request()->integer('id'));
        $array = ["new", "الكابتن في الطريق",  'استلم',  'الكابتن سلم'];
        $numb = array_search($delivary->delivary_status, $array) + 1;
        if ($numb < 4)
            $delivary->delivary_status = $numb;
        if ($numb == 1)
            $delivary->start_at = Carbon::now();
        if ($numb == 3)
            $delivary->finsh_at = Carbon::now();
        $delivary->save();
        if (!is_null($delivary->user))
            Notification::send($delivary->user, new CustomNotification('تقدم في الطلب', $array[$numb - 1]));
        return response()->json(['message' => 'done']);
    }
    public function orderProgress()
    {
        abort_if(!request()->has('id'), 500, 'something is off');
        $Order = Order::findOrFail(request()->integer('id'));
        $array = ["new", "بدا التجهيز", 'جهز'];
        $numb = array_search($Order->status, $array) + 1;
        if ($numb < 3)
            $Order->status = $numb;
        $Order->save();
        if (!is_null($Order->user))
            Notification::send($Order->user, new CustomNotification('تقدم في الطلب', $array[$numb - 1]));
        if (!is_null($Order->delivary) && !is_null($Order->delivary->captin))
            Notification::send($Order->delivary->captin, new CustomNotification('تقدم في الطلب', $array[$numb - 1]));
        return response()->json(['message' => 'done']);
    }
    public function formersOrderrestaurant()
    {
        $id = Auth::id();
        $orders = Order::where('restaurant_id', $id)->with(['delivary.captin', 'restaurant'])->get();
        return response()->json(['orders' => $orders]);
    }
    public function formersOrder()
    {
        $id = Auth::id();
        $orders = Order::where('user_id', $id)->with(['delivary.captin', 'restaurant'])->get();
        return response()->json(['orders' => $orders]);
    }

    public function PlaceAnOrder(Request $request)
    {
        $id = Auth::id();
        $carts = Cart::where('user_id', $id)->get();
        if ($carts->count() > 0) {
            $cartSplited = [];
            foreach ($carts as $cart) {
                if (!is_null($cart->dish)) {
                    if (!is_null($cart->dish->user)) {
                        $cartSplited[$cart->dish->user->id][] = $cart;
                    }
                }

            }

            foreach ($cartSplited as $cartsuser) {
                $x = $cartsuser[0];
                $user = $x->dish->user;
                if (!is_null($user->address)) {
                    $Fee = Fees::where('formcity', $user->address->city_id)->where('tocity', $request->integer('citySent'))->first();
                    abort_if(is_null($Fee), 404, 'something went worng');
                    $delivary = Delivary::create([
                        'user_id' => $id,
                        'package' => 'Food',
                        'price' => $Fee->price,
                        'fee' => $Fee->fee,
                    ]);
                    $address = Address::create([
                        'name' => $user->address->name,
                        'neighbourhood' => $user->address->neighbourhood,
                        'city_id' => $user->address->city_id,
                        'details' => $user->address->details,
                        'phone' => $user->address->phone,
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
                    $count = Order::whereDate('created_at', Carbon::today())->where('user_id', $id)->count() + 1;
                    $order = Order::create([
                        'user_id' => $id,
                        'count' => $count,
                        'restaurant_id' => $user->id,
                        'delivary_id' => $delivary->id,
                    ]);
                    $total = 0;
                    foreach ($cartsuser as $cart) {
                        if (!is_null($cart->dish)) {
                            DishOrder::create([
                                'order_id' => $order->id,
                                'dish_id' => $cart->dish_id,
                                'size_id' => $cart->size_id,
                                'count' => $cart->count,
                                'price' => $cart->size->price,
                            ]);
                            $total += $cart->size->price * $cart->count;
                        }
                        $cart->delete();
                    }

                    $order->total = $total;
                    $order->fee = $total * $user->fee / 100;
                    $order->save();
                    Notification::send($order->restaurant, new CustomNotification('طلب جديد', 'هناك طلب جديد رجاء افتح التطبيق للتعرف عليه'));

                }
            }
        }
        return response()->json(['message' => 'done']);
    }


    public function message(Request $request)
    {
        $id = Auth::id();
        Message::create([
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
            'subject' => $request->input('subject'),
            'user_id' => $id,
        ]);
        return response()->json(['message' => 'done']);
    }
}
