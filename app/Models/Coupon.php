<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon',
        'created_by',
        'vendor',
        'plan_id',
        'user_id',
        'used',
        'used_on'
    ];

    public function used_by(){
        return $this->belongsTo(User::class);
    }

    public function created_by(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function vendor(){
        return $this->belongsTo(User::class,'vendor','id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

}
