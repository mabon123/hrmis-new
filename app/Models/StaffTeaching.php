<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTeaching extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staff_teachings';
    protected $primaryKey = 'teaching_id';

    protected $fillable = [
    	'payroll_id', 'year_id',
    	'add_teaching', 'class_incharge', 'chief_technical',
    	'multi_grade', 'double_shift', 'bi_language', 'teach_english',
        'teach_cross_school', 'location_code',
        'triple_grade',
        'overtime',
    	'created_by', 'modif_by'
    ];


    // Academic year info
    public function academicYear()
    {
    	return $this->belongsTo('App\Models\AcademicYear', 'year_id');
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

    // School info
    public function crossSchool()
    {
        return $this->belongsTo('App\Models\Location', 'location_code');
    }
}
