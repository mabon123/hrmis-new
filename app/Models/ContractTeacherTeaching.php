<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTeacherTeaching extends Model
{
    use HasFactory;

    protected $table = 'hrmis_contstaff_teachings';

    protected $primaryKey = 'contstaff_teaching_id';

    protected $fillable = [
    	'contstaff_id', 'year_id',
        'multi_grade', 'double_shift', 'bi_language', 'teach_english',
    	'created_by', 'updated_by'
    ];


    // Contract Teacher Info
    public function contractTeacher()
    {
    	return $this->belongsTo('App\Models\ContractTeacher', 'contstaff_id');
    }

    // Academic year info
    public function academicYear()
    {
    	return $this->belongsTo('App\Models\AcademicYear', 'year_id');
    }
}
