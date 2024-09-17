<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'sys_positions';

    protected $primaryKey = 'position_id';

    protected $fillable = [
        'position_id',
    	'position_kh',
    	'position_en',
    	'pos_category_id',
    	'position_hierarchy',
    	'pos_level_id',
    	'created_by',
    	'updated_by'
    ];


    // Get position category info
    public function positionCategory()
    {
    	return $this->belongsTo('App\Models\PositionCategory', 'pos_category_id');
    }


    // Get position level info
    public function positionLevel()
    {
    	return $this->belongsTo('App\Models\LocationType', 'pos_level_id', 'location_type_id');
    }


    // Get created by user info
    public function createdBy()
    {
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }


    // Get updated by user info
    public function updatedBy()
    {
    	return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}
