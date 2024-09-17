<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationCode extends Model
{
    use HasFactory;

    protected $table = 'sys_qualification_codes';

    protected $primaryKey = 'qualification_code';

    public $timestamps = false;

    protected $fillable = ['qualification_code', 'qualification_kh', 'qualification_en', 'qualification_hierachy'];
}
