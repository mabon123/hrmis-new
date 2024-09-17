<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOffice extends Model
{
    use HasFactory;

    protected $table = 'sys_admin_offices';

    protected $primaryKey = 'sys_admin_office_id';

    protected $fillable = ['office_id', 'pro_code', 'location_code', 'created_by', 'updated_by'];


    // Office info
    public function office()
    {
    	return $this->belongsTo('App\Models\Office', 'office_id');
    }

    // Province info
    public function province()
    {
    	return $this->belongsTo('App\Models\Province', 'pro_code');
    }

    // Location info
    public function location()
    {
    	return $this->belongsTo('App\Models\Location', 'location_code');
    }
}
