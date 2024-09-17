<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionLocation extends Model
{
    use HasFactory;

    protected $table = 'sys_position_location';

    protected $primaryKey = 'pos_loc_id';

    public $timestamps = false;

    protected $fillable = ['position_id', 'location_type_id'];


    public function position()
    {
    	return $this->belongsTo('App\Models\Position', 'position_id');
    }

    public function locationType()
    {
    	return $this->belongsTo('App\Models\LocationType', 'location_type_id');
    }
}
