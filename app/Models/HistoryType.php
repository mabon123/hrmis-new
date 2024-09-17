<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryType extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'sys_history_types';

    protected $primaryKey = 'his_type_id';

    public $timestamps = false;

    protected $fillable = ['his_type_id', 'his_type_kh', 'his_type_en', 'active'];
}
