<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiLevel extends Model
{
    use HasFactory;

    protected $table = 'sys_multi_levels';

    protected $primaryKey = 'multi_level_id';

    public $timestamps = false;

    protected $fillable = ['multi_level_id', 'multi_levels_kh', 'multi_levels_en'];
}
