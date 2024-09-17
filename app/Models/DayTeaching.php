<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayTeaching extends Model
{
    use HasFactory;

    protected $table = 'sys_day_teachings';

    protected $primaryKey = 'day_id';

    public $timestamps = false;

    protected $fillable = ['day_id', 'day_kh', 'day_en', 'day_order'];
}
