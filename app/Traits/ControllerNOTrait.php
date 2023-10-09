<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait ControllerNOTrait
{
    use ModelSort;

    private $user;
    private $unauthorizeMessage = "You Are Not Authorize For This Action";
    public function construct()
    {
        $this->user = auth()->user();
        abort_if(!$this->user->type === 'admin', 403, $this->unauthorizeMessage);
    }
    /**
     * Display a listing of the resource. the one in use condtion.
     *
     */
    public function Data(Request $request)
    {
        $this->construct();
        $vars = $this->sortData($request, new $this->class);
        $vars['title'] = 'البيانات المتاحة';
        return view($this->path . 'View', $vars);
    }
    /**
     * Display a single model to edit or just view .
     *
     */
    public function model()
    {
        $view = request()->string('view');
        $id = request()->integer('id');
        $this->construct();
        if (!request()->has('id')) {
            if (method_exists($this, 'createOrEditAdditionalData')) {
                $var = $this->createOrEditAdditionalData([]);
            } else {
                $var = [];
            }
            return view($this->path . 'Create', $var);
        }
        $class = new $this->class;
        $model = $class::find($id);
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
        $this->validator($request->all(), true)->validate();
        $path = $this->photoUploader($request);
        // dd($request->hasFile('photo'));
        $class = new $this->class;
        $model = $class::create($this->fillingAray($request, $path));
        if (method_exists($this, 'storeExtraActions'))
            $this->storeExtraActions($model, $request);
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
        if (method_exists($this, 'updateExtraActions')) {
            $this->updateExtraActions($model, $request, $path);
        } else {
            if (!is_null($path))
                $this->deleteFile($model->photo);
            $model->update($this->fillingAray($request, $path));
        }
        return back()->with('success', 'Saved successfully');
    }
}