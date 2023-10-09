<?php

namespace App\Http\Controllers\AdminArea\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Fees;
use App\Traits\ControllerNOTrait;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    use Upload, ModelSort, ControllerNOTrait;
    private $key = 'city';
    private $keys = 'cities';
    private $class = City::class;
    private $path = 'AdminArea.CRUD.City.';
    private $fillable = [
        'name',
    ];
    private function validator(array $data, $photo = false)
    {
        return Validator::make($data, [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
        ], [
            'required' => "هذا الحقل مطلوب :attribute",
            'unique' => "رقم الهاتف محوز من قبل شخص آخر",
            'image' => 'قمت باختيار ملف ليس بصورة',
            'email' => 'يجب ان يكون ايميل صحيح',
            'min' => 'يجب ان لا تقل كلمة السر عن 8 حروف',
            'confirmed' => 'يجب ان تكون كلمة السر مطابقة للتأكيد'
        ]);
    }
    public function fees()
    {
        $maincity = City::findOrFail(request()->integer('id'));
        $cities = City::all();
        return view($this->path . 'Fee', ['cities' => $cities, 'maincity' => $maincity]);
    }
    public function feesStore(Request $request)
    {
        abort_if(!$request->has('Fees') && !is_array($request->input('Fees')), 500, 'something went wrong');
        foreach ($request->input('Fees') as $id => $fee) {
            $model = Fees::firstOrCreate(['formcity' => $request->integer('from'), 'tocity' => $id], ['price' => $fee['price'], 'fee' => $fee['fee']]);
            $model->price = $fee['price'];
            $model->fee = $fee['fee'];
            $model->save();
            $model = Fees::firstOrCreate(['formcity' => $id, 'tocity' => $request->integer('from')], ['price' => $fee['price'], 'fee' => $fee['fee']]);
            $model->price = $fee['price'];
            $model->fee = $fee['fee'];
            $model->save();
        }
        return back()->with('success', 'Deleted successfully');
    }
}