<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'sys_countries';

    protected $primaryKey = 'country_id';

    public $timestamps = false;

    protected $fillable = ['country_id', 'country_kh', 'country_en', 'active'];


    // Active country
    public function scopeActive($query)
    {
    	return $query->where('active', 1);
    }
}
