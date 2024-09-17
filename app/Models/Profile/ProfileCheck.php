<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCheck extends Model
{
    use HasFactory;

    protected $table = 'hrmis_profile_checks';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['payroll_id', 'field_id', 'correct_value', 'staff_check_status', 'staff_check_date',
    'school_approver', 'school_check_status', 'school_check_date', 'doe_approver', 'doe_check_status', 'doe_check_date',
    'poe_approver', 'poe_check_status', 'poe_check_date', 'department_approver', 'department_check_status', 'department_check_date',
    'admin_approver', 'admin_check_status', 'admin_check_date'];

    public function ethnic()
    {
    	return $this->belongsTo('App\Models\Ethnic', 'correct_value', 'ethnic_id');
    }
    public function disability()
    {
    	return $this->belongsTo('App\Models\Disability', 'correct_value', 'disability_id');
    }
     // Get staff's marital status
     public function maritalStatus()
     {
         return $this->belongsTo('App\Models\MaritalStatus', 'correct_value', 'maritalstatus_id');
     }
     // POB - province
    public function birthProvince()
    {
        return $this->belongsTo('App\Models\Province', 'correct_value', 'pro_code');
    }

    // Address - Village
    public function addressVillage()
    {
        return $this->belongsTo('App\Models\Village', 'correct_value', 'vil_code');
    }

    // Address - Commune
    public function addressCommune()
    {
        return $this->belongsTo('App\Models\Commune', 'correct_value', 'com_code');
    }

    // Address - District
    public function addressDistrict()
    {
        return $this->belongsTo('App\Models\District', 'correct_value', 'dis_code');
    }

    // Address - Province
    public function addressProvince()
    {
        return $this->belongsTo('App\Models\Province', 'correct_value', 'pro_code');
    }
}