<?php

namespace App\Models\Timetables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $table = 'timetable_teacher_subjects';
    protected $primaryKey = 'teacher_subject_id';

    protected $guarded = [];
    protected $casts = [];

    // Academic year
    public function academicYear()
    {
        return $this->belongsTo('App\Models\AcademicYear', 'academic_id', 'year_id');
    }

    // Grade
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id', 'grade_id');
    }

    // Subject
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'subject_id');
    }

    // Staff
    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'payroll_id', 'payroll_id');
    }
}
