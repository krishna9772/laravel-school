<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_grade_class_id',
        'status',
        'reason',
    ];

    public function userGradeClass()
    {
        return $this->belongsTo(UserGradeClass::class, 'user_grade_class_id', 'id');
    }
}
