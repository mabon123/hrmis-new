<?php

namespace App\Models\Timetables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherPrimary extends Model
{
    use HasFactory;

    protected $table = 'timetable_teacher_primary';
    protected $primaryKey = 'teacher_primary_id';

    protected $guarded = [];
    protected $casts = [];

    // Academic year
    public function academicYear()
    {
        return $this->belongsTo('App\Models\AcademicYear', 'academic_id', 'year_id');
    }

    // Staff
    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'payroll_id', 'payroll_id');
    }

    // Timetable Grade
    public function tgrade()
    {
        return $this->belongsTo('App\Models\Timetables\TimetableGrade', 'tgrade_id', 'tgrade_id');
    }
}
