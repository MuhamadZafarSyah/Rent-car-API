<?php

namespace App\Models;

use App\Models\Rent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function rent()
    {
        return $this->hasMany(Rent::class, 'tenant');
    }
}
