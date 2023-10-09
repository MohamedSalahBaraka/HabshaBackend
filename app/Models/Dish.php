<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Dish extends Model
{
    use HasFactory, SearchableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'dishes.name' => 10,
            'dishes.details' => 10,
            'categories.name' => 10,
        ],
        'joins' => [
            'categories' => ['dishes.category_id', 'categories.id'],
        ],
    ];
    protected $fillable = [
        'name',
        'photo',
        'details',
        'user_id',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

}