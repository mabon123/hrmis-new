<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    use HasFactory;

    protected $table = 'sys_maritalstatus';

    protected $primaryKey = 'maritalstatus_id';

    public $timestamps = false;

    protected $fillable = ['maritalstatus_id', 'maritalstatus_kh', 'maritalstatus_en'];

    const Single = 1;
    const Married = 2;
    const Widow = 3;
    const Widower = 4;
}
