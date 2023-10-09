<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivary;
use App\Models\Dish;
use App\Models\Setting;
use App\Models\Size;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;

class ShowController extends Controller
{
    use ModelSort, Upload;
    public function homeUser()
    {
        $user = User::find(auth()->id());
        return response()->json(['user' => $user, 'setting' => $this->setting()]);
    }
    public function homeRestaurant()
    {
        $user = User::find(auth()->id());
        $orders = Order::whereHas('delivary', function ($q) {
            $q->where('delivaries.delivary_status', '<', 5);
        })->where('restaurant_id', auth()->id())->with(['dishOrder', 'delivary.captin'])->where('cancel', 0)->get();
        $price = Order::where('paid', 0)->where('cancel', 0)->where('restaurant_id', auth()->id())->sum('fee');
        return response()->json(['user' => $user, 'setting' => $this->setting(), 'orders' => $orders, 'price' => $price]);
    }
    public function homeCaptin()
    {
        $user = User::find(auth()->id());
        $delivaries = Delivary::where('delivary_status', '<', 5)->where('captin_id', auth()->id())->where('cancel', 0)->with(['order.dishOrder.dish.category', 'order.dishOrder.size', 'user', 'addressSent.city', 'addressGet.city'])->get();
        $price = Delivary::where('paid', 0)->where('cancel', 0)->where('captin_id', auth()->id())->sum('price');
        return response()->json(['user' => $user, 'setting' => $this->setting(), 'delivaries' => $delivaries, 'price' => $price]);
    }
    private function setting()
    {
        $vars = array();
        $settings = Setting::all();
        foreach ($settings as $setting) {
            $vars[$setting->key] = $setting->value;
        }
        return $vars;
    }
    public function order($id)
    {

        $order = Order::whereId($id)->with(['dishOrder.dish.category', 'dishOrder.size'])->first();
        return response()->json(['order' => $order]);
    }
    public function dish($id)
    {

        $dish = Dish::whereId($id)->with(['sizes', 'category'])->first();
        return response()->json(['dish' => $dish]);
    }
    public function categories()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories]);
    }
    public function landing()
    {
        $currentTime = Carbon::now();
        $currentHour = $currentTime->format('H');
        $dishes = Dish::orderBy('created_at', 'desc')->with('sizes')->whereHas('user', function ($q) use ($currentHour) {
            $q->where('opening', "<=", $currentHour)->where('clothing', ">=", $currentHour);
        })->limit(6)->get();
        $categories = Category::all();
        $restaurants = User::orderBy('created_at', 'desc')->where('type', 'restaurant')->limit(8)->get();
        return response()->json(['dishes' => $dishes, 'categories' => $categories, 'restaurants' => $restaurants]);
    }

    public function dishes(Request $request)
    {
        $currentTime = Carbon::now();
        $currentHour = $currentTime->format('H');
        $dishes = Dish::orderBy('created_at', 'desc')->whereHas('user', function ($q) use ($currentHour) {
            $q->where('opening', "<=", $currentHour)->where('clothing', ">=", $currentHour);
        });
        if ($request->has('keyword')) {
            $dishes = $dishes->search($request->input('keyword'));
        }
        if ($request->has('categories')) {
            $dishes = $dishes->whereIn('category_id', $request->input('categories'));
        }
        if ($request->has('user_id')) {
            $dishes = $dishes->where('user_id', $request->input('user_id'));
        }
        $dishes = $dishes->with(['sizes'])->get();
        $categories = Category::all();
        return response()->json(['dishes' => $dishes, 'categories' => $categories]);
    }
    public function restaurant(Request $request)
    {

        $currentTime = Carbon::now();
        $currentHour = $currentTime->format('H');
        $restaurants = User::orderBy('created_at', 'desc')->where('type', 'restaurant')->where('opening', "<=", $currentHour)->where('clothing', ">=", $currentHour);
        if ($request->has('keyword')) {
            $restaurants = $restaurants->search($request->input('keyword'));
        }
        $restaurants = $restaurants->get();
        return response()->json(['restaurants' => $restaurants]);
    }

    public function DishDelete($id)
    {
        $model = Dish::find($id);
        abort_unless($model->user_id == auth()->id(), 403, 'your are not authraize for this action');
        $this->parmentlyDeleteModel($model, true);
        return response()->json(['message' => 'done']);
    }
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
            'details' => ['required'],
            'category_id' => ['required'],
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
    public function dishstore(Request $request)
    {
        $this->validator($request->all(), true)->validate();
        $path = $this->photoUploader($request);
        if (!is_null($path)) {
            $dish = Dish::create([
                'user_id' => auth()->id(),
                'name' => $request->input('name'),
                'details' => $request->input('details'),
                'category_id' => $request->input('category_id'),
                'photo' => $path
            ]);
            $sizes = json_decode($request->input('sizes'));
            foreach ($sizes as $size) {
                Size::create([
                    'name' => $size->name,
                    'price' => $size->price,
                    'dish_id' => $dish->id,
                ]);
            }
            return response()->json(['message' => 'done']);
        }
        return response()->json(['message' => 'no photo'], 422);
    }
    public function dishUpdate(Request $request)
    {
        $model = Dish::find($request->integer('id'));
        abort_unless($model->user_id == auth()->id(), 403, 'your are not authraize for this action');
        if (is_null($model)) {
            return back()->with('error', 'Error, try again');
        }
        $array = [
            'name' => $request->input('name'),
            'details' => $request->input('details'),
            'category_id' => $request->input('category_id'),
        ];
        $path = $this->photoUploader($request);
        if (!is_null($path)) {
            $this->deleteFile($model->photo);
            $array['photo'] = $path;
        }
        $model->update($array);
        return response()->json(['message' => 'done']);
    }

    public function sizedelete($id)
    {
        $model = Size::find($id);
        $this->parmentlyDeleteModel($model);
        return response()->json(['message' => 'done']);
    }
    public function sizeupdate(Request $request)
    {
        $size = Size::find($request->input('id'));
        abort_if(is_null($size), 404);
        $size->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
        ]);
        return response()->json(['message' => 'done']);
    }
    public function sizeStore(Request $request)
    {
        Size::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'dish_id' => $request->input('dish_id'),
        ]);
        return response()->json(['message' => 'done']);
    }
}