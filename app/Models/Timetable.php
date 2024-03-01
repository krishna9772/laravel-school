<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_id',
        'class_id',
        'file',
        'created_date',
        'updated_date',
    ];

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
