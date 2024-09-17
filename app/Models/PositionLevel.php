<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionLevel extends Model
{
    use HasFactory;

    protected $table = 'sys_position_levels';

    protected $primaryKey = 'pos_level_id';

    protected $fillable = [
    	'pos_level_id', 'pos_level_kh', 'pos_level_en', 'active', 'created_by', 'updated_by'
    ];


    // Get only active
    public function scopeActive($query)
    {
    	return $query->where('active', 1);
    }
}
