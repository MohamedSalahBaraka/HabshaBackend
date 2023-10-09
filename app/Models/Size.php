<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Size extends Model
{
    use HasFactory, SearchableTrait;
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'sizes.name' => 10,
        ],
    ];
    protected $fillable = [
        'dish_id',
        'price',
        'name',
    ];
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}