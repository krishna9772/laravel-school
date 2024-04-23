<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSubjectExam extends Model
{
    use HasFactory;

    protected $table = 'grade_subject_exams';

    protected $fillable = [
        'grade_id',
        'subject'
    ];
}
