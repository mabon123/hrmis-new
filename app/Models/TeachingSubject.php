<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingSubject extends Model
{
    use HasFactory;

    protected $table = 'hrmis_teaching_subjects';

    protected $primaryKey = 'staff_sub_id';

    protected $fillable = [
    	'payroll_id', 'subject_id', 'grade_id', 'day_id', 'hour_id', 'year_id', 'grade_alias',
    	'created_by', 'updated_by'
	];


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


    // Academic year info
    public function academicYear()
    {
    	return $this->belongsTo('App\Models\AcademicYear', 'year_id');
    }


	// User created by info
    public function createdBy()
    {
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    // User updated by info
    public function updatedBy()
    {
    	return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}
