<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staffs';
    protected $primaryKey = 'payroll_id';

    protected $fillable = [
    	'payroll_id', 'nid_card', 'bank_account', 'surname_kh', 'name_kh', 'surname_en',
    	'name_en', 'sex', 'dob', 'ethnic_id', 'photo', 'birth_pro_code', 'birth_district',
    	'birth_commune', 'birth_village', 'start_date', 'appointment_date', 'staff_status_id',
    	'maritalstatus_id', 'adr_pro_code', 'adr_dis_code', 'adr_com_code', 'adr_vil_code',
    	'house_num', 'street_num', 'group_num', 'address', 'phone', 'email', 'sbsk', 'sbsk_num',
    	'disability_teacher', 'disability_id', 'disability_note', 'created_by', 'updated_by',
        'dtmt_school', 'is_newly_transferred', 
        'is_cont_staff', 'former_staff', 'experience'
    ];

    public $casts = [
        'payroll_id' => 'string',
    ];

    // Get staff's ethnic
    public function ethnic()
    {
    	return $this->belongsTo('App\Models\Ethnic', 'ethnic_id');
    }

    // Get staff's status
    public function status()
    {
    	return $this->belongsTo('App\Models\StaffStatus', 'staff_status_id');
    }

    // Get staff's marital status
    public function maritalStatus()
    {
    	return $this->belongsTo('App\Models\MaritalStatus', 'maritalstatus_id');
    }

    // Get user created
    public function createdBy()
    {
    	return $this->belongsTo('App\Models\User', 'created_by');
    }

    // Highest Salary
    public function highestSalary()
    {
        return $this->staffSalaries()->orderBy('salary_type_signdate', 'DESC')->take(1);
    }

    // Get staff salary
    public function staffSalary()
    {
    	return $this->hasOne('App\Models\StaffSalary', 'payroll_id');
    }

    // lastCardreCercleDate
    public function lastCardreCercleDate()
    {
        return $this->hasOne('App\Models\StaffSalary', 'payroll_id')  
                ->where('cardre_type_id', 1)
                ->where(function($query) {
                    return $query   
                        ->where('request_cardre_check_status', 5)
                        ->orWhereNull('request_cardre_check_status');
                })
                ->orderBy('salary_type_signdate', 'DESC')
                ->orderBy('salary_level_id', 'ASC')
                ->orderBy('salary_degree', 'ASC')
                ;
    }

    // lastCardreSalary         ->  use
    public function lastCardreSalary()
    {
        return $this->hasOne('App\Models\StaffSalary', 'payroll_id')      
                ->where(function ($query){
                    $query->where('request_cardre_check_status',5)
                          ->orWhereNull('request_cardre_check_status');
                })
                ->orderBy('salary_type_signdate', 'DESC')
                ->orderBy('salary_level_id', 'ASC')
                ->orderBy('salary_degree', 'ASC')
                ;
    }
    // lastCardre       --> use
    public function lastCardre()
    {
        return $this->hasOne('App\Models\StaffSalary', 'payroll_id')      
                // ->orderBy('salary_type_signdate', 'DESC')
                // ->orderBy('salary_level_id', 'ASC')
                // ->orderBy('salary_degree', 'ASC')
                ->orderBy('salary_thanorn', 'ASC')                
                ;
    }

    // requestCardreCircle                  --> use
    public function requestCardreCircle()
    {
        return $this->hasOne('App\Models\StaffSalary', 'payroll_id')
                ->where('request_cardre_check_status', 1)
              ->where('cardre_type_id', 1)
                // ->orderBy('salary_type_signdate', 'DESC')
                // ->orderBy('salary_level_id', 'ASC')
                // ->orderBy('salary_degree', 'ASC')
                ->orderBy('salary_thanorn', 'ASC')       
                ;
    }

    // requestCardre  offset 1      --> use
    public function requestCardreOffeset1()
    {
        return $this->hasOne('App\Models\StaffSalary', 'payroll_id')   
                // ->where('request_cardre_check_status', 1)         
                // ->orderBy('salary_level_id', 'ASC')
                // ->orderBy('salary_degree', 'ASC')
                ->orderBy('salary_thanorn', 'ASC')       
                ->skip(1)->take(1)
                ;
    }
    // requestCardre offset 2      --> use
    public function requestCardreOffeset2()
    {
        return $this->hasOne('App\Models\StaffSalary', 'payroll_id')          
                // ->where('request_cardre_check_status', 1)   
                // ->orderBy('salary_level_id', 'ASC')
                // ->orderBy('salary_degree', 'ASC')
                ->orderBy('salary_thanorn', 'ASC')       
                ->skip(2)->take(1)
                ;
    }

    // requestCardreCertificate             --> use
    public function requestCardreCertificate()      
    {
        return $this->hasOne('App\Models\StaffSalary', 'payroll_id')
                ->where('request_cardre_check_status', 1)
                ->where('cardre_type_id', 2)
                // ->orderBy('salary_type_signdate', 'DESC')
                // ->orderBy('salary_level_id', 'ASC')
                // ->orderBy('salary_degree', 'ASC')
                ->orderBy('salary_thanorn', 'ASC')       
                ;
    }

    public function staffSalaries()
    {
        return $this->hasMany('App\Models\StaffSalary', 'payroll_id');
    }

    // Staff work history
    public function workHistories()
    {
    	return $this->hasMany('App\Models\WorkHistory', 'payroll_id');
    }

    // Current work history
    public function currentWorkHistory()
    {
        return $this->hasOne('App\Models\WorkHistory', 'payroll_id')->where('cur_pos', 1);
    }

    // Latest workhistory
    public function workHistory()
    {
        return $this->hasOne('App\Models\WorkHistory', 'payroll_id')->orderBy('start_date', 'desc');
    }

    // STAFF - ADMIRATION/BLAME
    public function admirations()
    {
        return $this->hasMany('App\Models\AdmirationBlame', 'payroll_id');
    }

    // Staff Leaves
    public function leaves()
    {
        return $this->hasMany('App\Models\StaffLeave', 'payroll_id');
    }

    // STAFF - GENERAL KNOWLEDGE
    public function knowledges()
    {
        return $this->hasMany('App\Models\StaffQualification', 'payroll_id');
    }
    public function highestQualification()
    {
        return $this->hasOne('App\Models\StaffQualification', 'payroll_id')
                    ->orderBy('qual_date', 'desc');
    }

    // STAFF - QUALIFICATION
    public function qualifications()
    {
        return $this->hasMany('App\Models\StaffProfessional', 'payroll_id');
    }
    public function highestPrefession()
    {
        return $this->qualifications()
                    ->join('sys_professional_categories as t2', 'hrmis_staff_professions.prof_category_id', '=', 't2.prof_category_id')
                    ->orderBy('t2.prof_hierachy', 'ASC')
                    ->select('hrmis_staff_professions.*')
                    ->take(1);
    }

    // STAFF - SHORT COURSE
    public function shortcourses()
    {
        return $this->hasMany('App\Models\ShortCourse', 'payroll_id');
    }

    // STAFF - LANGUAGES
    public function languages()
    {
        return $this->hasMany('App\Models\StaffLanguage', 'payroll_id');
    }

    // STAFF - FAMILIES INFO
    public function families()
    {
        return $this->hasMany('App\Models\StaffFamily', 'payroll_id');
    }

    // STAFF - FAMILY INFO - SPOUSE
    public function spouse()
    {
        return $this->hasOne('App\Models\StaffFamily', 'payroll_id')->whereIn('relation_type_id', [1, 2]);
    }

    // STAFF - TEACHING
    public function teachings()
    {
        return $this->hasMany('App\Models\StaffTeaching', 'payroll_id');
    }
    public function currentTeaching()
    {
        $currentAcademic = \App\Models\AcademicYear::current()->first();

        return $this->teachings()->where('year_id', $currentAcademic->year_id);
    }

    // STAFF - TEACHING SUBJECTS
    public function teachingSubjects()
    {
        return $this->hasMany('App\Models\TeachingSubject', 'payroll_id');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'payroll_id');
    }

    // POB - province
    public function birthProvince()
    {
        return $this->belongsTo('App\Models\Province', 'birth_pro_code', 'pro_code');
    }

    // Address - Village
    public function addressVillage()
    {
        return $this->belongsTo('App\Models\Village', 'adr_vil_code', 'vil_code');
    }

    // Address - Commune
    public function addressCommune()
    {
        return $this->belongsTo('App\Models\Commune', 'adr_com_code', 'com_code');
    }

    // Address - District
    public function addressDistrict()
    {
        return $this->belongsTo('App\Models\District', 'adr_dis_code', 'dis_code');
    }

    // Address - Province
    public function addressProvince()
    {
        return $this->belongsTo('App\Models\Province', 'adr_pro_code', 'pro_code');
    }

    public function getFullNameKHAttribute()
    {
        return $this->surname_kh.' '.$this->name_kh;
    }

    public function getFullNameENAttribute()
    {
        return $this->surname_en.' '.$this->name_en;
    }

    public function currentWork()
    {
        return $this->hasOne('App\Models\WorkHistory', 'payroll_id')->where('cur_pos', 1)->orderBy('start_date', 'desc');
    }



    public function currentWorkPlace()
    {
        $curWorkHist = $this->workHistories()->where('cur_pos', 1)->first();

       // return $curWorkHist->location;
       return $curWorkHist ? $curWorkHist->location : null;
    }

    

    public function currentPosition()
    {
        $curWorkHist = $this->workHistories()->where('cur_pos', 1)->first();

        return $curWorkHist->position;
    }

    public function contractPosition()
    {
        $curWorkHist = $this->workHistories()->where('cur_pos', 1)->first();

        return $curWorkHist->contractType;
    }

    // Latest workhistory
    public function latestWorkHistory()
    {
        $workHist = $this->workHistories()->orderBy('start_date', 'desc')->first();

        return $workHist;
    }

    // Latest Workplace
    public function latestWorkPlace()
    {
        $workHist = $this->workHistories()->orderBy('created_at', 'desc')->first();

        return $workHist ? $workHist->location : null;
    }
    // STAFF - TEACHER SUBJECTS
    public function teacherSubjects()
    {
        return $this->hasMany(Timetables\TeacherSubject::class, 'payroll_id');
    }

    // Transfer info
    public function transfers()
    {
        return $this->hasMany(StaffMovement::class, 'payroll_id');
    }

    // TCP Profession
    public function TCPProfessions()
    {
        return $this->hasMany(TCP\ProfessionRecording::class, 'payroll_id');
    }

    public function profileChecks()
    {
        return $this->hasMany(Profile\ProfileCheck::class, 'payroll_id');
    }

    public function cpdEnrollmentCourses()
    {
        return $this->hasMany(CPD\EnrollmentCourse::class, 'payroll_id');
    }

    public function cpdProviders()
    {
        return $this->hasMany(CPD\Provider::class, 'payroll_id');
    }

    public function disability()
    {
        return $this->belongsTo(Disability::class, 'disability_id');
    }
}
