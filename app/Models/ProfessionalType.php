<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalType extends Model
{
    use HasFactory;

    protected $table = 'sys_professional_types';

    protected $primaryKey = 'prof_type_id';

    public $timestamps = false;

    protected $fillable = ['prof_type_id', 'prof_type_kh', 'prof_type_en', 'active', 'created_by', 'updated_by'];

    const HEI = 1;
    const NIE = 2;
    const NIE2 = 3;
    const TowardBA = 4;
    const InternalExam = 5;
    const Integration = 6;
    const DSE = 7;
    const RTTC12_4 = 8;
    const RTTC12_2 = 9;
    const PTTC_RTTC = 10;
    const RTTC7_3 = 11;
    const PTTC12_4 = 12;
    const PTTC12_2 = 13;
    const PTTC9_2 = 14;
    const PTTC7_3 = 15;
    const PTTC7_1 = 16;
    const CentralKindergarten = 17;
    const PrimaryInspector = 18;
    const SecondaryInspector = 19;
    const Inspector = 20;


    // Get only active professional type
    public function scopeActive($query)
    {
    	return $query->where('active', 1);
    }
}
