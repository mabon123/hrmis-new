<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffQualification extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staff_qualifications';

    protected $primaryKey = 'qual_id';

    protected $fillable = [
    	'qualification_code', 'pro_code', 'payroll_id', 'subject_id', 'qual_date', 'country_id',
        'location_kh','qual_doc','request_cardre_check_status','request_cardre_check_date',
    	'created_by', 'updated_by','highest_qualification'
    ];


    // Qualification info
    public function qualificationCode()
    {
    	return $this->belongsTo('App\Models\QualificationCode', 'qualification_code');
    }


    // Subject info
    public function subject()
    {
    	return $this->belongsTo('App\Models\Subject', 'subject_id');
    }


    // Country info
    public function country()
    {
    	return $this->belongsTo('App\Models\Country', 'country_id');
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
