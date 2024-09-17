<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ethnic extends Model
{
    use HasFactory;

	protected $table = 'sys_ethnics';

	protected $primaryKey = 'ethnic_id';

	protected $fillable = ['ethnic_id', 'ethnic_kh', 'ethnic_en'];

	public $timestamps = false;
	
	public function residencemembers()
    {
		return $this->hasMany('App\Models\Residencemember');
    }
}
