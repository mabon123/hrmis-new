<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeFamily extends Model
{
    use HasFactory;

    protected $table = 'hrmis_trainee_families';

    protected $primaryKey = 'trainee_fam_id';

    protected $fillable = [
        'trainee_fam_id', 'trainee_payroll_id', 'relation_type_id', 'fullname_kh', 'fullname_en',
        'is_alive', 'dob', 'gender', 'occupation', 'spouse_workplace', 'phone',
        'created_by', 'updated_by',
    ];
}
