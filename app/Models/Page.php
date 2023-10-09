<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Page extends Model
{
    use HasFactory, SearchableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'deleted',
        'archived',
        'updated_at',
    ];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'page.title' => 10,
        ],
        'groupBy' => [
            'title',
            'content',
            'user_id',
            'updated_at',
            'created-at',
            'user_id',
        ]
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}