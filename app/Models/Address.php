<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'neighbourhood',
        'city_id',
        'details',
        'phone',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function delivary()
    {
        return $this->hasMany(Delivary::class, 'address_get');
    }
    public function delivarysent()
    {
        return $this->hasMany(Delivary::class, 'address_sent');
    }

}