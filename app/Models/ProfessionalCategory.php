<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalCategory extends Model
{
    use HasFactory;

    protected $table = 'sys_professional_categories';

    protected $primaryKey = 'prof_category_id';

    public $timestamps = false;

    protected $fillable = ['prof_category_id', 'prof_category_kh', 'prof_category_en', 'prof_hierachy'];
}
