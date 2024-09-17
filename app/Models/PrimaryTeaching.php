<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryTeaching extends Model
{
    use HasFactory;

    protected $table = 'hrmis_primary_teachings';

    protected $primaryKey = 'pr_teaching_id';

    protected $fillable = [
    	'payroll_id', 'grade_id', 'year_id', 'teach_english', 'created_by', 'modif_by'
	];


	// Grade info
    public function grade()
    {
    	return $this->belongsTo('App\Models\Grade', 'grade_id');
    }


    // Day teaching info
    public function dayTeaching()
    {
    	return $this->belongsTo('App\Models\DayTeaching', 'day_id');
    }


	// User created by info
    public function createdBy()
    {
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    // User updated by info
    public function updatedBy()
    {
    	return $this->belongsTo('App\Models\User', 'modif_by', 'id');
    }
}
