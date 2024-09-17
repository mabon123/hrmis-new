<?php

namespace App\Models\TCP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionRecording extends Model
{
    use HasFactory;

    protected $table = 'tcp_prof_recordings';
    protected $primaryKey = 'tcp_prof_rec_id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];

    // Profession Category
    public function professionCategory()
    {
        return $this->belongsTo(ProfessionCategory::class, 'tcp_prof_cat_id');
    }

    // Profession Rank
    public function professionRank()
    {
        return $this->belongsTo(ProfessionRank::class, 'tcp_prof_rank_id');
    }
}
