<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $table = 'sys_offices';

    protected $primaryKey = 'office_id';

    public $timestamps = false;

    protected $fillable = ['office_kh', 'office_en', 'note', 'active'];


    // Get locations
    public function locations()
    {
    	return $this->belongsToMany(
    			'App\Models\Location', 'sys_locations', 'office_id', 'location_code'
    		);
    }
}
