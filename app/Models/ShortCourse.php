<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortCourse extends Model
{
    use HasFactory;

    protected $table = 'hrmis_shortcourses';

    protected $primaryKey = 'shortcourse_id';

    protected $fillable = [
    	'pro_code', 'payroll_id', 'qualification', 'qual_date', 'shortcourse_cat_id',
    	'start_date', 'end_date', 'duration', 'duration_type_id', 'organized', 'donor',
    	'created_by', 'updated_by'
	];


	// Short course category info
	public function category()
	{
		return $this->belongsTo('App\Models\ShortCourseCategory', 'shortcourse_cat_id');
	}


	// Duration type info
	public function durationType()
	{
		return $this->belongsTo('App\Models\DurationType', 'duration_type_id');
	}

	// Organizer info
	public function organizer()
	{
		return $this->belongsTo('App\Models\TrainingPartnerType', 'organized' , 'partner_type_id');
	}


	// Donor info
	public function donator()
	{
		return $this->belongsTo('App\Models\TrainingPartnerType', 'donor', 'partner_type_id');
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
