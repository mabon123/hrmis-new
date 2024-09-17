<?php

namespace App\Models\TCP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionCategory extends Model
{
    use HasFactory;

    protected $table = 'tcp_prof_categories';
    protected $primaryKey = 'tcp_prof_cat_id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];
}
