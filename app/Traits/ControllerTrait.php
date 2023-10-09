<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
trait ControllerTrait
{
    use ModelSort;

    private $user;
    private $unauthorizeMessage = "You Are Not Authorize For This Action";
    public function construct()
    {
        $this->user = auth()->user();
        abort_if(!$this->user->admin, 403, $this->unauthorizeMessage);
    }
    /**
     * Display a listing of the resource. the one in use condtion.
     *
     */
    public function availableData(Request $request)
    {
        $this->construct();
        $vars = $this->sort($request, 'available');
        $vars['title'] = 'البيانات المتاحة';
        return view($this->path . 'View', $vars);
    }
    /**
     * Display a single model to edit or just view .
     *
     */
    public function model($view = 'Show', $id = null)
    {
        $this->construct();
        if (is_null($id)) {
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
    public function Archive(Request $request)
    {
        $this->construct();
        $vars = $this->sort($request, 'archive');
        $vars['title'] = 'الارشيف';
        return view($this->path . 'View', $vars);
    }
    public function Trash(Request $request)
    {
        $this->construct();
        $vars = $this->sort($request, 'trash', false);
        $vars['title'] = 'سلة المهملات';
        return view($this->path . 'View', $vars);
    }

    public function emptyTrash()
    {
        $this->construct();
        $models = $this->getModel('trash', false)->get();
        $this->parmentlyDeleteModels($models, true);
        return back()->with('success', 'Deleted successfully');
    }
    public function ParmentlyDelete($id)
    {
        $this->construct();
        $class = new $this->class;
        $model = $class::find($id);
        $this->parmentlyDeleteModel($model, true);
        return back()->with('success', 'Deleted successfully');
    }
    // for delete, archive, publish, block, publish actions
    // you need to pass the proprety that needed to be changed between true and false;
    // can both (block and unblock) or (delete and undelete) and so on
    public function Action(Request $request)
    {
        $this->construct();
        $class = new $this->class;
        $model = $class::find($request->input('model_id'));
        $this->reverseProperty($model, $request->action);
        return back()->with('success', 'Done successfully');
    }
    public function store(Request $request)
    {
        $this->construct();
        $this->validator($request->all(), true)->validate();
        $path = $this->photoUploader($request);
        // dd($request->hasFile('photo'));
        $key = $this->keys;
        $model = $this->user->$key()->create($this->fillingAray($request, $path));
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