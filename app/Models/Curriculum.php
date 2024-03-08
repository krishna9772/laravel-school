<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grade_id',
        'curriculum_name',
        'created_date',
        'updated_date',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function classWorks()
    {
        return $this->hasMany(ClassWork::class, 'curriculum_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
