<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishOrder extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'dish_id',
        'size_id',
        'price',
        'count',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}