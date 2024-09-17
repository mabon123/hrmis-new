<?php

namespace App\Http\Controllers;

use DB;
use Image;
use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Village;
use App\Models\Location;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\ProfessionalType;
use App\Models\Staff;
use App\Models\StaffStatus;
use App\Models\StaffFamily;
use App\Models\WorkHistory;
use App\Models\TraineeTeacher;
use App\Models\TraineeFamily;
use App\Models\TraineeStatus;
use App\Models\MaritalStatus;
use App\Models\RelationshipType;
use App\Models\LocationType;
use App\Models\StaffProfessional;
use App\Http\Requests\TraineeRequest;

class TraineeTeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:view-trainee-teacher', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-trainee-teacher', ['only' => ['create', 'store']]);
    	$this->middleware('permission:edit-trainee-teacher', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-trainee-teacher', ['only' => ['destroy']]);
    }

    public function index()
    {
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $statuses = TraineeStatus::pluck('trainee_status_kh', 'trainee_status_id')->all();
        $filters = [
            '' => __('common.choose'),
            'trainee_payroll_id' => __('common.payroll_num'),
            'surname_kh' => __('common.surname_kh'),
            'name_kh' => __('common.name_kh'),
            'surname_en' => __('common.surname_latin'),
            'name_en' => __('common.name_latin'),
            'fullnamekh' => __('គោត្តនាម នាម (ខ្មែរ)'),
            'fullnameen' => __('គោត្តនាម នាម (ឡាតាំង)'),
        ];
        $locations = $this->getTrainingInstitutions();
        $professionalTypes = ProfessionalType::active()->pluck('prof_type_kh', 'prof_type_id')->all();

        $query = TraineeTeacher::select()
                                ->with(['status', 'subject1'])
                                ->when((auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc) || auth()->user()->hasRole('school-admin'), function($q) {
                                    $q->where('location_code', auth()->user()->work_place->location_code);
                                })
                                ->when(request()->location_code, function($query) {
                                    $location = Location::where('location_code', request()->location_code)->first();
                                    if ($location) {
                                        $query->where('location_code', $location->location_code);
                                    }
                                })
                                ->when(request()->prof_type_id, function ($query) {
                                    $query->where('prof_type_id', request()->prof_type_id);
                                })
                                ->when(request()->trainee_status_id, function ($query) {
                                    $query->where('trainee_status_id', request()->trainee_status_id);
                                })
                                ->when(request()->stu_generation, function($query) {
                                    $query->where('stu_generation', request()->get('stu_generation'));
                                })
                                ->when(request()->filter_by && request()->keyword, function($query) {
                                    $filterBy = request()->filter_by;
                                    switch (request()->filter_by) {
                                        case 'fullnamekh':
                                            $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
                                            break;
                                        case 'fullnameen':
                                            $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
                                            break;
                                    }
                                    $query->where($filterBy, request()->keyword);
                                });
        $trainees = (clone $query)
                            ->when(!request()->trainee_status_id || request()->trainee_status_id === '', function ($q) {
                                $q->whereIn('trainee_status_id', [TraineeStatus::Trainee, TraineeStatus::Postpone]);
                            })
                            ->paginate(10);

        $failTrainees = (clone $query)
                            ->when(!request()->trainee_status_id || request()->trainee_status_id === '', function ($q) {
                                $q->whereIn('trainee_status_id', [TraineeStatus::Trainee, TraineeStatus::Postpone]);
                            })
                            ->when(request()->trainee_status_id, function ($q) {
                                $q->where('trainee_status_id', request()->trainee_status_id);
                            })
                            ->whereResult(false)
                            ->get();
        return view('admin.trainee_teachers.index', [
            'trainees' => $trainees,
            'failTrainees' => $failTrainees,
            'provinces' => $provinces,
            'statuses' => $statuses,
            'filters' => $filters,
            'locations' => $locations,
            'professionalTypes' => $professionalTypes,
        ]);
    }

    public function show(TraineeTeacher $trainee) {
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $districts = District::active()->whereProCode($trainee->adr_pro_code)->pluck('name_kh', 'dis_code')->all();
        $communes = Commune::whereDisCode($trainee->adr_dis_code)->pluck('name_kh', 'com_code')->all();
        $villages = Village::whereComCode($trainee->adr_com_code)->pluck('name_kh', 'vil_code')->all();

        $subjects = Subject::pluck('subject_kh', 'subject_id')->all();
        $futureLocation = Location::select()->whereLocationCode($trainee->future_location_code)->first();
        $futureLocations = Location::select()->whereProCode($futureLocation->pro_code)->get()->pluck('location_province', 'location_code')->all();
        $trainingInstitutions = $this->getTrainingInstitutions();
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();
        $maritalStatuses = MaritalStatus::pluck('maritalstatus_kh', 'maritalstatus_id')->all();
        $traineeStatuses = TraineeStatus::pluck('trainee_status_kh', 'trainee_status_id')->all();
        $professionalTypes = ProfessionalType::active()->pluck('prof_type_kh', 'prof_type_id')->all();

        $generations = $this->getAcademicGenerations($trainee->year_id, $trainee->prof_type_id);
        $currentGeneration = count(array_values($generations)) ? array_values($generations)[0] : null;
        return view('admin.trainee_teachers.show', [
            'headerid' => $trainee->trainee_payroll_id,
            'trainee' => $trainee,
            'provinces' => $provinces,
            'districts' => $districts,
            'communes' => $communes,
            'villages' => $villages,
            'subjects' => $subjects,
            'futureLocation' => $futureLocation,
            'futureLocations' => $futureLocations,
            'trainingInstitutions' => $trainingInstitutions,
            'traineeStatuses' => $traineeStatuses,
            'maritalStatuses' => $maritalStatuses,
            'professionalTypes' => $professionalTypes,
            'academicYears' => $academicYears,
            'generations' => $generations,
            'currentGeneration' => $currentGeneration,
        ]);
    }

    public function create()
    {
        $provinces = Province::active()
                            ->pluck('name_kh', 'pro_code')
                            ->all();
        $birthDistricts = District::active()->pluck('name_kh');

        $subjects = Subject::pluck('subject_kh', 'subject_id')->all();
        $trainingInstitutions = $this->getTrainingInstitutions();
        $maritalStatuses = MaritalStatus::pluck('maritalstatus_kh', 'maritalstatus_id')->all();
        $traineeStatuses = TraineeStatus::where('trainee_status_id', TraineeStatus::Trainee)->pluck('trainee_status_kh', 'trainee_status_id')->all();
    	$relationshipTypes = RelationshipType::whereNotIn('relation_type_id', [3])->pluck('relation_type_kh', 'relation_type_id')->all();
        $professionalTypes = ProfessionalType::active()->pluck('prof_type_kh', 'prof_type_id')->all();

        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();
       // $selectedYear = AcademicYear::where('year_en', 'LIKE', (Carbon::now()->format('Y')).'%')->first();
        $selectedYear = AcademicYear::where('cur_year', '=','1')->first();
        $latestYear = TraineeTeacher::orderBy('year_id', 'desc')
            ->when((auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc) || auth()->user()->hasRole('school-admin'), function ($q) {
                $q->where('location_code', auth()->user()->work_place->location_code);
            })
            ->first();
        if ($latestYear && (int)$latestYear->year_id > (int)$selectedYear->year_id) {
            $selectedYear = $latestYear->year_id;
        } else {
            $selectedYear = $selectedYear ? $selectedYear->year_id : null;
        }

        return view('admin.trainee_teachers.add-edit', [
            'provinces' => $provinces,
            'birthDistricts' => $birthDistricts,
            'subjects' => $subjects,
            'trainingInstitutions' => $trainingInstitutions,
            'traineeStatuses' => $traineeStatuses,
            'maritalStatuses' => $maritalStatuses,
            'relationshipTypes' => $relationshipTypes,
            'professionalTypes' => $professionalTypes,
            'academicYears' => $academicYears,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function store(TraineeRequest $request)
    {
        try {
            $id = $this->createOrUpdate($request->except('_method', '_token'));
            return redirect()->route('trainees.edit', [app()->getLocale(), $id])->withSuccess(__('trainee.success.created'));
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function edit(TraineeTeacher $trainee = null)
    {
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $districts = District::active()->whereProCode($trainee->adr_pro_code)->pluck('name_kh', 'dis_code')->all();
        $communes = Commune::whereDisCode($trainee->adr_dis_code)->pluck('name_kh', 'com_code')->all();
        $villages = Village::whereComCode($trainee->adr_com_code)->pluck('name_kh', 'vil_code')->all();
        $birthDistricts = District::active()->pluck('name_kh');

        $subjects = Subject::pluck('subject_kh', 'subject_id')->all();
        $futureLocation = Location::select()->whereLocationCode($trainee->future_location_code)->first();
        $futureLocations = Location::select()->whereProCode($futureLocation->pro_code)->get()->pluck('location_province', 'location_code')->all();
        $trainingInstitutions = $this->getTrainingInstitutions();
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();
        $maritalStatuses = MaritalStatus::pluck('maritalstatus_kh', 'maritalstatus_id')->all();
        $traineeStatuses = TraineeStatus::pluck('trainee_status_kh', 'trainee_status_id')->all();
    	$relationshipTypes = RelationshipType::whereNotIn('relation_type_id', [3])->pluck('relation_type_kh', 'relation_type_id')->all();
        $professionalTypes = ProfessionalType::active()->pluck('prof_type_kh', 'prof_type_id')->all();

        $generations = $this->getAcademicGenerations($trainee->year_id, $trainee->prof_type_id);
        $currentGeneration = count(array_values($generations)) ? array_values($generations)[0] : null;

        return view('admin.trainee_teachers.add-edit', [
            'headerid' => $trainee->trainee_payroll_id,
            'trainee' => $trainee,
            'provinces' => $provinces,
            'districts' => $districts,
            'communes' => $communes,
            'villages' => $villages,
            'birthDistricts' => $birthDistricts,
            'subjects' => $subjects,
            'futureLocation' => $futureLocation,
            'futureLocations' => $futureLocations,
            'trainingInstitutions' => $trainingInstitutions,
            'traineeStatuses' => $traineeStatuses,
            'maritalStatuses' => $maritalStatuses,
            'relationshipTypes' => $relationshipTypes,
            'professionalTypes' => $professionalTypes,
            'academicYears' => $academicYears,
            'generations' => $generations,
            'currentGeneration' => $currentGeneration,
        ]);
    }

    public function update(TraineeRequest $request, TraineeTeacher $trainee)
    {
        try {
            $id = $this->createOrUpdate($request->except('_method', '_token'), $trainee);
            return redirect()->route('trainees.edit', [app()->getLocale(), $id])->withSuccess(__('trainee.success.updated'));
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function destroy(TraineeTeacher $trainee)
    {
        try {
            $trainee->delete();
            return redirect()->back()->withSuccess(__('trainees.success.deleted'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function createOrUpdate($data, TraineeTeacher $trainee = null) {
        $id = $data['trainee_payroll_id'];
        if ($trainee) {
            $data['updated_by'] = auth()->id();
        } else {
            $trainee = new TraineeTeacher;
            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();
        }

        // Upload profile photo
        if( request()->hasFile('profile_photo') ) {
            $imageUpload = request()->file('profile_photo');
            $fileName = request()->trainee_payroll_id.'.'.$imageUpload->getClientOriginalExtension();

            $profileImage = Image::make($imageUpload)->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            Storage::disk('public')->put('images/trainees/'.$fileName, $profileImage);

            $data['photo'] = $fileName;
        }

        $data = array_merge($data, [
            'surname_en' => strtoupper($data['surname_en']),
            'name_en' => strtoupper($data['name_en']),
            'dob' => date('Y-m-d', strtotime($data['dob'])),
            'start_date' => isset($data['start_date']) ? date('Y-m-d', strtotime($data['start_date'])) : null,
            'end_date' => isset($data['end_date']) ? date('Y-m-d', strtotime($data['end_date'])) : null,
        ]);
        $trainee->fill($data);
        if ($trainee->save()) {
            $married = (int) $data['maritalstatus_id'] === 2;
            $familyData = [
                'trainee_payroll_id'    => $id,
                'relation_type_id'      => $married && isset($data['sex']) ? ($data['sex'] === 1 ? 2 : 1) : null,
                'gender'                => $married && isset($data['sex']) ? ($data['sex'] === 1 ? 2 : 1) : null,
                'fullname_kh'           => $married && isset($data['fullname_kh']) ? $data['fullname_kh'] : null,
                'dob'                   => $married && isset($data['spouse_dob']) ? date('Y-m-d', strtotime($data['spouse_dob'])) : null,
                'phone'                 => $married && isset($data['spouse_phone']) ? $data['spouse_phone'] : null,
                'is_alive'              => $married && in_array($data['maritalstatus_id'], [MaritalStatus::Single, MaritalStatus::Married]) ? true : false,
                'occupation'            => $married && isset($data['occupation']) ? $data['occupation'] : null,
                'spouse_workplace'      => $married && isset($data['spouse_workplace']) ? $data['spouse_workplace'] : null,
                'created_by'            => $trainee->created_by,
                'updated_by'            => $trainee->updated_by,
            ];
            TraineeFamily::updateOrCreate(['trainee_payroll_id' => $familyData['trainee_payroll_id']], $familyData);

            // Update staff status to trainee teacher if former_staff
            if (isset($data['former_staff']) && $data['former_staff']) {
                $staff = Staff::find($id);
                if ($staff) {
                    $staff->update(['staff_status_id' => 14]);
                }
            }
        }

        return $id;
    }

    public function transfer(Request $request) {
        try {
            $trainees = TraineeTeacher::select()
                                ->with(['spouse', 'futureLocation'])
                                ->whereIn('trainee_status_id', [TraineeStatus::Trainee, TraineeStatus::Postpone])
                                ->when(request()->pro_code, function($query) {
                                    $query->where('adr_pro_code', request()->pro_code);
                                })
                                ->when(request()->location_code, function($query) {
                                    $location = Location::where('location_code', request()->location_code)->first();
                                    $query->where('location_code', $location->location_code);
                                })
                                ->when(request()->prof_type_id, function($query) {
                                    $query->where('prof_type_id', request()->prof_type_id);
                                })
                                ->when(request()->stu_generation, function($query) {
                                    $query->where('stu_generation', request()->stu_generation);
                                })
                                ->when((auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc) || auth()->user()->hasRole('school-admin'), function ($q) {
                                    $q->where('location_code', auth()->user()->work_place->location_code);
                                })
                                ->when(request()->filter_by && request()->keyword, function($query) {
                                    $filterBy = request()->filter_by;
                                    switch (request()->filter_by) {
                                        case 'fullnamekh':
                                            $filterBy = DB::raw('CONCAT(surname_kh, " ", name_kh)');
                                            break;
                                        case 'fullnameen':
                                            $filterBy = DB::raw('CONCAT(surname_en, " ", name_en)');
                                            break;
                                    }
                                    $query->where($filterBy, request()->keyword);
                                })
                                ->get();

            foreach($trainees as $trainee) {
                if ($trainee->result) {
                    $data = $trainee->toArray();

                    $staff = Staff::wherePayrollId($trainee->trainee_payroll_id)->first();
                    if ($staff) {
                        $staff->update(['is_newly_transferred' => true]);
                    } else {
                        $staffData = array_merge($data, [
                            'payroll_id' => $trainee->trainee_payroll_id,
                            'staff_status_id' => StaffStatus::Trainee,
                            'dtmt_school' => 0,
                            'is_newly_transferred' => true
                        ]);
                        $staff = Staff::create($staffData);
                    }

                    if ($staff) {

                        // Photo
                        if ($trainee->photo && Storage::disk('public')->exists('images/trainees/'.$trainee->photo)) {
                            if ($staff->photo && Storage::disk('public')->exists('images/staffs/'.$staff->photo)) {
                                Storage::disk('public')->delete('images/staffs/'.$staff->photo);
                                Storage::disk('public')->copy('images/trainees/'.$trainee->photo, 'images/staffs/'.$trainee->photo);
                            }
                        }

                        // Spouse
                        if ($trainee->spouse) {
                            $spouseData = [
                                'payroll_id' => $trainee->trainee_payroll_id,
                                'relation_type_id' => $trainee->spouse->relation_type_id,
                                'fullname_kh' => $trainee->spouse->fullname_kh,
                                'fullname_en' => $trainee->spouse->fullname_en,
                                'dob' => $trainee->spouse->dob,
                                'gender' => $trainee->spouse->gender,
                                'occupation' => $trainee->spouse->occupation,
                                'spouse_workplace' => $trainee->spouse->spouse_workplace,
                                'phone_number' => $trainee->spouse->phone,
                                'allowance' => 1,
                                'created_by' => auth()->id(),
                                'updated_by' => auth()->id(),
                            ];
                            if ($staff->spouse) {
                                $staff->spouse()->update($spouseData);
                            } else {
                                StaffFamily::create($spouseData);
                            }
                        }

                        $workDescription = '';
                        $workPositionId = 0;
                        $profCategoryId = 0;
                        switch ($trainee->prof_type_id) {
                            case ProfessionalType::NIE:
                            case ProfessionalType::NIE2:
                            case ProfessionalType::TowardBA:
                                $workDescription = 'គ្រូមធ្យមសិក្សាទុតិយភូមិ';
                                $workPositionId = 36;
                                $profCategoryId = 11;
                                break;

                            case ProfessionalType::RTTC12_4:
                            case ProfessionalType::RTTC12_2:
                            case ProfessionalType::PTTC_RTTC:
                                $workDescription = 'គ្រូមធ្យមសិក្សាបឋមភូមិ';
                                $workPositionId = 40;
                                $profCategoryId = 12;
                                break;

                            case ProfessionalType::PTTC12_4:
                            case ProfessionalType::PTTC12_2:
                                $workDescription = 'គ្រូបឋមសិក្សា';
                                $workPositionId = 43;
                                $profCategoryId = 13;
                                break;

                            case ProfessionalType::CentralKindergarten:
                                $workDescription = 'គ្រូមត្តេយសិក្សា';
                                $workPositionId = 44;
                                $profCategoryId = 14;
                                break;
                        }

                        // Work History
                        if ($trainee->futureLocation) {
                            $workData = [
                                'his_type_id' => 1,
                                'cur_pos' => 1,
                                'status_id' => 1,
                                'position_id' => $workPositionId,
                                'start_date' => Carbon::parse(Carbon::now()->year . '-10-01')->format('Y-m-d'),
                                'location_code' => $trainee->future_location_code,
                                'pro_code' => substr($trainee->future_location_code, 0, 2),
                                'payroll_id' => $trainee->trainee_payroll_id,
                                'description' => $workDescription,
                                'created_by' => auth()->id(),
                                'updated_by' => auth()->id(),
                            ];

                            $currentWork = $staff->workHistories()->where('cur_pos', 1)->first();
                            if ($currentWork && !$currentWork->end_date) {
                                $currentWork->update([
                                    'cur_pos' => 0,
                                    'end_date' => Carbon::parse(Carbon::now()->year . '-10-01')->format('Y-m-d'),
                                ]);
                            }
                            WorkHistory::create($workData);
                        }

                        // Training System
                        if ($trainee->profession) {
                            $professionData = [
                                'pro_code' => substr($trainee->location_code, 0, 2),
                                'location_code' => $trainee->location_code,
                                'payroll_id' => $trainee->trainee_payroll_id,
                                'prof_category_id' => $profCategoryId,
                                'prof_date' => Carbon::now()->format('Y-m-d'),
                                'subject_id1' => $trainee->subject_id1,
                                'subject_id2' => $trainee->subject_id2,
                                'prof_type_id' => $trainee->prof_type_id,
                                'created_by' => auth()->id(),
                                'updated_by' => auth()->id(),
                            ];
                            StaffProfessional::create($professionData);
                        }
                    }

                    $trainee->update([
                        'trainee_status_id' => TraineeStatus::Completed
                    ]);
                } else {
                    // $academicYear = AcademicYear::findOrFail($trainee->year_id);
                    // $nextYear = (int)explode('-', $academicYear->year_en)[0] + 1;
                    // $nextAcademicYear = AcademicYear::where('year_en', 'LIKE', $nextYear.'%')->first();
                    $trainee->update([
                        'result' => $trainee->trainee_status_id === TraineeStatus::Trainee ? 1 : 0,
                        'stu_generation' => (int)$trainee->stu_generation + 1,
                        'year_id' => (int)$trainee->year_id + 1, //$nextAcademicYear ? $nextAcademicYear->year_id : null,
                        'end_date' => Carbon::parse($trainee->end_date)->addYear()->format('Y-m-d')
                    ]);
                }
            }
            return redirect()->route('trainees.index', [app()->getLocale()])->withSuccess(__('trainee.success.transferred'));
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors($th->getMessage());
        }

    }

    public function ajaxGetAcademicGenerations(Request $request) {
        return $this->getAcademicGenerations($request->year_id, $request->prof_type_id, $request->all);
    }

    public function ajaxGetFutureLocations(Request $request)
    {
        return Location::select()->with('province')
            ->when($request->pro_code, function ($q) use ($request) {
                $q->where('pro_code', $request->pro_code);
            })
            ->get()
            ->map(function($location) {
                return [
                    'location_code' => $location->location_code,
                    'location_province' => $location->location_province,
                ];
            });
    }

    private function getAcademicGenerations($academicYear = null, $profType = null, $all = false) {
        $curGen = TraineeTeacher::orderBy('stu_generation', 'desc')
                                    ->when($academicYear, function ($q) use ($academicYear) {
                                        $q->where('year_id', $academicYear);
                                    })
                                    ->when($profType, function ($q) use ($profType) {
                                        $q->where('prof_type_id', $profType);
                                    })
                                    ->when((auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc) || auth()->user()->hasRole('school-admin'), function($q) {
                                        $q->where('location_code', auth()->user()->work_place->location_code);
                                    });
        if ($all) {
            return $curGen->pluck('stu_generation', 'stu_generation')->all();
        }

        $curGen = $curGen->pluck('stu_generation')->first();
        if ($curGen) {
            return [(string)$curGen => $curGen];
        }

        $lastGen = TraineeTeacher::orderBy('stu_generation', 'desc')
                                ->when((auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc) || auth()->user()->hasRole('school-admin'), function($q) {
                                    $q->where('location_code', auth()->user()->work_place->location_code);
                                })
                                ->when($profType, function ($q) use ($profType) {
                                    $q->where('prof_type_id', $profType);
                                })
                                ->pluck('stu_generation')
                                ->first();

        if ($lastGen) {
            $nextGen = $lastGen + 1;
            return [(string)$nextGen => $nextGen];
        }
        return ['1' => 1];
    }

    private function getTrainingInstitutions($autocomplete = false)
    {
        $locations = Location::select()
                    ->whereIn('location_type_id', [LocationType::Institute, LocationType::RTTC, LocationType::PTTC, LocationType::PreTTC])
                    ->when((auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc) || auth()->user()->hasRole('school-admin'), function($q) {
                        $q->where('location_code', auth()->user()->work_place->location_code);
                    });
        return $autocomplete ? $locations->pluck('location_kh') : $locations->pluck('location_kh', 'location_code')->all();
    }
}
