<?php

namespace App\Http\Controllers\AdminArea\CRUD;

use App\Http\Controllers\Controller;
use App\Traits\ControllerNOTrait;
use App\Traits\ModelSort;
use App\Models\Page;
use App\Traits\Upload;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    use Upload, ModelSort, ControllerNOTrait;
    private $key = 'page';
    private $keys = 'pages';
    private $class = Page::class;
    private $path = 'AdminArea.CRUD.Page.';
    private $fillable = [
        'title',
        'content',
    ];
    private function validator(array $data, $photo = false)
    {
        return Validator::make($data, [
            'title' => [
                'required',
                'string',
                'max:100',
            ],
            'content' => ['required', 'string'],
        ], [
            'required' => "هذا الحقل مطلوب :attribute",
        ]);
    }

}