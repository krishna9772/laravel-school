<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGradeClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grade_id',
        'class_id',
    ];


    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_grade_class_id', 'id');
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class, 'user_grade_class_id', 'id');
    }
}
