<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsToMany(User::class, 'cur_plan');
    }

    public function coupons(){
        return $this->hasMany(Coupon::class);
    }

    protected $fillable = [
        'name',
        'price',
        'validity',
        'refs'
    ];
}
