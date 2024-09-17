<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportHeader extends Model
{
    use HasFactory;

    protected $table = 'sys_report_headers';
    protected $primaryKey = 'header_id';

    protected $guarded = [];

    public $timestamps = false;
}
