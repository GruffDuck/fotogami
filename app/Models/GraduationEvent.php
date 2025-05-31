<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraduationEvent extends Model
{
    protected $fillable = [
        'event_id', 'student_name', 'school_name', 'grade_level', 'teacher_name'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
} 