<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryLevel extends Model
{
    use HasFactory;

    protected $table = 'salary_levels';

    protected $primaryKey = 'salary_level_id';

    public $timestamps = false;

    protected $fillable = ['salary_level_id', 'salary_level_kh', 'salary_level_en'];


    // Get official rank info
    public function officialRanks()
    {
    	return $this->hasMany('App\Models\OfficialRank', 'salary_level_id');
    }
}
