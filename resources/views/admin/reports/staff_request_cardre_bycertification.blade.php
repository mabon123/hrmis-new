@extends('layouts.admin')
@push('styles') 
    <style>
        table{font-family:'Khmer OS Siemreap',Moul;font-size:13px;font-weight:normal;}
        .table thead>tr>th,.table tbody>tr>th,.table tfoot>tr>th,.table{border:1px solid #2980B9 !important; }
        th, td {vertical-align:middle!important;padding:6px!important;}
        td{font-family:'Khmer OS Siemreap',Moul;font-size:12px!important;}
    </style>
@endpush
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-5">
                <h1 style="font-size: 26px !important;">បុគ្គលិកអប់រំស្នើឡើងថ្នាក់តាមសញ្ញាបត្រ </h1>
            </div>
            <div class="col-sm-4">
                <span class="kh" style="font-size: 16px !important; color: #0a7698;"> 
                    @if(!empty($staff_HROContact)) 
                        {{!empty($staff_HROContact->currentPosition()) ?  $staff_HROContact->currentPosition()->position_kh : ''  }}
                        {{$staff_HROContact->surname_kh.' '.$staff_HROContact->name_kh}} 
                        {{!empty($staff_HROContact->phone) ? (' / '.$staff_HROContact->phone) : '' }}   
                    @endif 
                    <br>
                    @if(!empty($staff_contact)) 
                        {{!empty($staff_contact->currentPosition()) ?  $staff_contact->currentPosition()->position_kh : ''  }}
                        {{$staff_contact->surname_kh.' '.$staff_contact->name_kh}} 
                        {{!empty($staff_contact->phone) ? (' / '.$staff_contact->phone) : '' }}   
                    @endif 
                </span>
            </div>
            <div class="col-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">បុគ្គលិកអប់រំស្នើដំឡើងថ្នាក់តាមសញ្ញាបត្រ</li>
                </ol>
            </div>
        </div>
    </div>
</section>

@if(!Auth::user()->hasRole('school-admin', 'dept-admin'))    
    <form method="get" id="frmSearchStaffs" action="{{ route('reports.indexRequestCardreByCertification', app()->getLocale()) }}">
        <div class="row justify-content-md-center" id="divSearch">
            <!-- Province -->
            <div class="col-sm-2">
                <div class="form-group @error('pro_code') has-error @enderror">
                    <label for="pro_code">{{ __('common.province') }} <span class="required">*</span></label>

                    {{ Form::select('pro_code', $provinces, request()->pro_code, 
                        ['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
                    }}
                </div>
            </div>

            <!-- District -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="dis_code">{{ __('common.district') }}</label>

                    {{ Form::select('dis_code', $districts, request()->dis_code, 
                        ['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
                    }}
                </div>
            </div>

            <!-- Current location -->
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="location_code">{{ __('common.current_location') }}</label>

                    {{ Form::select('location_code', $locations, 
                        (!empty($userLocationName) ? $userLocationName : request()->location_code), 
                        ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) 
                    }}
                </div>
            </div>
            
            <div class="col-sm-2">
                <input type="hidden" name="search" value="true">
                <button type="submit" class="btn btn-info" style="width:180px; margin-top: 30px" onclick="loading();">
                    <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                </button>
            </div>
        </div>
    </form>
@endif

<!-- Main content -->
<section class="content">

    @if( (isset($staffs) && count($staffs) > 0))
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center;">#</th>
                                <th rowspan="2" style="text-align: center;">{{ __('common.payroll_num') }}</th>
                                    <th rowspan="2">គោត្តនាម នាម</th>
                                    <th rowspan="2">{{ __('common.sex') }}</th>
                                    <th rowspan="2" style="text-align: center;">ថ្ងៃខែឆ្នាំ<br>កំណើត</th>                            
                                    <th rowspan="2" style="text-align: center;">តួនាទី/ <br> មុខតំណែង</th>
                                    <th rowspan="2" style="text-align: center;">ថ្ងៃខែឆ្នាំ<br/>ចូលបម្រើ<br/>ការងារ</th>
                                    <th rowspan="2" style="text-align: center;">ថ្ងៃខែឆ្នាំ<br/>ដំឡើងថ្នាក់<br/>ចុងក្រោយ</th>
                                    <th rowspan="2" style="text-align: center;">ព្រះរាជក្រឹត្យ<br/>អនុក្រឹត្យ<br/>ប្រកាសលេខ</th>
                                    <th rowspan="2" style="text-align: center;">លេខ<br/>រៀង</th>
                                    <th colspan="2" style="text-align: center;">ដំឡើងថ្នាក់<br/>និងឋានន្តរស័ក្តិ</th>
                                    <th rowspan="2" style="text-align: center;">សញ្ញាបត្រ</th>
                                    <th rowspan="2" style="text-align: center;">អតីត<br>ភាព</th>                                   
                                    <th rowspan="2" style="text-align: center;">អង្គភាពបម្រើការងារ</th>
                                    <th rowspan="2" style="text-align: center;">ស្រុក</th>
                                    <th rowspan="2">
                                        ខេត្ត
                                        <br>
                                        សរុប{{ $staffs->total() }}
                                        /​ ស្រី{{ $femaleStaffs }}
                                    </th>
                                </tr>
                                <tr><th>បច្ចុប្បន្ន</th><th>ស្នើសុំ</th></tr>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($staffs as $index => $staff)
                                <tr>
                                    <td>{{ $staffs->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ route('staffs.show', [app()->getLocale(), $staff->payroll_id]) }}"  target="_blank">{{ $staff->payroll_id }}</a>
                                    </td>
                                    <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                    <td class="kh" style="text-align: center;">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                    <td class="kh" style="text-align: center;">{{ date('d/m/Y', strtotime($staff->dob)) }}</td>
                                    <td class="kh" style="text-align: center;">
                                        @if(!empty($staff->currentPosition())) 
                                            @if(str_contains($staff->currentPosition()->position_kh, 'គ្រូ')) 
                                                បង្រៀន
                                            @elseif(str_contains($staff->currentPosition()->position_kh, 'មន្ត្រី')) 
                                                មន្ត្រី
                                            @else
                                                {{$staff->currentPosition()->position_kh}}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        {{ isset($staff->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->start_date)->format('d/m/Y')) : '' }}
                                    </td>
                                    <td>
                                        {{ isset($staff->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->lastCardreCercleDate->salary_type_shift_date)->format('d-m-Y')) : '' }}
                                    </td>
                                    <td>
                                        {{ !empty($staff->lastCardreSalary->salary_type_prokah_num) ? (($staff->lastCardreSalary->salary_type_prokah_num)) : '' }}
                                    </td>
                                    <td>
                                        {{ !empty($staff->lastCardreSalary->salary_type_prokah_order) ? (($staff->lastCardreSalary->salary_type_prokah_order)) : '' }}
                                    </td>
                                    <td>                                     
                                        @if(($staff->lastCardre->cardre_type_id == 2  && $staff->lastCardre->request_cardre_check_status == 1) && ($staff->requestCardreOffeset1->cardre_type_id == 2 && $staff->requestCardreOffeset1->request_cardre_check_status == 1))   
                                            {{ (!empty($staff->requestCardreOffeset1->salaryLevel) && !empty($staff->requestCardreOffeset1->salary_degree)) ? ($staff->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $staff->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                            {{ (!empty($staff->lastCardreSalary->salaryLevel) && !empty($staff->lastCardreSalary->salary_degree)) ? ($staff->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $staff->lastCardreSalary->salary_degree) : '' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ (!empty($staff->requestCardreCertificate->salaryLevel) && !empty($staff->requestCardreCertificate->salary_degree)) ? ($staff->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $staff->requestCardreCertificate->salary_degree) : '' }}
                                    </td>

                                   
                               
                                    <td>
                                        @if (!empty($staff->requestCardreCertificate->request_qual_id))
                                            @if (File::exists('storage/pdfs/ref_documents/'.'qual_'.$staff->payroll_id.'_'.$staff->requestCardreCertificate->request_qual_id.'.pdf'))
                                                <a href="{{ asset('storage/pdfs/ref_documents/'.'qual_'.$staff->payroll_id.'_'.$staff->requestCardreCertificate->request_qual_id.'.pdf') }}" target="_blank">
                                                    {{ (!empty($staff->highestQualification->qualificationCode->qualification_kh)) ? ($staff->highestQualification->qualificationCode->qualification_kh) : '' }}
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @php $year = (int)date('Y'); $cardreCercle_endDate = \Carbon\Carbon::parse($year.'-04-14'); @endphp
                                        <!-- {{ isset($staff->lastCardreSalary->salary_type_shift_date) ? ((int)date('Y') - (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->lastCardreSalary->salary_type_shift_date)->format('Y'))) : '' }} -->
                                        {{ isset($staff->lastCardreSalary->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->lastCardreCercleDate->salary_type_shift_date)->diffInYears($cardreCercle_endDate)) : '' }}
                                    </td>
                                    <td class="kh">
                                        {{ !empty($staff->currentWorkPlace()) ? 
                                            $staff->currentWorkPlace()->location_kh : 
                                            (!empty($staff->latestWorkPlace()) ? $staff->latestWorkPlace()->location_kh : '') }}
                                    </td>
                                    <td>
                                        {{  !empty($staff->currentWorkPlace()->district->name_kh) ?
                                            $staff->currentWorkPlace()->district->name_kh :
                                            (!empty($staff->latestWorkPlace()->district->name_kh) ? $staff->latestWorkPlace()->district->name_kh : '') }}
                                    </td>
                                    <td>
                                        {{  !empty($staff->currentWorkPlace()->province->name_kh) ?
                                            $staff->currentWorkPlace()->province->name_kh :
                                            (!empty($staff->latestWorkPlace()->province->name_kh) ? $staff->latestWorkPlace()->province->name_kh : '') }}
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-center">
                <div>
                    @if($staffs->hasPages())
                        {!! $staffs->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    @endif
    
</section>

@endsection

@push('scripts')
<script>
        function checkUncheckAll() {
            var selectAllCheckbox = document.getElementById("chk_all");
            if (selectAllCheckbox.checked == true) {
                var inputs = document.querySelectorAll("input.custom-control-input");
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].type == "checkbox") {
                        inputs[i].checked = true;
                    }
                }
            } else {
                var inputs = document.querySelectorAll("input.custom-control-input");
                for (var i = 0; i < inputs.length; i++) {
                    if ( inputs[i].disabled == false) {
                        inputs[i].checked = false;
                    }
                }
            }
        }

        $("#pro_code").change(function() {
            if ($(this).val() > 0) {
                loading();

                $.ajax({
                    type: "GET",
                    url: "/provinces/" + $(this).val() + "/locations",
                    success: function (locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_code").find('option:not(:first)').remove();

                        if ( locationCount > 0 ) {
                            for(var key in locations) {
                                $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
        });

		// District change -> auto-fill data for location belong to that district
        $("#dis_code").change(function() {
        	loadModalOverlay(true, 1000);

            if ($(this).val() > 0) {
                $.ajax({
                    type: "GET",
                    url: "/districts/" + $(this).val() + "/locations",
                    success: function (locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_code").find('option:not(:first)').remove();

                        if ( locationCount > 0 ) {
                            for(var key in locations) {
                                $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
        });
       
    </script>
@endpush