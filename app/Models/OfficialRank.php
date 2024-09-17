<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialRank extends Model
{
    use HasFactory;

    protected $table = 'sys_official_ranks';

    protected $primaryKey = 'official_rank_id';

    public $timestamps = false;

    protected $fillable = [
    	'official_rank_id', 'official_rank_kh', 'official_rank_en', 'salary_level_id', 'is_school'
	];


	/**
	 * Get salary level info
	 */
	public function salaryLevel()
	{
		return $this->belongsTo('App\Models\SalaryLevel', 'salary_level_id');
	}
}
