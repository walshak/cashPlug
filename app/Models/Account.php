<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'account_name',
        'account_number',
        'bank',
        'bank_code',
        'bvn',
        'recipient_code',
        'user_id'
    ];
}
