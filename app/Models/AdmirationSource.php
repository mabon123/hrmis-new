<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmirationSource extends Model
{
    use HasFactory;

    protected $table = 'sys_admiration_sources';

    protected $primaryKey = 'source_id';

    public $timestamps = false;

    protected $fillable = ['source_kh', 'source_en'];
}
