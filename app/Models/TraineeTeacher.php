<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeTeacher extends Model
{
    use HasFactory;

    protected $table = 'hrmis_trainee_teachers';

    protected $primaryKey = 'trainee_payroll_id';

    protected $fillable = [
        'trainee_payroll_id', 'nid_card', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 'sex', 'dob',
        'year_id', 'stu_generation', 'start_date', 'end_date', 'result', 'subject_id1', 'subject_id2', 'prof_type_id',
        'maritalstatus_id', 'trainee_status_id', 'location_code', 'future_location_code', 'phone', 'emergency_phone',
        'photo', 'former_staff', 'birth_pro_code', 'birth_district', 'birth_commune', 'birth_village',
        'adr_pro_code', 'adr_dis_code', 'adr_com_code', 'adr_vil_code',
        'house_num', 'street_num', 'group_num', 'created_by', 'updated_by'

    ];

    public $casts = [
        'trainee_payroll_id' => 'string',
    ];

    public function spouse() {
        return $this->hasOne(TraineeFamily::class, 'trainee_payroll_id', 'trainee_payroll_id')->whereIn('relation_type_id', [1, 2]);
    }

    public function location() {
        return $this->hasOne(Location::class, 'location_code', 'location_code');
    }

    public function futureLocation() {
        return $this->hasOne(Location::class, 'location_code', 'future_location_code');
    }

    public function profession() {
        return $this->hasOne(ProfessionalType::class, 'prof_type_id', 'prof_type_id');
    }

    public function status() {
        return $this->hasOne(TraineeStatus::class, 'trainee_status_id', 'trainee_status_id');
    }

    public function subject1() {
        return $this->hasOne(Subject::class, 'subject_id', 'subject_id1');
    }

    public function subject2() {
        return $this->hasOne(Subject::class, 'subject_id', 'subject_id2');
    }
}
