<?php

namespace App\Http\Controllers\AdminArea\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ControllerNOTrait;
use App\Traits\ModelSort;
use App\Traits\Upload;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use Upload, ModelSort, ControllerNOTrait;
    private $key = 'category';
    private $keys = 'categories';
    private $class = Category::class;
    private $path = 'AdminArea.CRUD.Category.';
    private $fillable = [
        'name',
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
}