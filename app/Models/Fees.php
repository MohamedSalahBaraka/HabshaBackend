<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    use HasFactory;
    protected $fillable = [
        'formcity',
        'tocity',
        'price',
        'fee',
    ];
    public function fromcity()
    {
        return $this->belongsTo(City::class, 'formcity');
    }
    public function tocity()
    {
        return $this->belongsTo(City::class, 'tocity');
    }
}