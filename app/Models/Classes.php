<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'grade_id',
        'class_name',
        'description',
        'capacity',
    ];


    public function timetable()
    {
        return $this->hasOne(Timetable::class, 'class_id');
    }

    public function userGradeClasses()
    {
        return $this->hasMany(UserGradeClass::class, 'class_id', 'id');
    }

}
