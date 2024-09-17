<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTeacherHistory extends Model
{
    use HasFactory;

    protected $table = 'hrmis_contstaff_histories';

    protected $primaryKey = 'constaff_his_id';

    protected $fillable = [
    	'contstaff_id',
    	'start_date', 'end_date', 
    	'duty', 'curpos', 'annual_eval',
    	'pro_code', 'dis_code', 'com_code', 'vil_code', 'location_code', 'location_kh',
    	'created_by', 'updated_by',
        'contract_type_id', 'cont_pos_id',
        'has_refilled_training', 'year_refilled_num'
    ];


    // Get Current Position
    public function scopeCurrentPosition($query)
    {
    	return $query->where('curpos', 1);
    }


    // Contract Teacher Info
    public function contractTeacher()
    {
    	return $this->belongsTo('App\Models\ContractTeacher', 'contstaff_id');
    }

    // Province
    public function province()
    {
    	return $this->belongsTo('App\Models\Province', 'pro_code');
    }

    // Location
    public function location()
    {
    	return $this->belongsTo('App\Models\Location', 'location_code');
    }

    // Contract type
    public function contractType()
    {
        return $this->belongsTo('App\Models\ContractType', 'contract_type_id');
    }

    // Contract staff position
    public function contractPosition()
    {
        return $this->belongsTo('App\Models\ContractStaffPosition', 'cont_pos_id');
    }
}
