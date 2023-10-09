<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Delivary extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'delivary_status',
        'user_id',
        'address_sent',
        'address_get',
        'paid',
        'start_at',
        'finsh_at',
        'price',
        'fee',
        'captin_id',
        'package',
        'cancel',
    ];
    protected function delivaryStatus(): Attribute
    {
        return new Attribute(
            get: fn($value) => ["new", "الكابتن في الطريق", 'وصل الكابتن للاستلام', 'استلم', 'وصل الكابتن للتسليم', 'الكابتن سلم'][$value],
        );
    }
    public function scopePaiddelivaries(Builder $query): void
    {
        $query->where('paid', 1);
    }
    public function scopeNotpaiddelivaries(Builder $query): void
    {
        $query->where('paid', 0);
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function captin()
    {
        return $this->belongsTo(User::class, 'captin_id');
    }
    public function addressSent()
    {
        return $this->belongsTo(Address::class, 'address_sent');
    }
    public function addressGet()
    {
        return $this->belongsTo(Address::class, 'address_get');
    }
    public function timetoFinsh()
    {
        if (is_null($this->start_at) || is_null($this->finsh_at))
            return 'لم يتم التسليم بعد';
        $start = Carbon::create($this->start_at);
        $finsh = Carbon::create($this->finsh_at);
        $timeleft = $start->diffInDays($finsh);
        if ($timeleft != 0)
            return $timeleft . ' يوم';
        $timeleft = $start->diffInHours($finsh);
        if ($timeleft != 0)
            return $timeleft . ' ساعة';
        $timeleft = $start->diffInMinutes($finsh);
        if ($timeleft != 0)
            return $timeleft . ' دقيقة';
        return 'للتو';
    }
}