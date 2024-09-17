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
                <h1 style="font-size: 24px !important;"> បុគ្គលិកអប់រំស្នើឡើងថ្នាក់តាមវេនឆ្នាំ{{$y}} </h1>
            </div>
            <div class="col-sm-4 mt-n2">
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
            <div class="col-sm-3">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">បុគ្គលិកអប់រំស្នើដំឡើងថ្នាក់តាមវេន</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">

<div class="row">

    <div class="col-md-12">
        @include('admin.validations.validate')
    </div>
    </div>

    @if(!Auth::user()->hasRole('school-admin', 'dept-admin'))    
        <form method="get" id="frmSearchStaffs" action="{{ route('reports.indexRequestCardreByCercle', app()->getLocale()) }}">
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

    @if( (isset($staffs) && count($staffs) > 0))
        {{ Form::model($staffs,
            ['route' => ['reports.verifyCardreByCercle', [app()->getLocale()]],
            'method' => 'PUT',
            'id' => 'frmVerifyStaffs'])
        }}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center;">
                                        <!-- <div class="custom-control custom-checkbox d-none">
                                            <input class="custom-control-input" type="checkbox" onclick="checkUncheckAll()" id="chk_all" value="all">
                                            <label for="chk_all" class="custom-control-label"></label>
                                        </div> -->
                                        <span style="font-size: 13px !important; color: #0a7698;">{{ $staffs->total() }} / </span>
                                        <span class="kh count" style="font-size: 13px !important; color: #0a7698;">{{$requestCardreStaffs}}</span>
                                    </th>
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
                            </thead>

                            <tbody>
                                @foreach($staffs as $index => $staff)
                                    <tr>
                                        <td style="text-align: center;">
                                            <div class="custom-control custom-checkbox">            
                                                @if(Auth::user()->hasRole('poe-admin') || Auth::user()->payroll_id == 1851200246)  
                                                    <input type="hidden" name="payroll_numbers[]" value="{{ $staff->payroll_id }}" />                                    
                                                    <input class="custom-control-input" type="checkbox" id="{{ 'chk_'.$staff->payroll_id}}" name="payroll_id_checked[{{ $staff->payroll_id }}]" value="1" {{ isset($staff->requestCardreCircle->payroll_id) ? 'checked' : '' }} >
                                                @else
                                                    @if(isset($staff->requestCardreCircle->payroll_id))
                                                        <input type="hidden" name="payroll_numbers[]" value="{{ $staff->payroll_id }}" />
                                                        <input class="custom-control-input" type="checkbox" id="{{ 'chk_'.$staff->payroll_id}}" name="payroll_id_checked[{{ $staff->payroll_id }}]" value="1" checked>
                                                    @else
                                                        <input type="hidden" name="payroll_numbers[]" value="{{ $staff->payroll_id }}" />
                                                        <input class="custom-control-input" type="checkbox" id="{{ 'chk_'.$staff->payroll_id}}" name="payroll_id_checked[{{ $staff->payroll_id }}]" value="1">
                                                    @endif                                                   
                                                 @endif
                                                    <label for="{{ 'chk_'.$staff->payroll_id}}" class="custom-control-label"></label>
                                                    {{ $staffs->firstItem() + $index }}    
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('staffs.show', [app()->getLocale(), $staff->payroll_id]) }}" target="_blank">{{ $staff->payroll_id }}</a>
                                        </td>
                                        <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                        <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                        <td class="kh" style="text-align: center;">{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
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
                                            {{ isset($staff->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->start_date)->format('d/m/Y')) : '' }}</td>
                                        <td>
                                            {{ isset($staff->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}
                                        </td>
                                        <td class="kh" style="text-align: center;">
                                            {{ !empty($staff->lastCardreSalary->salary_type_prokah_num) ? (($staff->lastCardreSalary->salary_type_prokah_num)) : '' }}                                                                     
                                        </td>
                                        <td class="kh" style="text-align: center;">
                                            {{ !empty($staff->lastCardreSalary->salary_type_prokah_order) ? (($staff->lastCardreSalary->salary_type_prokah_order)) : '' }}
                                        </td>


                                        <td class="kh" style="text-align: center;">
                                            @if(($staff->lastCardre->cardre_type_id == 1 && $staff->lastCardre->request_cardre_check_status == 1) && ($staff->requestCardreOffeset1->cardre_type_id == 2 && $staff->requestCardreOffeset1->request_cardre_check_status == 1))               
                                                {{ (!empty($staff->requestCardreOffeset1->salaryLevel) && !empty($staff->requestCardreOffeset1->salary_degree)) ? ($staff->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $staff->requestCardreOffeset1->salary_degree) : '' }}
                                            @else
                                                {{ (!empty($staff->lastCardre->salaryLevel) && !empty($staff->lastCardre->salary_degree)) ? ($staff->lastCardre->salaryLevel->salary_level_kh .'.'. $staff->lastCardre->salary_degree) : '' }}
                                            @endif
                                        </td>
                                        <td class="kh" style="text-align: center;">
                                            {{ (!empty($staff->requestCardreCircle->salaryLevel) || !empty($staff->requestCardreCircle->salary_degree)) ? ($staff->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $staff->requestCardreCircle->salary_degree) : '' }}
                                        </td>
                                        <td>
                                            {{ (!empty($staff->highestQualification->qualificationCode->qualification_kh)) ? ($staff->highestQualification->qualificationCode->qualification_kh) : '' }}
                                        </td>
                                        <td class="kh" style="text-align: center;">
                                            @php $year = (int)date('Y')+1; $cardreCercle_endDate = \Carbon\Carbon::parse($year.'-04-14'); @endphp <!-- 2024-08-01 -->
                                            <!-- {{ isset($staff->lastCardreCercleDate->salary_type_shift_date) ? ((int)date('Y') - (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->lastCardreCercleDate->salary_type_shift_date)->format('Y'))) : '' }} -->
                                            {{ isset($staff->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $staff->lastCardreCercleDate->salary_type_shift_date)->diffInYears($cardreCercle_endDate)) : '' }}
                                        </td>
                                        
                                        <td class="kh">
                                            {{ !empty($staff->currentWorkPlace()) ? 
                                                str_replace(' ', '', $staff->currentWorkPlace()->location_kh) : 
                                                (!empty($staff->latestWorkPlace()) ? str_replace(' ', '', $staff->latestWorkPlace()->location_kh) : '') }}
                                        </td>
                                        <td>
                                            {{  !empty($staff->currentWorkPlace()->district->name_kh) ? $staff->currentWorkPlace()->district->name_kh : '' }}
                                        </td>
                                        <td>
                                            {{  !empty($staff->currentWorkPlace()->province->name_kh) ? $staff->currentWorkPlace()->province->name_kh : '' }}
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


            <div class="row">
                <div class="col-md-12">
                    <table style="margin:auto;">
                        <tr>
                            <td style="padding:5px">
                                @if(Auth::user()->hasRole('school-admin', 'dept-admin') || Auth::user()->work_place->location_code == request()->location_code || Auth::user()->hasRole('poe-admin') || Auth::user()->hasRole('central-admin') || Auth::user()->payroll_id == 1851200246)
                                    <button type="button" class="btn btn-info btn-​confirm" id="btn-​confirm">
                                        <i class="far fa-save"></i> {{ __('button.conf_verification') }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        {{ Form::close() }}
    @endif
</section>

@endsection

@push('scripts') 
    <script>
        
        // document.querySelectorAll("input.custom-control-input").forEach((e) => {
        //     e.addEventListener('click', () => {
        //         let count = document.querySelector('.count');
        //         e.checked ? (count.innerHTML = parseInt(count.innerHTML) + 1) : (count.innerHTML = parseInt(count.innerHTML) - 1)                     
        //     })   
        // })   
   
        <?php if(Illuminate\Support\Facades\Auth::user()->hasRole('school-admin') || Illuminate\Support\Facades\Auth::user()->hasRole('doe-admin') || Illuminate\Support\Facades\Auth::user()->hasRole('dept-admin')) { ?>
           document.querySelectorAll("input.custom-control-input[type=checkbox]:checked").forEach((e) => {
                e.addEventListener('click', () => {
                Swal.fire({
                    title: "ទំនាក់ទំនង",
                    text: "អ្នកគ្រប់គ្រងប្រព័ន្ធ HRMIS មន្ទីរអប់រំ រាជធានី-ខេត្ត",
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonColor: '#3085d6',
                    reverseButtons: true,
                })    
                    e.checked = true;        
                    return false;
                })
            })  

        <?php } ?>
        
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

        $('form').submit(function(e) {
            $(':disabled').each(function(e) {
                $(this).removeAttr('disabled');
            })          
        });

        $(document).on('click', '[id^=btn-​confirm]', function (e) {
                let $form = $(this).closest('form');
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })

            Swal.fire({
                title: "តើអ្នកប្រាកដទេ?",
                text: "ទិន្នន័យនេះនឹងត្រូវស្នើដំឡើងថ្នាក់តាមវេន",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "យល់ព្រម",
                cancelButtonText: 'បោះបង់',
                reverseButtons: true,
                allowOutsideClick: () => !Swal.isLoading(),
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    $form.submit();
                    return new Promise(function(resolve, reject) {
                        setTimeout(function(){
                            resolve()
                        }, 2000)
                    })
                },
            }).then((result) => {});
        });
           
         
    </script>
@endpush