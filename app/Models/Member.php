<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'plan_name',
        'status',
        'join_date',
        'avatar',
    ];

    protected $casts = [
        'join_date' => 'datetime',
    ];
}
