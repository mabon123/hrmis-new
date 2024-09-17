<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Permissions\HasPermissionsTrait;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Staff;
use App\Models\Location;
use App\Models\LocationType;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait, HasApiTokens;

    protected $table = 'admin_users';

    protected $fillable = [
        'username', 'password',
        'payroll_id', 'level_id',
        'user_type',
        'nid_card',
        'provider_id',
        'status',
        'approver_id',
        'approved_date',
        'validate_type',
        'active',
        'reg_type',
        'lastdate_login',
        'created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    protected $appends = ['work_place', 'location_type_ids'];

    // Relationship between user & level
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    // Staff info
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'payroll_id');
    }

    public function getWorkPlaceAttribute() {
        $staff = Staff::where('payroll_id', $this->payroll_id)->first();
        if ($staff) {
            $curWorkPlace = $staff->currentWorkPlace();
            if ($curWorkPlace) {
                return (object) [
                    'pro_code' => $curWorkPlace->pro_code,
                    'dis_code' => $curWorkPlace->dis_code,
                    'com_code' => $curWorkPlace->com_code,
                    'location_code' => $curWorkPlace->location_code, 
                    'location_kh' => $curWorkPlace->location_kh, 
                    'parent_location_code' => $curWorkPlace->parent_location_code, 
                    'location_type_id' => $curWorkPlace->location_type_id, 
                    'multi_level_edu' => $curWorkPlace->multi_level_edu, 
                ];
            }
        }
        return (object) [
            'pro_code' => null,
            'dis_code' => null,
            'com_code' => null,
            'location_code' => null, 
            'location_kh' => null, 
            'parent_location_code' => null, 
            'location_type_id' => null, 
            'multi_level_edu' => null, 
        ];
    }

    public function getLocationTypeIdsAttribute() {
        $levels = [];
        if (auth()->check() && auth()->user()->hasRole('dept-admin')) {
            $levels = [LocationType::LevelDept];
        } elseif (auth()->check() && auth()->user()->hasRole('poe-admin')) {
            $levels = [LocationType::LevelPoe, LocationType::LevelDoe, LocationType::LevelSchool];
        } elseif (auth()->check() && auth()->user()->hasRole('doe-admin')) {
            $levels = [LocationType::LevelDoe, LocationType::LevelSchool];
        } elseif (auth()->check() && auth()->user()->hasRole('school-admin')) {
            $levels = [LocationType::LevelSchool];
        } else {
            $levels = [LocationType::LevelDept, LocationType::LevelPoe, LocationType::LevelDoe, LocationType::LevelSchool];;
        }
        $ids = LocationType::whereIn('level_id', $levels)
                            ->pluck('location_type_id')
                            ->all();
        return $ids;
    }

    public function getIsTtdOrDoperAttribute() {
        $workPlace = auth()->user()->work_place;
        if (auth()->user()->hasRole('administrator')) return true;
        if (!$workPlace->location_code) return false;
        return in_array($workPlace->location_code, ['99160202000', '99160307000']); //TTD & DoPer
    }

    public function getIsTtcAttribute() {
        $workPlace = auth()->user()->work_place;
        if (auth()->user()->hasRole('administrator')) return true;
        if (!$workPlace->location_code) return false;
        $location = Location::select()
                            ->where(function($q) {
                                $q->whereIn('location_type_id', [LocationType::RTTC, LocationType::PTTC, LocationType::PreTTC])
                                ->orWhere(function($q) {
                                    $q->where('location_type_id', LocationType::Institute)
                                        ->whereIn('location_code', ['99160008000', '99161800000', '99160006000']);
                                });
                            })
                            ->where('location_code', $workPlace->location_code)
                            ->first();
        return !!$location;
    }
}
