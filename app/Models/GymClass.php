<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trainer_id',
        'room',
        'class_date',
        'start_time',
        'end_time',
        'capacity',
        'enrolled',
        'color_theme',
    ];

    protected $casts = [
        'class_date' => 'date',
    ];

    public function trainer()
    {
        return $this->belongsTo(\App\Models\Trainer::class);
    }
}
