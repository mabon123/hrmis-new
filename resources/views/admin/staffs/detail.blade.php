<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('menu.hrmis_long') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
   
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Moulpali&family=Siemreap&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style>
        .profile-title{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:20px;margin-bottom:15px;}
        .profile-ministry{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:16px;margin-bottom:15px;}
        .profile-subtitle{font-family:'Khmer OS Muol Light', Moul !important;width:100%;font-size:16px;margin-bottom:25px;}
        span.indent{font-size:16px;padding-left:22px;}
        span.indent-2{font-size:16px;padding-left:35px;}
        .profile-item{margin-bottom:15px;}
        .padding-0{padding-left:0px;padding-right:0px;}
        .table.table-head-fixed thead tr:nth-child(1) th {box-shadow:none;}
    </style>
</head>

<body class="lang-{{ config('app.locale') }}">
    <div class="container" style="max-width:1030px;">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="text-center profile-title">ព្រះរាជាណាចក្រកម្ពុជា</h5>
                                <h5 class="text-center profile-title">ជាតិ សាសនា ព្រះមហាក្សត្រ</h5>
                            </div>

                            <div class="row">
                                <h5 class="profile-ministry">ក្រសួងអប់រំ យុវជន និង កីឡា</h5>
                            </div>

                            <div class="row">
                                <h5 class="text-center profile-subtitle">សលាកប័ត្រព័ត៌មានបុគ្គលិកអប់រំ</h5>
                            </div>


                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6 col-xs-6">
                                                    <strong>{{ __('number.num1') }}. {{ __('common.payroll_num') }}</strong>
                                                </div>
                                                <div class="col-sm-6 col-xs-6">: {{ $staff->payroll_id }}</div>
                                            </div>

                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.bankacc_num') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ $staff->bank_account }}</div>
                                            </div>

                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">នាមត្រកូល និងនាមខ្លួន</span>
                                                </div>
                                                <div class="col-sm-6">: {{ $staff->surname_kh.' '.$staff->name_kh }}</div>
                                            </div>

                                            <!-- Gender -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.sex') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</div>
                                            </div>

                                            <!-- Ethnic -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('ជនជាតិ') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ !empty($staff->ethnic) ? $staff->ethnic->ethnic_kh : '' }}</div>
                                            </div>

                                            <!-- Place of birth - village -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <strong>{{ __('number.num2') }}. ទីកន្លែងកំណើត</strong> 
                                                    {{ __('common.village') }}
                                                </div>
                                                <div class="col-sm-6">: {{ $staff->birth_village }}</div>
                                            </div>

                                            <!-- POB - district -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.district') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ $staff->birth_district }}</div>
                                            </div>

                                            <!-- Started date -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <strong>{{ __('number.num3').'. '.__('common.datestart_work') }}</strong>
                                                </div>
                                                <div class="col-sm-6">: {{ $staff->start_date > 0 ? date('d-m-Y', strtotime($staff->start_date)) : '' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- National ID card -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.nid') }}</div>
                                                <div class="col-sm-6">: {{ substr($staff->nid_card, 10, 1) == '_' ? substr($staff->nid_card, 0, 9) : $staff->nid_card }}</div>
                                            </div>

                                            <div class="row profile-item">
                                                <div class="col-sm-6">លេខសមាជិកសបសខ</div>
                                                <div class="col-sm-6">: {{ $staff->sbsk_num }}</div>
                                            </div>

                                            <div class="row profile-item">
                                                <div class="col-sm-6">ជាអក្សរឡាតាំង</div>
                                                <div class="col-sm-6">: {{ $staff->surname_en.' '.$staff->name_en }}</div>
                                            </div>

                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.dob') }}</div>
                                                <div class="col-sm-6">: {{ date('d-m-Y', strtotime($staff->dob)) }}</div>
                                            </div>

                                            <!-- Disability -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('ពិការ') }}</div>
                                                <div class="col-sm-6">: 
                                                    @if( $staff->disability_teacher == 1 )
                                                        <i class="far fa-check-square" style="font-size:20px;"></i>
                                                        <?php /* ?><i class="far fa-window-close" style="color:red;font-size:20px;"></i><?php */ ?>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Place of birth - commune -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.commune') }}</div>
                                                <div class="col-sm-6">: {{ $staff->birth_commune }}</div>
                                            </div>

                                            <!-- POB - province -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.province') }}</div>
                                                <div class="col-sm-6">: {{ !empty($staff->birthProvince) ? $staff->birthProvince->name_kh : '' }}</div>
                                            </div>

                                            <!-- Appointed date -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.appointment_date') }}</div>
                                                <div class="col-sm-6">: {{ $staff->appointment_date > 0 ? date('d-m-Y', strtotime($staff->appointment_date)) : '' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Work place -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row profile-item">
                                                <div class="col-sm-3">
                                                    <span class="indent">{{ __('អង្គភាពបម្រើការងារ') }}</span>
                                                </div>
                                                <div class="col-sm-9">: {{ !empty($cur_WorkHistory->location) ? $cur_WorkHistory->location->location_kh : '' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- WP - village -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.village') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ !empty($cur_WorkHistory->location->village) ? $cur_WorkHistory->location->village->name_kh : '' }}</div>
                                            </div>

                                            <!-- WP - district -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.district') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ !empty($cur_WorkHistory->location->district) ? $cur_WorkHistory->location->district->name_kh : '' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- WP - commune -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.commune') }}</div>
                                                <div class="col-sm-6">: {{ !empty($cur_WorkHistory->location->commune) ? $cur_WorkHistory->location->commune->name_kh : '' }}</div>
                                            </div>

                                            <!-- WP - province -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.province') }}</div>
                                                <div class="col-sm-6">: {{ !empty($cur_WorkHistory->location->province) ? $cur_WorkHistory->location->province->name_kh : '' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Office -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row profile-item">
                                                <div class="col-sm-3">
                                                    <span class="indent">{{ __('common.office') }}</span>
                                                </div>
                                                <div class="col-sm-9">: {{ !empty($cur_WorkHistory->office) ? $cur_WorkHistory->office->office_kh : '' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Position -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.position') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ !empty($cur_WorkHistory->position) ? $cur_WorkHistory->position->position_kh : '' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('ប្រកាស') }}</div>
                                                <div class="col-sm-6">: 
                                                    @if (!empty($cur_WorkHistory) and $cur_WorkHistory->prokah == 1)
                                                        <i class="far fa-check-square" style="font-size:20px;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Staff profile photo -->
                                <div class="col-sm-2">
                                    <img src="{{ asset('storage/images/staffs/'.$staff->photo) }}" class="img-thumbnail" alt="Staff Photo" style="width:100%;">
                                </div>
                            </div>

                            <!-- TCP profession detail -->
                            <div>@include('admin.staffs.details.tcp_profession')</div>
                            <div>@include('admin.staffs.details.salary')</div>

                            <div>@include('admin.staffs.details.teaching')</div>

                            <div>@include('admin.staffs.details.workhistory')</div>

                            <div>@include('admin.staffs.details.admiration')</div>

                            <!-- Qualification -->
                            <div>@include('admin.staffs.details.qualification')</div>

                            <!-- Profession -->
                            <div>@include('admin.staffs.details.profession')</div>

                            <!-- Short Course -->
                            <div>@include('admin.staffs.details.shortcourse')</div>

                            <!-- Family Information -->
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <strong>{{ __('number.num13').'. '.__('family_info.family_status') }}</strong>
                                                </div>
                                                <div class="col-sm-6">: {{ !empty($staff->maritalStatus) ? $staff->maritalStatus->maritalstatus_kh : '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <!-- Family relationship type -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent-2">{{ __('ត្រូវជា') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ !empty($spouse) ? $spouse->relationshipType->relation_type_kh : '' }}</div>
                                            </div>

                                            <!-- Family occupation -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent-2">{{ __('family_info.spouse_occupation') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ !empty($spouse) ? $spouse->occupation : '' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <!-- Spouse name -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('family_info.spouse_name') }}</div>
                                                <div class="col-sm-6">: {{ !empty($spouse) ? $spouse->fullname_kh : '' }}</div>
                                            </div>

                                            <!-- Spouse work place -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('family_info.spouse_unit') }}</div>
                                                <div class="col-sm-6">: {{ !empty($spouse) ? $spouse->spouse_workplace : '' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <!-- Spouse date of birth -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6 padding-0">{{ __('family_info.spouse_dob') }}</div>
                                                <div class="col-sm-6">: {{ (!empty($spouse) and $spouse->dob > 0) ? date('d-m-Y', strtotime($spouse->dob)) : '' }}</div>
                                            </div>

                                            <!-- Spouse amount -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6 padding-0">{{ __('family_info.spouse_amount') }}</div>
                                                <div class="col-sm-6">: 
                                                    @if( !empty($spouse) )
                                                        @if( $spouse->allowance == 1 )
                                                            <i class="far fa-check-square" style="font-size:20px;"></i>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Children Listing-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>{{__('family_info.child_name')}}</th>
                                                <th>{{__('common.sex')}}</th>
                                                <th>{{__('common.dob')}}</th>
                                                <th>{{__('common.occupation')}}</th>
                                                <th class="text-center">{{__('family_info.amount')}}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($childrens as $children)
                                                <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                                                    <td>{{ $children->fullname_kh }}</td>
                                                    <td>{{ $children->gender == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                                    <td>{{ $children->dob > 0 ? date('d-m-Y', strtotime($children->dob)) : '' }}</td>
                                                    <td>{{ $children->occupation }}</td>
                                                    <td class="text-center">
                                                        @if($children->allowance == 1)
                                                            <i class="far fa-check-square" style="font-size:16px;"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Current address -->
                                            <div class="row profile-item">
                                                <div class="col-sm-3">
                                                    <strong>{{ __('number.num14').'. '.__('common.current_address') }}</strong>
                                                </div>
                                                <div class="col-sm-9">: 
                                                    {{ 'ផ្ទះលេខ '.$staff->house_num }}
                                                    {{ 'ក្រុមទី '.$staff->group_num }}
                                                    {{ 'ផ្លូវ '.$staff->street_num }}

                                                    {{ 'ភូមិ '.(!empty($staff->addressVillage) ? $staff->addressVillage->name_kh : '') }}

                                                    {{ 'ឃុំ/សង្កាត់ '.(!empty($staff->addressCommune) ? $staff->addressCommune->name_kh : '') }}

                                                    {{ 'ស្រុក/ខណ្ខ/ក្រុង '.(!empty($staff->addressDistrict) ? $staff->addressDistrict->name_kh : '') }}

                                                    {{ 'រាជធានី/ខេត្ត '.(!empty($staff->addressProvince) ? $staff->addressProvince->name_kh : '') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- Family occupation -->
                                            <div class="row profile-item">
                                                <div class="col-sm-4">
                                                    <span class="indent-2">{{ __('common.telephone') }}</span>
                                                </div>
                                                <div class="col-sm-8">: {{ str_replace('_', '', $staff->phone) }}</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- Spouse name -->
                                            <div class="row profile-item">
                                                <div class="col-sm-3">{{ __('common.email') }}</div>
                                                <div class="col-sm-9">: {{ $staff->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top:30px;margin-bottom:150px; ">
                                <div class="col align-self-start" style="margin-top: 60px;">
                                    <p class="text-right">ថ្ងៃ....................ខែ.............ឆ្នាំ...............ព.ស ២៥.......</p>
                                    <p class="text-right">...........................,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                    <h5 class="profile-ministry text-center" style="font-size:14px;">ប្រធានអង្គភាព</h5>
                                </div>
                                <div class="col align-self-center" ></div>
                                <div class="col align-self-end"style="margin-bottom: 60px;">
                                    <p class="text-right">ថ្ងៃ....................ខែ.............ឆ្នាំ...............ព.ស ២៥.......</p>
                                    <p class="text-right">...........................,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                    <h5 class="profile-ministry text-center" style="font-size:14px;">សាមីខ្លួន</h5>
                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="main-footer text-sm text-center d-print-none" style="margin-left:0;">
        Ministry of Education, Youth and Sport | #80, Norodom Blvd. Phnom Penh, Kingdom of Cambodia.
        <strong><a href="#">CPD Management Office</a>.</strong>
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript"> $(function() { //window.print(); }); </script>
</body>

</html>
