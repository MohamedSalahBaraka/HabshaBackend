<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'delivary_id',
        'total',
        'fee',
        'cancel',
        'paid',
        'status',
        'count',
    ];
    protected function status(): Attribute
    {
        return new Attribute(
            get: fn($value) => ["new", "بدا التجهيز", 'جهز', 'اكتمل'][$value],
        );
    }

    public function dishOrder()
    {
        return $this->hasMany(DishOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(User::class, 'restaurant_id');
    }
    public function delivary()
    {
        return $this->belongsTo(Delivary::class);
    }
    public function scopePaidorders(Builder $query): void
    {
        $query->where('paid', 1);
    }
    public function scopeNotpaidorders(Builder $query): void
    {
        $query->where('paid', 0);
    }
}