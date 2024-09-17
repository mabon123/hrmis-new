<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'sys_grades';

    protected $primaryKey = 'grade_id';

    public $timestamps = false;

    protected $fillable = ['grade_id', 'grade_kh', 'grade_en', 'edu_level_id', 'description'];


    // Get education level
    public function educationLevel()
    {
    	return $this->belongsTo('App\Models\EducationLevel', 'edu_level_id');
    }
}
