<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMPMultiCriteriaSearch extends Model
{
    use HasFactory;

    protected $table = 'tmp_multi_criteria_search';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];
}
