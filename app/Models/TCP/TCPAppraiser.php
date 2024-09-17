<?php

namespace App\Models\TCP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TCPAppraiser extends Model
{
    use HasFactory;

    protected $table = 'tcp_appraisers';
    //protected $primaryKey = 'id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];

    // Staff info
    public function staffInfo()
    {
        return $this->belongsTo('App\Models\Staff', 'appraiser_payroll', 'payroll_id');
    }

    // Appraisal info
    public function appraisal()
    {
        return $this->belongsTo('App\Models\TCP\TCPAppraisal', 'tcp_appraisal_id', 'tcp_appraisal_id');
    }
}
