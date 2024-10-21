<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    public function rent()
    {
        return $this->hasMany(Rent::class, 'id_penalties');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, "no_car");
    }
}
