<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPartnerType extends Model
{
    use HasFactory;

    protected $table = 'sys_training_partner_types';

    protected $primaryKey = 'partner_type_id';

    public $timestamps = false;

    protected $fillable = ['partner_type_kh', 'partner_type_en', 'active', 'created_by', 'updated_by'];


    // Get only active
    public function scopeActive($query)
    {
    	return $query->where('active', 1);
    }
}
