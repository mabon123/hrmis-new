<?php

namespace App\Models\TCP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TCPAppraisal extends Model
{
    use HasFactory;

    protected $table = 'tcp_appraisals';
    protected $primaryKey = 'tcp_appraisal_id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];

    // Profession Category
    public function professionCategory()
    {
        return $this->belongsTo(ProfessionCategory::class, 'tcp_prof_cat_id');
    }
    // Profession Rank
    public function professionRank()
    {
        return $this->belongsTo(ProfessionRank::class, 'tcp_prof_rank_id');
    }
     // TCP Status
     public function tcpStatus()
     {
         return $this->belongsTo(TcpStatus::class, 'tcp_status_id');
     }
    // Staff info
    public function staffInfo()
    {
        return $this->belongsTo('App\Models\Staff', 'staff_payroll', 'payroll_id');
    }
    // Appraisers
    public function appraisers()
    {
        return $this->hasMany('App\Models\TCP\TCPAppraiser', 'tcp_appraisal_id', 'tcp_appraisal_id');
    }
    // Workplace info
    public function workplace()
    {
    	return $this->belongsTo('App\Models\Location', 'workplace_code', 'location_code');
    }
}
