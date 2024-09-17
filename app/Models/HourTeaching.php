<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourTeaching extends Model
{
    use HasFactory;

    protected $table = 'sys_hour_teachings';

    protected $primaryKey = 'hour_id';

    public $timestamps = false;

    protected $fillable = ['hour_id', 'hour_kh', 'hour_en', 'hour_order'];
}
