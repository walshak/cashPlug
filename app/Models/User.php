<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'cur_plan');
    }

    public function withdrawalRequest(){
        return $this->hasMany(WithdrawalRequest::class,'userId','id');
    }

    public function withdrawalRequestApproved(){
        return $this->hasMany(WithdrawalRequest::class,'approved_by','id');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class,'userId','id');
    }

    public function account(){
        return $this->hasOne(Account::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'active',
        'cur_plan',
        'plan_activated',
        'plan_activated_on',
        'refferd_by',
        'ref_id',
        'cycle',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
