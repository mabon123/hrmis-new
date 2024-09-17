<?php

namespace App\Models\Timetables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $table = 'timetables';
    protected $primaryKey = 'timetable_id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];

    // Academic year
    public function academicYear()
    {
        return $this->belongsTo('App\Models\AcademicYear', 'academic_id', 'year_id');
    }

    // Day Teaching
    public function day()
    {
        return $this->belongsTo('App\Models\DayTeaching', 'day_id', 'day_id');
    }

    // Hour Teaching
    public function hour()
    {
        return $this->belongsTo('App\Models\HourTeaching', 'hour_id', 'hour_id');
    }

    // Timetable Grade
    public function tgrade()
    {
        return $this->belongsTo(TimetableGrade::class, 'tgrade_id', 'tgrade_id');
    }

    // Teacher Subject
    public function teacherSubject()
    {
        return $this->belongsTo(TeacherSubject::class, 'teacher_subject_id', 'teacher_subject_id');
    }
}
