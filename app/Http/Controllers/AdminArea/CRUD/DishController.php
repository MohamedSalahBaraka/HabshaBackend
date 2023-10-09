<?php

namespace App\Http\Controllers\AdminArea\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Message;
use App\Models\Size;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class DishController extends Controller
{
    use Upload, ModelSort;
    private $key = 'dish';
    private $keys = 'dishes';
    private $user;
    private $unauthorizeMessage = "You Are Not Authorize For This Action";
    private $class = Dish::class;
    private $path = 'AdminArea.CRUD.Dish.';
    private $fillable = [
        'name',
        'details',
        'category_id',
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
    public function construct()
    {
        $this->user = auth()->user();
        abort_if(!$this->user->type === 'admin', 403, $this->unauthorizeMessage);
    }
    public function Data(Request $request)
    {
        $this->construct();
        abort_if(!request()->has('user_id'), 500, 'something is off');
        $dishes = Dish::where('user_id', $request->integer('user_id'));
        $vars = $this->sortData($request, $dishes);
        $vars['title'] = 'البيانات المتاحة';
        $vars['user_id'] = $request->integer('user_id');
        return view($this->path . 'View', $vars);
    }
    public function model(Request $request)
    {
        $this->construct();
        abort_if(!request()->has('view'), 500, 'something is off');
        $view = request()->string('view');
        if (!request()->has('id')) {
            $var = ['user_id' => request()->integer('user_id')];
            $var['categories'] = Category::all();
            return view($this->path . 'Create', $var);
        }
        $class = new $this->class;
        $model = $class::find(request()->integer('id'));
        if ($view == 'Show')
            return view($this->path . 'Show', [$this->key => $model]);
        $var = [$this->key => $model];
        $var['categories'] = Category::all();
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
        $this->validator($request->all(), true)->validate();
        $path = $this->photoUploader($request);
        // dd($request->hasFile('photo'));
        $class = new $this->class;
        $class::create($this->fillingAray($request, $path, ['user_id']));
        return back()->with('success', 'Saved successfully');
    }
    public function Update(Request $request)
    {
        $this->construct();
        $this->validator($request->all())->validate();
        $class = new $this->class;
        $model = $class::find($request->input('model_id'));
        if (is_null($model)) {
            return back()->with('error', 'Error, try again');
        }
        $path = $this->photoUploader($request);
        if (!is_null($path))
            $this->deleteFile($model->photo);
        $model->update($this->fillingAray($request, $path));
        return back()->with('success', 'Saved successfully');
    }



    public function size(Request $request)
    {
        $dish = Dish::findOrFail(request()->integer('dish_id'));
        $sizes = Size::where('dish_id', request()->integer('dish_id'));
        $var = $this->sortData($request, $sizes);
        $var['sizes'] = $var['dishes'];
        $var['dish'] = $dish;
        return view($this->path . 'Size', $var);
    }
    public function sizedelete($id)
    {
        $this->construct();
        $model = Size::find($id);
        $this->parmentlyDeleteModel($model);
        return back()->with('success', 'Deleted successfully');
    }
    public function sizeupdate(Request $request)
    {
        $size = Size::find($request->input('id'));
        abort_if(is_null($size), 404);
        $size->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
        ]);
        return back()->with('success', 'تم التعديل بنجاح');
    }
    public function sizeStore(Request $request)
    {
        Size::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'dish_id' => $request->input('dish_id'),
        ]);
        return back()->with('success', 'تم الحفظ بنجاح');
    }
}