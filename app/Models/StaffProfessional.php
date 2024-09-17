<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfessional extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staff_professions';

    protected $primaryKey = 'prof_id';

    public $timestamps = true;

    protected $fillable = [
    	'pro_code', 'payroll_id', 'prof_category_id', 'prof_date',
    	'subject_id1', 'subject_id2', 'prof_type_id',
    	'location_code',
    	'created_by', 'updated_by','highest_profession'
	];


	// Professional category
	public function professionalCategory()
	{
		return $this->belongsTo('App\Models\ProfessionalCategory', 'prof_category_id');
	}


	// Professional type
	public function professionalType()
	{
		return $this->belongsTo('App\Models\ProfessionalType', 'prof_type_id');
	}


	// First subject
	public function firstSubject()
	{
		return $this->belongsTo('App\Models\Subject', 'subject_id1');
	}


	// Second subject
	public function secondSubject()
	{
		return $this->belongsTo('App\Models\Subject', 'subject_id2');
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

    // Location info
    public function location()
    {
    	return $this->belongsTo('App\Models\Location', 'location_code');
    }
}
