<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_id',
        'class_id',
        'curriculum_id',
        'topic_name',
        'file_type',
        'source_title',
        'url',
        'file',
        'created_date',
        'updated_date',
        'sub_topic_name',
        'status',
        'deleted_at'
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }

}
