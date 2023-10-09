<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 *
 */
trait ModelScope
{

    public function scopeTrash(Builder $query): void
    {
        $query->where($this->getTable() . '.deleted', 1);
    }
    public function scopeArchive(Builder $query): void
    {
        $query->where($this->getTable() . '.deleted', 0)->where($this->getTable() . '.archived', 1);
    }
    public function scopeAvailable(Builder $query): void
    {
        $query->where($this->getTable() . '.deleted', 0)->where($this->getTable() . '.archived', 0);
    }
}