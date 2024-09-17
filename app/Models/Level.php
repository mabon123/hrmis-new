<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'admin_levels';

    protected $primaryKey = 'level_id';

    protected $fillable = ['level_id', 'level_kh', 'level_en', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // Relationship between level & user
    public function users()
    {
    	return $this->hasMany(User::class);
    }
}
