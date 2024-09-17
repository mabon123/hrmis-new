<?php

namespace App\Models\TCP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionRank extends Model
{
    use HasFactory;

    protected $table = 'tcp_prof_ranks';
    protected $primaryKey = 'tcp_prof_rank_id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];

    // Profession Category
    public function professionCategory()
    {
        return $this->belongsTo(ProfessionCategory::class, 'tcp_prof_cat_id');
    }
}
