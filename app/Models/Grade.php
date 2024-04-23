<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_name',
        'description',
        'created_date',
        'updated_date',
    ];

    public function curricula(){
        return $this->hasMany(Curriculum::class);
    }

    public function userGradeClasses()
    {
        return $this->hasMany(UserGradeClass::class, 'grade_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany(Classes::class, 'grade_id');
    }

    public function examSubjects()
    {
        return $this->hasMany(GradeSubjectExam::class, 'grade_id');

    }
}
