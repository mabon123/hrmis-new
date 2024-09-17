<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLanguage extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staff_languages';

    protected $primaryKey = 'staff_lang_id';

    protected $fillable = [
    	'pro_code', 'payroll_id',
    	'language_id', 'reading', 'writing', 'conversation',
    	'created_by', 'updated_by'
	];


	// Language info
	public function language()
	{
		return $this->belongsTo('App\Models\Language', 'language_id');
	}


	// User created by info
    public function createdBy()
    {
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    // User updated by info
    public function updatedBy()
    {
    	return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}
