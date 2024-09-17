<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffFamily extends Model
{
    use HasFactory;

    protected $table = 'hrmis_families';

    protected $primaryKey = 'family_id';

    protected $fillable = [
    	'payroll_id', 'relation_type_id', 'fullname_kh', 'fullname_en', 'dob', 'gender',
    	'occupation', 'spouse_workplace', 'allowance', 'created_by', 'updated_by',
    	'phone_number'
	];


	// Relationship type info
	public function relationshipType()
	{
		return $this->belongsTo('App\Models\RelationshipType', 'relation_type_id');
	}
}
