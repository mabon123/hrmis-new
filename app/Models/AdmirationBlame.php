<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmirationBlame extends Model
{
    use HasFactory;

    protected $table = 'hrmis_admiration_blames';

    protected $primaryKey = 'admiration_id';

    protected $fillable = [
    	'admiration_type_id', 'admiration', 'admiration_date', 'payroll_id', 'pro_code',
    	'admiration_source_id', 'created_by', 'updated_by',
        'prokah_num',
        'prokah_doc'
    ];


    // Get admiration type
    public function admirationType()
    {
    	return $this->belongsTo('App\Models\AdmirationType', 'admiration_type_id');
    }


    // Admiration source info
    public function admirationSource()
    {
        return $this->belongsTo('App\Models\AdmirationSource', 'admiration_source_id');
    }
}
