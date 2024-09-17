<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    use HasFactory;

    protected $table = 'hrmis_work_histories';

    protected $primaryKey = 'workhis_id';

    protected $fillable = [
    	'pro_code', 'location_code', 'sys_admin_office_id', 'payroll_id', 'his_type_id',
    	'country_id', 'position_id', 'additional_position_id', 'status_id',
    	'prokah', 'prokah_num', 'cur_pos', 'main_duty', 'description', 'start_date', 'end_date',
    	'created_by', 'updated_by', 
        'dis_code', 'com_code', 'vil_code', 'location_kh', 
        'annual_eval', 'has_refilled_training', 'year_refilled_num', 
        'contract_type_id', 'cont_pos_id', 
        'location_pro_code', 'location_dis_code', 'location_com_code', 'location_vil_code'
    ];


    // Position info
    public function position()
    {
    	return $this->belongsTo('App\Models\Position', 'position_id');
    }

    public function additionalPosition()
    {
        return $this->belongsTo('App\Models\Position', 'additional_position_id');
    }

    // Location info
    public function location()
    {
    	return $this->belongsTo('App\Models\Location', 'location_code');
    }

    // Office info
    public function office()
    {
        return $this->belongsTo('App\Models\Office', 'sys_admin_office_id', 'office_id');
    }

    // Official rank
    public function officialRank()
    {
        return $this->belongsTo('App\Models\OfficialRank', 'official_rank_id');
    }

    public function historyType()
    {
        return $this->belongsTo('App\Models\HistoryType', 'his_type_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'pro_code');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'dis_code');
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
