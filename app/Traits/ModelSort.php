<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 *
 * @property array $fillable
 * @property string $key
 * @method mixed deleteFile(string $path, string $disk='images')
 */
trait ModelSort
{
    /**
     * Creates the search scope.
     *
     * @param $model
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function getModel($method)
    {
        $class = new $this->class;
        return $class::$method();
    }
    private function sort(Request $request, $method, )
    {
        $model = $this->getModel($method);
        return $this->sortData($request, $model);
    }
    public function sortData(Request $request, $model): array
    {
        $dir = 'asc';
        if ($request->has('order')) {
            $model = $model->orderBy($request->input('order'), $request->input('dir'));
            if ($request->input('dir') == 'asc')
                $dir = 'desc';
        } else {
            $model = $model->orderBy('created_at', 'asc');
        }
        if ($request->has('keyword')) {
            $model = $model->search($request->input('keyword'));
        }
        $model = $model->paginate(40);
        $model->appends($request->all());
        return ['dir' => $dir, $this->keys => $model];
    }
    /**
     * Creates the search scope.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $photo
     * @param  array $moreArge
     * @return array
     */
    private function fillingAray(Request $request, $photo = null, $moreArge = [], array $moreArgeWithData = [])
    {
        $fillingaray = [];
        foreach ($this->fillable as $property) {
            $fillingaray[$property] = $request->input($property);
        }
        if (!is_null($photo))
            $fillingaray['photo'] = $photo;
        foreach ($moreArge as $property) {
            $fillingaray[$property] = $request->input($property);
        }
        $fillingaray = array_merge($fillingaray, $moreArgeWithData);

        return $fillingaray;
    }
    private function parmentlyDeleteModels($models, bool $photo = false): bool
    {
        $boolean = true;
        if ((is_a($models, 'Illuminate\Database\Eloquent\Collection'))) {
            foreach ($models as $model) {
                if (!$this->parmentlyDeleteModel($model, $photo)) {
                    $boolean = false;
                }
            }
        } else {
            $boolean = $this->parmentlyDeleteModel($models, $photo);
        }
        return $boolean;
    }
    private function parmentlyDeleteModel($model, bool $photo = false): bool
    {
        if ($photo) {
            if (!is_null($model->photo))
                $this->deleteFile($model->photo);
        }
        $model->delete();
        return true;
    }
    private function reverseProperty($models, $property): bool
    {
        $boolean = true;
        if ((is_a($models, 'Illuminate\Database\Eloquent\Collection'))) {
            foreach ($models as $model) {
                if (!$this->reversePropertyApply($model, $property)) {
                    $boolean = false;
                }
            }
        } else {
            $boolean = $this->reversePropertyApply($models, $property);
        }
        return $boolean;
    }
    private function reversePropertyApply($model, $property): bool
    {
        $model->$property = !$model->$property;
        $model->save();
        return true;
    }
    private function photoUploader(Request $request)
    {
        if ($request->hasFile('photo')) {
            //upload the new file
            return $this->UploadFile($request->file('photo'));

        }
        return null;
    }
}