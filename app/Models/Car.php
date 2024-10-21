<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penalty()
    {
        return $this->hasMany(Penalty::class, 'no_car');
    }

    public function rent()
    {
        return $this->hasMany(Rent::class, 'no_car');
    }
}
