<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'sys_regions';

    protected $primaryKey = 'region_id';

    public $timestamps = false;

    protected $fillable = ['region_id', 'region_kh', 'region_en'];
}
