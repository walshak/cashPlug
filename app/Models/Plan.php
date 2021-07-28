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

    protected $fillable = [
        'name',
        'price',
        'validity',
        'refs'
    ];
}
