<?php
namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Village;
use App\Models\AcademicYear;
use App\Models\LocationType;
use App\Models\Location;
use App\Models\LocationHistory;
use App\Models\Region;
use App\Http\Requests\SchoolRequest;
use App\Models\AdminOffice;
use App\Models\ContractTeacherHistory;
use App\Models\Staff;
use App\Models\StaffMovement;
use App\Models\StaffProfessional;
use App\Models\StaffTeaching;
use App\Models\TraineeTeacher;
use App\Models\Timetables\TimetableGrade;
use App\Models\Timetables\TimetablePrimary;
use App\Models\Timetables\TeacherPrimary;
use App\Models\Timetables\TeacherSubject;
use App\Models\Timetables\Timetable;
use App\Models\WorkHistory;
use App\Models\MultiLevel;

class SchoolController extends Controller
{
    private $gdIds;
    private $departmentIds;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-schools', ['only' => ['index']]);
        $this->middleware('permission:create-schools', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-schools', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-schools', ['only' => ['destroy']]);

        $this->gdIds = [LocationType::GD, LocationType::University, LocationType::Institute];
        $this->departmentIds = [LocationType::Department, LocationType::Institute, LocationType::RTTC, LocationType::PTTC, LocationType::PreTTC];
    }

    public function index()
    {
        $curWorkPlace = auth()->user()->work_place;
        $provinces = Province::active()
                            ->when(auth()->user()->level_id == 4, function($q) use ($curWorkPlace) {
                                $q->where('pro_code', $curWorkPlace->pro_code);
                            })
                            ->when(auth()->user()->level_id == 3, function($q) use ($curWorkPlace) {
                                $q->where('pro_code', $curWorkPlace->pro_code);
                            })
                            ->pluck('name_kh', 'pro_code')
                            ->all();

        $districts = District::active()
                            ->when((auth()->user()->level_id == 4 || auth()->user()->level_id == 3 || auth()->user()->level_id == 2), function($q) use ($curWorkPlace) {
                                $q->where('pro_code', $curWorkPlace->pro_code);
                                if(auth()->user()->level_id == 4) {
                                    $q->where('dis_code', $curWorkPlace->dis_code);
                                }
                            }, function ($q) {
                                $q->where('pro_code', request()->get('pro_code', null));
                            })
                            ->pluck('name_kh', 'dis_code')
                            ->all();
        
        $communes = Commune::select()
                            ->when(auth()->user()->hasRole('doe-admin'), function($q) use ($curWorkPlace) {
                                $q->where('dis_code', $curWorkPlace->dis_code);
                            }, function ($q) {
                                $q->where('dis_code', request()->get('dis_code', null));
                            })
                            ->pluck('name_kh', 'com_code')
                            ->all();

        $villages = Village::whereComCode(request()->get('com_code', null))
                            ->pluck('name_kh', 'vil_code')
                            ->all();

        $locations = collect();
        if (request()->search || auth()->user()->hasRole('dept-admin', 'school-admin')) {
            $locations = Location::with('locationType', 'currentLocationHistory')
                            ->when(auth()->user()->hasRole('dept-admin', 'school-admin'), function ($q) use ($curWorkPlace) {
                                $q->where('location_code', $curWorkPlace->location_code);
                            })
                            ->when(auth()->user()->hasRole('poe-admin', 'doe-admin'), function($q) use ($curWorkPlace) {
                                $q->where('pro_code', $curWorkPlace->pro_code)
                                    ->when(auth()->user()->hasRole('doe-admin'), function ($q) use ($curWorkPlace) {
                                        $q->where('dis_code', $curWorkPlace->dis_code);
                                    }, function($q) {
                                        $q->when(request()->dis_code, function($q) {
                                            $q->whereDisCode(request()->dis_code);
                                        });
                                    });
                            }, function ($q) {
                                $q->when(request()->pro_code, function($q) {
                                    $q->whereProCode(request()->pro_code)
                                    ->orderBy('location_kh', 'asc');;
                                })
                                ->when(request()->dis_code, function($q) {
                                    $q->whereDisCode(request()->dis_code)
                                    ->orderBy('location_kh', 'asc');;
                                });
                            })
                            ->when(request()->com_code, function($q) {
                                $q->whereComCode(request()->com_code)
                                ->orderBy('location_kh', 'asc');;
                            })
                            ->when(request()->vil_code, function($q) {
                                $q->whereVilCode(request()->vil_code)
                                ->orderBy('location_kh', 'asc');;
                            })
                            ->whereIn('location_type_id', auth()->user()->location_type_ids)
                            ->when(request()->location_type_id, function($q) {
                                $q->whereLocationTypeId(request()->location_type_id)
                                ->orderBy('location_kh', 'asc');;
                            })
                            ->when(request()->name, function($q) {
                                $q->where(function($q) {
                                    $q->where('location_en', 'LIKE', '%'.request()->name.'%')
                                        ->orWhere('location_kh', 'LIKE', '%'.request()->name.'%')
                                        ->orWhere('location_code', request()->name)
                                        ->orderBy('location_kh', 'asc');
                                });
                            })
                            ->orderBy('location_kh', 'asc')
                            ->paginate(10);
        }

        return view('admin.schools.index', [
            'provinces' => $provinces,
            'districts' => $districts,
            'communes' => $communes,
            'villages' => $villages,
            'regions' => $this->getRegions(),
            'locationTypes' => $this->getLocationTypes(),
            'locations' => $locations,
        ]);
    }

    public function create()
    {

        $provinces = Province::active()
                            ->when(auth()->user()->hasRole('doe-admin', 'poe-admin', 'school-admin'), function ($q) {
                                $q->where('pro_code', auth()->user()->work_place->pro_code);
                            })
                            ->pluck('name_kh', 'pro_code')
                            ->all();

        return view('admin.schools.add-edit', [
            'provinces' => $provinces,
            'regions' => $this->getRegions(),
            'multilevels'=>$this->getMultiLevels(),
            'locationTypes' => $this->getLocationTypes(),
            'academicYears' => $this->getAcademicYears(),
            'generalDepartments' => $this->getGeneralDepartments(),
            'rttcs' => $this->getLocationByLocationType(LocationType::RTTC),
            'pttcs' => $this->getLocationByLocationType(LocationType::PTTC),
            'institutes' => $this->getLocationByLocationType(LocationType::Institute),
            'underMoeyIds' => LocationType::whereUnderMoeys(true)->pluck('location_type_id')->all(),
            'schoolIds' => LocationType::whereIsSchool(true)->pluck('location_type_id')->all()
        ]);
    }

    public function store(SchoolRequest $request)
    {
        try {
            $code = $this->createOrUpdate($request->except('_method', '_token'));
            return redirect()->route('schools.edit', [app()->getLocale(), $code])->withSuccess(__('school.success.created'));
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function edit(Location $school = null)
    {
        $school = Location::where('location_code', $school->location_code)
                        ->whereIn('location_type_id', auth()->user()->location_type_ids)
                        ->first();
        if (!$school) {
            return redirect()->route('page.notfound', app()->getLocale());
        }
        $workPlace = auth()->user()->work_place;
        $provinces = Province::active()
                            ->when(auth()->user()->hasRole('doe-admin', 'poe-admin', 'school-admin'), function ($q) use ($workPlace) {
                                $q->where('pro_code', $workPlace->pro_code);
                            })
                            ->pluck('name_kh', 'pro_code')
                            ->all();

        $districts = District::active()
                            ->whereProCode($school->pro_code)
                            ->when(auth()->user()->hasRole('doe-admin', 'school-admin'), function ($q) use ($workPlace) {
                                $q->where('pro_code', $workPlace->pro_code)
                                    ->where('dis_code', $workPlace->dis_code);
                            })
                            ->pluck('name_kh', 'dis_code')
                            ->all();

        $communes = Commune::whereDisCode($school->dis_code)
                            ->pluck('name_kh', 'com_code')
                            ->all();

        $villages = Village::whereComCode($school->com_code)
                            ->pluck('name_kh', 'vil_code')
                            ->all();

        $curYearofAcademic = Carbon::now()->month == 12 ? Carbon::now()->year : (Carbon::now()->year - 1);
        $academicYear = AcademicYear::select()
                            ->when(request()->year_id, function ($q) {
                                $q->whereYearId(request()->year_id);
                            })
                            ->when(!request()->year_id, function ($q) use($curYearofAcademic) {
                                $q->where('year_en', 'LIKE', $curYearofAcademic . '-%');
                            })
                            ->first();
        $academicYearID = $academicYear ? $academicYear->year_id : 1;
        $currentAcademicYear = AcademicYear::where('year_en', 'LIKE', $curYearofAcademic . '-%')->orderBy('year_id', 'DESC')->first();
        $curAcademicYearID = $currentAcademicYear ? $currentAcademicYear->year_id : 1;

        $locationHistory = $school->locationHistories()->whereYearId($academicYearID)->first();
        $mainSchoolLocations = Location::where('dis_code', $school->dis_code)->where('location_code', '!=', $school->location_code)->pluck('location_kh', 'location_code')->all();       
        $clasterSchoolLocations = Location::where('pro_code', $school->pro_code)->pluck('location_kh', 'location_code')->all();       
        $isCurrentAcademicYear = $curAcademicYearID === $academicYearID;
        $isCurrentMonthEditable = in_array(Carbon::now()->month, [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12]);

        return view('admin.schools.add-edit', [
            'headerid' => $school->location_code,
            'location' => $school,
            'mainSchoolLocations' => $mainSchoolLocations,   
            'clasterSchoolLocations' => $clasterSchoolLocations,      
            'locationHistory' => $locationHistory,
            'provinces' => $provinces,
            'districts' => $districts,
            'communes' => $communes,
            'villages' => $villages,
            'regions' => $this->getRegions(),
            'multilevels'=>$this->getMultiLevels(),
            'locationTypes' => $this->getLocationTypes(),
            'academicYears' => $this->getAcademicYears(),
            'academicYear' => $academicYear,
            'isEditableStudentInfo' => $isCurrentAcademicYear && $isCurrentMonthEditable,
            'gradingTypes' => $this->getGradingTypes(),
            'generalDepartments' => $this->getGeneralDepartments($school->location_code),
            'rttcs' => $this->getLocationByLocationType(LocationType::RTTC),
            'pttcs' => $this->getLocationByLocationType(LocationType::PTTC),
            'institutes' => $this->getLocationByLocationType(LocationType::Institute),
            'underMoeyIds' => LocationType::whereUnderMoeys(true)->pluck('location_type_id')->all(),
            'schoolIds' => LocationType::whereIsSchool(true)->pluck('location_type_id')->all(),
        ]);
    }

    public function update(SchoolRequest $request, Location $school)
    {
        try {
            $code = $this->createOrUpdate($request->except('_method', '_token'), $school);
            return redirect()->route('schools.edit', [app()->getLocale(), $code])->withSuccess(__('school.success.updated'));
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function destroy(Location $school)
    {
        try {
            $school->delete();
            return redirect()->back()->withSuccess(__('school.success.deleted'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function createOrUpdate($data, Location $school = null) {
        $locationCodeChanged = false;
        $oldLocationCode = '';
        $locationCode = $data['location_code'] = implode('',$data['location_codes']);

        if ($school) {
            $oldLocationCode = $school->location_code;
            $locationCodeChanged = $school->location_code !== (int)$locationCode;
            $data['updated_by'] = auth()->id();
        } else {
            $school = new Location;
            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();
        }

        if (auth()->user()->hasRole('poe-admin', 'doe-admin', 'school-admin')) {
            $data['pro_code'] = auth()->user()->work_place->pro_code;
            if (auth()->user()->hasRole('doe-admin', 'school-admin')) {
                $data['dis_code'] = auth()->user()->work_place->dis_code;
            }
        }

        // Reset Parent Location Code
        if ((int)$data['location_type_id'] === LocationType::POE || (int)$data['location_type_id'] === LocationType::MoEYs) {
            $data['sub_location'] = false;
            $data['parent_location_code'] = '';
        } else if (in_array((int)$data['location_type_id'], [LocationType::GD, LocationType::University])) {
            $data['parent_location_code'] = '99160000000';
        } else if ((int)$data['location_type_id'] === LocationType::PracticalPrimarySchool) {
            $data['parent_location_code'] = $data['pttc_location_code'];
            $data['sub_location'] = true;
        } else if ((int)$data['location_type_id'] === LocationType::PracticalSecondarySchool) {
            $data['parent_location_code'] = $data['rttc_location_code'];
            $data['sub_location'] = true;
        } else if ((int)$data['location_type_id'] === LocationType::PracticalHighSchool) {
            $data['parent_location_code'] = $data['institute_location_code'];
            $data['sub_location'] = true;
        } else if (in_array((int)$data['location_type_id'], [LocationType::DOE, LocationType::CES])) {
            $poe = Location::where('location_type_id', LocationType::POE)->where('pro_code', $data['pro_code'])->first();
            if ($poe) {
                $data['parent_location_code'] = $poe->location_code;
            }
            $data['sub_location'] = true;

        } else if (in_array((int)$data['location_type_id'], [LocationType::HighSchool, LocationType::SecondarySchool, LocationType::PrimarySchool, LocationType::PreSchool, LocationType::IslamSchool])) {
            $doe = Location::where('location_type_id', LocationType::DOE)->where('dis_code', $data['dis_code'])->first();
            if ($doe) {
                $data['parent_location_code'] = $doe->location_code;
            }
            $data['sub_location'] = true;
        } else {
            if ($data['sub_location']) {
                $data['parent_location_code'] = $data['gd_location_code'];
            }
        }

        // Reset Main School
        if (isset($data['school_annex']) && !$data['school_annex']) {
            $data['main_school'] = null;
        }

        // Reset Prokah
        if (isset($data['prokah']) && !$data['prokah']) {
            $data['prokah_num'] = null;
            $data['prokah_attachment'] = null;
        }
        
        $data['multi_level_edu'] = isset($data['multi_level_edu']) ? $data['multi_level_edu'] : null;

        $school->fill($data);

        if ($school->save()) {

            $location = Location::findOrFail($locationCode);
            if ($location->prokah && isset($data['prokah_attachment'])) {
                $file = $data['prokah_attachment'];
                $filename = $location->location_code . '.' . $file->getClientOriginalExtension();
                $refDocPath = $file->storeAs('/attachments/locations', $filename, ['disk' => 'public']);
                $location->update(['ref_doc' => '/storage/'.$refDocPath]);
            }

            if (!$school->wasRecentlyCreated) {
                if ($school->locationType && $school->locationType->is_school) {
                    if ($locationCodeChanged) {
                        LocationHistory::where('location_code', $oldLocationCode)->update(['location_code' => $locationCode]);
                        WorkHistory::where('location_code', $oldLocationCode)->update(['location_code' => $locationCode]);
                        ContractTeacherHistory::where('location_code', $oldLocationCode)->update(['location_code' => $locationCode]);
                        TraineeTeacher::where('location_code', $oldLocationCode)->update(['location_code' => $locationCode]);
                        StaffTeaching::where('location_code', $oldLocationCode)->update(['location_code' => $locationCode]);
                        StaffProfessional::where('location_code', $oldLocationCode)->update(['location_code' => $locationCode]);
                        AdminOffice::where('location_code', $oldLocationCode)->update(['location_code' => $locationCode]);
                        StaffMovement::where('old_location_code', $oldLocationCode)->update(['old_location_code' => $locationCode]);
                        StaffMovement::where('new_location_code', $oldLocationCode)->update(['new_location_code' => $locationCode]);
                        TimetableGrade::where('location_code',$oldLocationCode)->update(['location_code'=>$locationCode]);
                        TimetablePrimary::where('location_code',$oldLocationCode)->update(['location_code'=>$locationCode]);
                        TeacherPrimary::where('location_code',$oldLocationCode)->update(['location_code'=>$locationCode]);
                        TeacherSubject::where('location_code',$oldLocationCode)->update(['location_code'=>$locationCode]);
                        Timetable::where('location_code',$oldLocationCode)->update(['location_code'=>$locationCode]);
                    }

                    if (isset($data['student_info']['year_id'])) {

                        foreach ($data['student_info'] as $key => $value) {
                            $data['student_info'][$key] = (int) $value;
                        }

                        LocationHistory::updateOrCreate(
                            ['year_id' =>  $data['student_info']['year_id'], 'location_code' => $locationCode],
                            $data['student_info']
                        );
                    }
                }
            }
        }

        return $locationCode;
    }

    public function getLocationTypes() {
        return LocationType::orderBy('location_type_id', 'asc')
                        ->where('location_type_id', '!=', 1)
                        ->whereIn('location_type_id', auth()->user()->location_type_ids)
                        ->pluck('location_type_kh', 'location_type_id')
                        ->all();
    }

    public function getAcademicYears() {
        return AcademicYear::all()
                        ->pluck('year_en', 'year_id')
                        ->sortDesc()
                        ->all();
    }

    public function getRegions() {
        return Region::all()->pluck('region_kh', 'region_id')->all();
    }
    public function getMultiLevels()
    {
        return MultiLevel::pluck('multi_levels_kh', 'multi_level_id')->all();
    }
    public function getGeneralDepartments($currentGdCode = null) {
        return Location::select()
                    ->whereIn('location_type_id', [LocationType::GD])
                    ->where('location_code', 'LIKE', '9916%')
                    ->orderBy('location_code', 'asc')
                    ->when($currentGdCode, function ($q) use ($currentGdCode) {
                        $q->where('location_code', '!=', $currentGdCode);
                    })
                    ->pluck('location_kh', 'location_code')
                    ->all();
    }

    public function getLocationByLocationType($locationTypeId = null) {
        $locations = Location::select()
                        ->where('location_type_id', $locationTypeId)
                        ->when(in_array($locationTypeId, [LocationType::RTTC, LocationType::PTTC, LocationType::Institute]), function ($q) {
                            $q->orWhere('location_kh', 'វិទ្យាស្ថានជាតិអប់រំ');
                        })
                        ->pluck('location_kh', 'location_code')
                        ->all();

        return $locations;

    }

    public function getGradingTypes() {
        $gradingTypes = [
            [
                [
                    'id' => LocationType::PreSchool,
                    'key' => 'preschool',
                    'name' => __('school.preschool'),
                    'grades' => [
                        [
                            'name' => __('school.preschool_lower'),
                            'keys' => ['preschool_num', 'preschoolf_num', 'preschool_totalclass_num',]
                        ],
                        [
                            'name' => __('school.preschool_medium'),
                            'keys' => ['preschool_medium_num', 'preschool_mediumf_num', 'preschool_mediumtotalclass_num',]
                        ],
                        [
                            'name' => __('school.preschool_high'),
                            'keys' => ['preschool_high_num', 'preschool_highf_num', 'preschool_hightotalclass_num',]
                        ],
                        [
                            'name' => __('school.preschool_mix'),
                            'keys' => ['preschool_mix_num', 'preschool_mixf_num', 'preschool_mixtotalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::PrimarySchool,
                    'key' => 'primary_school',
                    'name' => __('school.primary_school'),
                    'grades' => [
                        [
                            'name' => __('school.grade_1_class'),
                            'keys' => ['grade1_num', 'grade1f_num', 'grade1totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_2_class'),
                            'keys' => ['grade2_num', 'grade2f_num', 'grade2totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_3_class'),
                            'keys' => ['grade3_num', 'grade3f_num', 'grade3totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_4_class'),
                            'keys' => ['grade4_num', 'grade4f_num', 'grade4totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_5_class'),
                            'keys' => ['grade5_num', 'grade5f_num', 'grade5totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_6_class'),
                            'keys' => ['grade6_num', 'grade6f_num', 'grade6totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::PrimarySchool,
                    'key' => 'acceleration_class',
                    'name' => __('school.acceleration_class'),
                    'grades' => [
                        [
                            'name' => __('school.year_1_acceleration_class'),
                            'keys' => ['acceleration_class_y1_num', 'acceleration_class_y1f_num', 'acceleration_y1totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_2_acceleration_class'),
                            'keys' => ['acceleration_class_y2_num', 'acceleration_class_y2f_num', 'acceleration_y2totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_3_acceleration_class'),
                            'keys' => ['acceleration_class_y3_num', 'acceleration_class_y3f_num', 'acceleration_y3totalclass_num',]
                        ],
                    ],
                ],            
                [
                    'id' => LocationType::SecondarySchool,
                    'key' => 'secondary_school',
                    'name' => __('school.secondary_school'),
                    'grades' => [
                        [
                            'name' => __('school.grade_7_class'),
                            'keys' => ['grade7_num', 'grade7f_num', 'grade7totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_8_class'),
                            'keys' => ['grade8_num', 'grade8f_num', 'grade8totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_9_class'),
                            'keys' => ['grade9_num', 'grade9f_num', 'grade9totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::HighSchool,
                    'key' => 'high_school',
                    'name' => __('school.high_school'),
                    'grades' => [
                        [
                            'name' => __('school.grade_10_class'),
                            'keys' => ['grade10_num', 'grade10f_num', 'grade10totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::HighSchool,
                    'key' => 'science_class',
                    'name' => __('school.science_class'),
                    'grades' => [
                        [
                            'name' => __('school.grade_11_class'),
                            'keys' => ['grade11_num', 'grade11f_num', 'grade11totalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_12_class'),
                            'keys' => ['grade12_num', 'grade12f_num', 'grade12totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::HighSchool,
                    'key' => 'social_class',
                    'name' => __('school.social_class'),
                    'grades' => [
                        [
                            'name' => __('school.grade_11_class'),
                            'keys' => ['grade11so_num', 'grade11sof_num', 'grade11sototalclass_num',]
                        ],
                        [
                            'name' => __('school.grade_12_class'),
                            'keys' => ['grade12so_num', 'grade12sof_num', 'grade12sototalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::HighSchool,
                    'key' => 'technical_school',
                    'name' => __('school.technical_school'),
                    'grades' => [
                        [
                            'name' => __('school.year_1'),
                            'keys' => ['technical_class_y1_num', 'technical_class_y1f_num', 'technical_y1totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_2'),
                            'keys' => ['technical_class_y2_num', 'technical_class_y2f_num', 'technical_y2totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_3'),
                            'keys' => ['technical_class_y3_num', 'technical_class_y3f_num', 'technical_y3totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::PreTTC,
                    'key' => 'preschool_ttc',
                    'name' => __('school.preschool_ttc'),
                    'grades' => [
                        [
                            'name' => __('school.year_1'),
                            'keys' => ['psttc_class_y1_num', 'psttc_class_y1f_num', 'psttc_y1totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_2'),
                            'keys' => ['psttc_class_y2_num', 'psttc_class_y2f_num', 'psttc_y2totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::RTTC,
                    'key' => 'rttc',
                    'name' => __('school.rttc'),
                    'grades' => [
                        [
                            'name' => __('school.year_1'),
                            'keys' => ['rttc_class_y1_num', 'rttc_class_y1f_num', 'rttc_y1totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_2'),
                            'keys' => ['rttc_class_y2_num', 'rttc_class_y2f_num', 'rttc_y2totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_3'),
                            'keys' => ['rttc_class_y3_num', 'rttc_class_y3f_num', 'rttc_y3totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_4'),
                            'keys' => ['rttc_class_y4_num', 'rttc_class_y4f_num', 'rttc_y4totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::PTTC,
                    'key' => 'pttc',
                    'name' => __('school.pttc'),
                    'grades' => [
                        [
                            'name' => __('school.year_1'),
                            'keys' => ['pttc_class_y1_num', 'pttc_class_y1f_num', 'pttc_y1totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_2'),
                            'keys' => ['pttc_class_y2_num', 'pttc_class_y2f_num', 'pttc_y2totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::Institute,
                    'key' => 'institute',
                    'name' => __('school.institute'),
                    'grades' => [
                        [
                            'name' => __('school.year_1'),
                            'keys' => ['nie_class_y1_num', 'nie_class_y1f_num', 'nie_y1totalclass_num',]
                        ],
                        [
                            'name' => __('school.year_2'),
                            'keys' => ['nie_class_y2_num', 'nie_class_y2f_num', 'nie_y2totalclass_num',]
                        ],
                    ],
                ],
                [
                    'id' => LocationType::CES,
                    'key' => 'ces',
                    'name' => null,
                    'grades' => [
                        [
                            'name' => __('school.ces'),
                            'keys' => ['ces_class_num', 'ces_class_f_num', 'ces_totalclass_num',]
                        ],
                    ],
                ],
            ],            
        ];
        return $gradingTypes;
    }

    public function ajaxGetPrimarySchoolByDistrictCode(Request $request, $code) {
        return Location::select('location_code', 'location_kh', 'dis_code', 'location_type_id')
                    ->where('dis_code', $code)
                    ->where('location_code', '!=', $request->location_code)
                    ->where('location_type_id', LocationType::PrimarySchool)
                    ->get()
                    ->toArray();
    }

    public function ajaxGetNextGDIncrement(Request $request) {
        if ($request->location_code) {
            $lastGDId = (int) substr($request->location_code, 4, -5);

            return str_pad($lastGDId, 2, '0', STR_PAD_LEFT);
        }
        $nextCount = '01';
        $lastGD = Location::select()
                    ->whereIn('location_type_id', $this->gdIds)
                    ->where('location_code', 'LIKE', '9916%')
                    ->orderBy('location_code', 'desc')
                    ->first();
        if ($lastGD) {
            $lastGDId = (int) substr($lastGD->location_code, 4, -5);
            $nextCount = str_pad($lastGDId + 1, 2, '0', STR_PAD_LEFT);
        }

        return $nextCount;
    }

    public function ajaxGetNextDepartmentIncrement(Request $request) {
        if ($request->location_code) {
            $location = Location::findOrFail($request->location_code);
            $lastDepId = (int) substr($location->location_code, 6, -3);
            $code = str_pad($lastDepId, 2, '0', STR_PAD_LEFT);
            if ($location->parent_location_code === '99160000000') {
                if (!$request->gd_code && $code !== '00') {
                    return $code;
                }
            } else {
                if ($request->gd_code && $location->parent_location_code === $request->gd_code) {
                    return $code;
                }

            }
        }

        $nextCount = '01';
        $lastDep = Location::select()
                    ->whereIn('location_type_id', $this->departmentIds)
                    ->where('location_code', 'LIKE', '9916%')
                    ->whereSubLocation(true)
                    ->when($request->gd_code, function ($q) use ($request) {
                        $q->whereParentLocationCode($request->gd_code);
                    })
                    ->when(!$request->gd_code, function ($q) use ($request) {
                        $q->where('location_code', 'LIKE', '991600%');
                    })
                    ->orderBy('location_code', 'desc')
                    ->first();

        if ($lastDep) {
            $lastDepId = (int) substr($lastDep->location_code, 6, -3);
            $nextCount = str_pad($lastDepId + 1, 2, '0', STR_PAD_LEFT);
        }

        return $nextCount;
    }

    public function ajaxGetAnowatSchoolNextIncrement(Request $request) {
        if ($request->location_code) {
            $location = Location::findOrFail($request->location_code);
            if ($location->parent_location_code === $request->parent_code) {
                $last = (int) substr($location->location_code, -3);
                return str_pad($last, 3, '0', STR_PAD_LEFT);
            }
        }

        $nextCount = '001';
        $last = Location::select()
                    ->where('location_code', 'LIKE', '9916%')
                    ->whereSubLocation(true)
                    ->when($request->parent_code, function ($q) use ($request) {
                        $q->whereParentLocationCode($request->parent_code);
                    })
                    ->when(!$request->parent_code, function ($q) use ($request) {
                        $q->where('location_code', 'LIKE', '99160000%');
                    })
                    ->orderBy('location_code', 'desc')
                    ->first();

        if ($last) {
            $lastId = (int) substr($last->location_code, -3);
            $nextCount = str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        }

        return $nextCount;
    }

    public function ajaxGetLocation(Request $request) {
        return Location::select()
                ->when($request->location_kh, function ($q) use ($request) {
                    $q->where('location_kh', 'LIKE', $request->location_kh);
                })
                ->when($request->location_code, function ($q) use ($request) {
                    $q->where('location_code', $request->location_code);
                })
                ->first();
    }
}
