<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_mark_id',
        'subject',
        'marks',
        'created_date',
        'updated_date',
    ];
}
