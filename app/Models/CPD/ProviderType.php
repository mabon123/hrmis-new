<?php

namespace App\Models\CPD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderType extends Model
{
    use HasFactory;

    protected $table = 'cpd_provider_types';
    protected $primaryKey = 'provider_type_id';

    protected $guarded = [];
    protected $casts = [];
}