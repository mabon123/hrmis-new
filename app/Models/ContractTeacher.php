<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTeacher extends Model
{
    use HasFactory;

    protected $table = 'hrmis_cont_staffs';

    protected $primaryKey = 'contstaff_id';

    protected $fillable = [
        'payroll_id',
    	'nid_card', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 'sex', 'dob',
    	'qualification_code',
    	'staff_status_id', 'ethnic_id',
    	'adr_pro_code', 'adr_dis_code', 'adr_com_code', 'adr_vil_code',
    	'house_num', 'street_num', 'group_num', 'phone', 'photo',
    	'created_by', 'updated_by',
        'bank_account', 'former_staff', 'professional_level', 'experience',
        'birth_pro_code', 'birth_district', 'birth_commune', 'birth_village',
    ];


    // Qualification Code
    public function qualificationCode()
    {
    	return $this->belongsTo('App\Models\QualificationCode', 'qualification_code');
    }

    // POB - Province
    public function pobProvince()
    {
        return $this->belongsTo('App\Models\Province', 'birth_pro_code');
    }

    // Province
    public function province()
    {
    	return $this->belongsTo('App\Models\Province', 'adr_pro_code');
    }

    // District
    public function district()
    {
    	return $this->belongsTo('App\Models\District', 'adr_dis_code');
    }

    // Commune
    public function commune()
    {
    	return $this->belongsTo('App\Models\Commune', 'adr_com_code');
    }

    // Village
    public function village()
    {
    	return $this->belongsTo('App\Models\Village', 'adr_vil_code');
    }

    // Contract teacher work histories
    public function workhistories()
    {
    	return $this->hasMany('App\Models\ContractTeacherHistory', 'contstaff_id', 'contstaff_id');
    }

    // Get teaching info
    public function teachings()
    {
        return $this->hasMany('App\Models\ContractTeacherTeaching', 'contstaff_id');
    }

    public function getFullNameKHAttribute()
    {
        return $this->surname_kh.' '.$this->name_kh;
    }

    public function getFullNameENAttribute()
    {
        return $this->surname_en.' '.$this->name_en;
    }
}
