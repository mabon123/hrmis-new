<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'sys_leave_types';

    protected $primaryKey = 'leave_type_id';

    protected $fillable = [
    	'leave_type_id', 'leave_type_kh', 'leave_type_en', 'active', 'created_by', 'updated_by'
	];


	public function scopeActive($query)
	{
		return $query->where('active', 1);
	}
}
