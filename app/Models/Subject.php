<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'sys_subjects';
    protected $primaryKey = 'subject_id';

    protected $fillable = [
    	'subject_id', 'subject_kh', 'subject_en', 'edu_level_id', 'subject_type',
    	'subject_shortcut', 'h_g7', 'h_g8', 'h_g9', 'h_g10', 'h_g11_sc', 'h_g11_ss',
    	'h_g12_sc', 'h_g12_ss', 'subject_teaching', 'subject_hierachy',
    	'created_by', 'updated_by'
    ];


    // Get education level
    public function educationLevel()
    {
    	return $this->belongsTo('App\Models\EducationLevel', 'edu_level_id');
    }
}
