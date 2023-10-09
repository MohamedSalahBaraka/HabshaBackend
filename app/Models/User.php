<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SearchableTrait;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.name' => 10,
        ],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'photo',
        'type',
        'opening',
        'clothing',
        'fee',
        'address_sent_id',
        'address_id',
        'address_food_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function addressSent()
    {
        return $this->belongsTo(Address::class, 'address_sent_id');
    }
    public function addressFood()
    {
        return $this->belongsTo(Address::class, 'address_food_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function money()
    {
        if ($this->type == 'captin')
            return Delivary::where('paid', 0)->where('cancel', 0)->where('captin_id', $this->id)->sum('price');
        return Order::where('paid', 0)->where('cancel', 0)->where('restaurant_id', $this->id)->sum('fee');
    }
}