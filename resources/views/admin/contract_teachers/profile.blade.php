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
        .profile-item{font-size:15px;}
        .padding-0{padding-left:0px;padding-right:0px;}
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
                                <h5 class="text-center profile-subtitle">សលាកប័ត្រ​ព័ត៌​មាន​បុគ្គលិកអប់រំ</h5>
                            </div>


                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6 col-xs-6">
                                                    <strong>{{ __('number.num1') }}. {{ __('common.nid') }}</strong>
                                                </div>
                                                <div class="col-sm-6 col-xs-6">: 
                                                    {{ substr($contract_teacher->nid_card, 10, 1) == '_' ? substr($contract_teacher->nid_card, 0, 9) : $contract_teacher->nid_card }}
                                                </div>
                                            </div>

                                            <div class="row profile-item">
                                                <div class="col-sm-6 kh">
                                                    <strong>{{ __('number.num2') }}. នាមត្រកូល និងនាមខ្លួន</strong>
                                                </div>
                                                <div class="col-sm-6 kh">: {{ $contract_teacher->surname_kh.' '.$contract_teacher->name_kh }}</div>
                                            </div>

                                            <!-- Gender -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.sex') }}</span>
                                                </div>
                                                <div class="col-sm-6 kh">: {{ $contract_teacher->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</div>
                                            </div>

                                            <!-- Started date -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <strong>{{ __('number.num3').'. '.__('common.datestart_work') }}</strong>
                                                </div>
                                                <div class="col-sm-6">: {{ $lastWorkHist->start_date > 0 ? date('d-m-Y', strtotime($lastWorkHist->start_date)) : '' }}</div>
                                            </div>

                                            <!-- POB - village -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <strong>{{ __('number.num4') }}. {{ __('ទីកន្លែងកំណើត') }}</strong>
                                                    @lang('common.village')
                                                </div>
                                                <div class="col-sm-6 kh">: {{ $contract_teacher->birth_village }}</div>
                                            </div>

                                            <!-- POB - district -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">@lang('common.district')</span>
                                                </div>
                                                <div class="col-sm-6 kh">: {{ $contract_teacher->birth_district }}</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.bankacc_num') }}</div>
                                                <div class="col-sm-6">: {{ $contract_teacher->bank_account }}</div>
                                            </div>

                                            <!-- Name in LATIN -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6 kh">ជាអក្សរឡាតាំង</div>
                                                <div class="col-sm-6">: {{ $contract_teacher->surname_en.' '.$contract_teacher->name_en }}</div>
                                            </div>

                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.dob') }}</div>
                                                <div class="col-sm-6">: {{ date('d-m-Y', strtotime($contract_teacher->dob)) }}</div>
                                            </div>

                                            <div class="row profile-item" style="margin-bottom:39px;"></div>

                                            <!-- POB - commune -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="kh">@lang('common.commune')</span>
                                                </div>
                                                <div class="col-sm-6 kh">: {{ $contract_teacher->birth_commune }}</div>
                                            </div>

                                            <!-- POB - province -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="kh">@lang('common.province')</span>
                                                </div>
                                                <div class="col-sm-6 kh">: {{ !empty($contract_teacher->birthProvince) ? $contract_teacher->birthProvince->name_kh : '' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Qualification -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row profile-item">
                                                <div class="col-sm-3">
                                                    <strong>{{ __('number.num5') }}. {{ __('common.general_knowledge') }}</strong>
                                                </div>
                                                <div class="col-sm-9 kh">: {{ !empty($contract_teacher->qualificationCode) ? $contract_teacher->qualificationCode->qualification_kh : '' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Work place -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row profile-item">
                                                <div class="col-sm-3">
                                                    <strong>{{ __('number.num6') }}. {{ __('common.current_location') }}</strong>
                                                </div>
                                                <div class="col-sm-9 kh">: {{ ((!empty($lastWorkHist) and !empty($lastWorkHist->location)) ? $lastWorkHist->location->location_kh : '') }}</div>
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
                                                <div class="col-sm-6">: {{ ((!empty($lastWorkHist) and !empty($lastWorkHist->location) and !empty($lastWorkHist->location->village)) ? $lastWorkHist->location->village->name_kh : '') }}</div>
                                            </div>

                                            <!-- WP - district -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.district') }}</span>
                                                </div>
                                                <div class="col-sm-6">: {{ ((!empty($lastWorkHist) and !empty($lastWorkHist->location) and !empty($lastWorkHist->location->district)) ? $lastWorkHist->location->district->name_kh : '') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- WP - commune -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.commune') }}</div>
                                                <div class="col-sm-6">: {{ ((!empty($lastWorkHist) and !empty($lastWorkHist->location) and !empty($lastWorkHist->location->commune)) ? $lastWorkHist->location->commune->name_kh : '') }}</div>
                                            </div>

                                            <!-- WP - province -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.province') }}</div>
                                                <div class="col-sm-6">: {{ ((!empty($lastWorkHist) and !empty($lastWorkHist->location) and !empty($lastWorkHist->location->province)) ? $lastWorkHist->location->province->name_kh : '') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Position -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <strong>{{ __('number.num7') }}. @lang('common.contract_type')</strong>
                                                </div>
                                                <div class="col-sm-6 kh">: {{ !empty($lastWorkHist->contractType) ? $lastWorkHist->contractType->contract_type_kh : '' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6">@lang('common.contract_position')</div>
                                                <div class="col-sm-6 kh">: {{ !empty($lastWorkHist->contractPosition) ? $lastWorkHist->contractPosition->cont_pos_kh : '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Staff profile photo -->
                                <div class="col-sm-2">
                                    <img src="{{ asset('storage/images/cont_staffs/'.$contract_teacher->photo) }}" class="img-thumbnail" alt="Staff Photo" style="width:100%;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <!-- Teaching -->
                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6 kh">
                                                    <strong>{{ __('number.num8').'. '.__('បង្រៀន') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- Teach english -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.teach_english') }}</span>
                                                </div>
                                                <div class="col-sm-6">: 
                                                    @if( !empty($teachingInfo) and $teachingInfo->teach_english )
                                                        <i class="far fa-check-square" style="color:green;font-size:23px;"></i>
                                                    @else
                                                        <i class="far fa-window-close" style="color:red;font-size:20px;"></i>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Bi-languages -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <span class="indent">{{ __('common.bi_language') }}</span>
                                                </div>
                                                <div class="col-sm-6">: 
                                                    @if( !empty($teachingInfo) and $teachingInfo->bi_language )
                                                        <i class="far fa-check-square" style="color:green;font-size:23px;"></i>
                                                    @else
                                                        <i class="far fa-window-close" style="color:red;font-size:20px;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- Double shift -->
                                            <div class="row profile-item">
                                                <div class="col-sm-6">{{ __('common.double_shift') }}</div>
                                                <div class="col-sm-6">: 
                                                    @if( !empty($teachingInfo) and $teachingInfo->double_shift )
                                                        <i class="far fa-check-square" style="color:green;font-size:23px;"></i>
                                                    @else
                                                        <i class="far fa-window-close" style="color:red;font-size:20px;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <!-- Multiple grade -->
                                    <div class="row profile-item">
                                        <div class="col-sm-6">{{ __('common.multi_grade') }}</div>
                                        <div class="col-sm-6">: 
                                            @if( !empty($teachingInfo) and $teachingInfo->multi_grade )
                                                <i class="far fa-check-square" style="color:green;font-size:23px;"></i>
                                            @else
                                                <i class="far fa-window-close" style="color:red;font-size:20px;"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row profile-item">
                                                <div class="col-sm-6">
                                                    <strong>{{ __('number.num9').'. '.__('menu.work_history') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="kh">@lang('common.current_location')</th>
                                                <th class="kh">@lang('common.contract_type')</th>
                                                <th class="kh">@lang('common.contract_position')</th>
                                                <th class="kh">{{ __('ថ្ងៃចាប់ផ្ដើម') }}</th>
                                                <th class="kh">{{ __('ថ្ងៃបញ្ចប់') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach($contract_teacher->workHistories as $workHistory)

                                                <tr>
                                                    <td class="kh">{{ !empty($workHistory->location) ? $workHistory->location->location_kh : '' }}</td>

                                                    <td class="kh">{{ !empty($workHistory->contractType) ? $workHistory->contractType->contract_type_kh : '' }}</td>

                                                    <td class="kh">{{ !empty($workHistory->contractPosition) ? $workHistory->contractPosition->cont_pos_kh : '' }}</td>

                                                    <td>{{ $workHistory->start_date > 0 ? date('d-m-Y', strtotime($workHistory->start_date)) : '' }}</td>

                                                    <td>{{ $workHistory->end_date > 0 ? date('d-m-Y', strtotime($workHistory->end_date)) : '' }}</td>
                                                </tr>

                                                <tr>
                                                    <td style="padding-top:0;"><small><u>{{ __('ការវាយតម្លៃប្រចាំឆ្នាំ') }}</u> : {{ $workHistory->annual_eval }}</small></td>
                                                </tr>

                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="row profile-item">
                                <div class="col-sm-12">
                                    <span style="padding-right:20px;">
                                        <strong>{{ __('number.num10').'. '.__('common.current_address') }}</strong>
                                    </span> : 
                                    {{ 'ផ្ទះលេខ '.$contract_teacher->house_num }}
                                    {{ 'ក្រុមទី '.$contract_teacher->group_num }}
                                    {{ 'ផ្លូវ '.$contract_teacher->street_num }}

                                    {{ 'ភូមិ '.(!empty($contract_teacher->village) ? $contract_teacher->village->name_kh : '') }}

                                    {{ 'ឃុំ/សង្កាត់ '.(!empty($contract_teacher->commune) ? $contract_teacher->commune->name_kh : '') }}

                                    {{ 'ស្រុក/ខណ្ខ/ក្រុង '.(!empty($contract_teacher->district) ? $contract_teacher->district->name_kh : '') }}

                                    {{ 'រាជធានី/ខេត្ត '.(!empty($contract_teacher->province) ? $contract_teacher->province->name_kh : '') }}
                                </div>
                            </div>

                            <!-- Family occupation -->
                            <div class="row profile-item">
                                <div class="col-sm-2">
                                    <span class="indent">{{ __('លេខទូរស័ព្ទ') }}</span>
                                </div>
                                <div class="col-sm-9">: {{ str_replace('_', '', $contract_teacher->phone) }}</div>
                            </div>

                            <div class="row" style="margin-top:30px;margin-bottom:150px;">
                                <div class="col align-self-start"></div>
                                <div class="col align-self-center"></div>
                                <div class="col align-self-end">
                                    <p class="text-right kh">រាជធានីភ្នំពេញុ,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                    <h5 class="profile-ministry text-center kh" style="font-size:14px;">ប្រធានការិយាល័យ</h5>
                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer text-sm text-center d-print-none" style="margin-left:0;">
        Ministry of Education, Youth and Sport | #80, Norodom Blvd. Phnom Penh, Kingdom of Cambodia.
        <strong><a href="#">CPD Management Office</a>.</strong>
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script type="text/javascript"> $(function() { //window.print(); }); </script>
</body>

</html>