<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    use HasFactory;

    protected $table = 'sys_disabilities';

    protected $primaryKey = 'disability_id';

    public $timestamps = false;

    protected $fillable = ['disability_id', 'disability_kh', 'disability_en'];
}
