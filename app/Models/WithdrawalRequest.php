<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class,'userId','id');
    }

    public function approvedBy(){
        return $this->belongsTo(User::class,'approved_by','id');
    }
    protected $fillable = [
        'userId',
        'amount',
        'approved',
        'approved_by',
        'approved_on'
    ];
}
