<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTeacherTeachingSubject extends Model
{
    use HasFactory;

    protected $table = 'hrmis_contstaff_teaching_subjects';

    protected $primaryKey = 'teaching_subj_id';

    protected $fillable = [
    	'contstaff_id',
    	'year_id', 'subject_id', 'grade_id', 'day_id', 'hour_id',
    	'created_by', 'updated_by'
    ];


    // Contract Teacher Info
    public function contractTeacher()
    {
    	return $this->belongsTo('App\Models\ContractTeacher', 'contstaff_id');
    }

    // Academic year info
    public function academicYear()
    {
    	return $this->belongsTo('App\Models\AcademicYear', 'year_id');
    }

    // Subject info
    public function subject()
    {
    	return $this->belongsTo('App\Models\Subject', 'subject_id');
    }


    // Grade info
    public function grade()
    {
    	return $this->belongsTo('App\Models\Grade', 'grade_id');
    }


    // Day teaching info
    public function dayTeaching()
    {
    	return $this->belongsTo('App\Models\DayTeaching', 'day_id');
    }


    // Hour teaching info
    public function hourTeaching()
    {
    	return $this->belongsTo('App\Models\HourTeaching', 'hour_id');
    }
}
