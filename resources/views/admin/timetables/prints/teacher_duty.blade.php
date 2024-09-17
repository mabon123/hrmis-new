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
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, 
        .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td { border:1px #000000 solid !important; }
    </style>

    <style type="text/css" media="print"></style>
</head>

<body class="lang-{{ config('app.locale') }}">
    <div class="container" style="max-width:1530px;">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row row-box">
                                <h5 class="text-center profile-title">{{ __('ព្រះរាជាណាចក្រកម្ពុជា') }}</h5>
                                <h5 class="text-center profile-title">{{ __('ជាតិ សាសនា ព្រះមហាក្សត្រ') }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="profile-ministry" style="margin-bottom:8px;">
                                    {{ __('រដ្ឋបាលស្រុក') }} 
                                    {{ !empty($userWorkplace->district) ? $userWorkplace->district->name_kh : '' }}</h5>
                                <h5 class="profile-ministry" style="margin-bottom:8px;">{{ __('ការិយាល័យអប់រំយុវជន និងកីឡា') }}</h5>
                                <h5 class="profile-ministry">{{ !empty($userWorkplace) ? $userWorkplace->location_kh : '' }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="text-center profile-subtitle" style="margin-bottom:8px;">{{ __('បំណែងចែកភារកិច្ចមន្រ្តីរាជការ') }}</h5>
                                <h5 class="text-center profile-subtitle" style="margin-bottom:8px;">
                                    {{ __('ប្រចាំឆ្នាំសិក្សា ') . $academicYear->year_kh }}</h5>
                                <p class="text-center" style="font-size:16px;width:100%;">
                                    {{ __('មន្រ្តីរាជការនៃ') }} 
                                    {{ (!empty($userWorkplace) ? $userWorkplace->location_kh : '') }}
                                    {{ __('មានរាយនាមខាងក្រោមត្រូវបានចាត់តាំងឲ្យទទួលភារកិច្ចដូចតទៅ៖') }}
                                </p>
                            </div>

                            @php $durations = ['១០ នាទី', '៣០ នាទី']; @endphp

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                                        <thead >
                                            <tr>
                                                <th class="text-center">{{ __('ល.រ') }}</th>
                                                <th class="text-center">{{ __('គោត្តនាម-នាម') }}</th>
                                                <th class="text-center">{{ __('ក្របខ័ណ្ឌជំនាញ') }}</th>
                                                <th class="text-center">{{ __('មុខងារ-ភារកិច្ច') }}</th>
                                                <th class="text-center">{{ __('សេចក្តីផ្សេងៗ') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($staffs as $t_index => $staff)
                                                <tr>
                                                    <td class="text-center">{{ $t_index + 1 }}</td>
                                                    <td class="text-left">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                                    <td class="text-left">
                                                        @php $profCategories = ['', '']; @endphp

                                                        @if (!empty($staff->highestPrefession[0]) && !empty($staff->highestPrefession[0]->professionalCategory))
                                                            @php
                                                                $profCategories = explode('.', $staff->highestPrefession[0]->professionalCategory->prof_category_kh);
                                                            @endphp
                                                        @endif

                                                        {{ $profCategories[1] }}

                                                    </td>
                                                    <td class="text-left">
                                                        @if (!empty($teacherPrimaries[$t_index]))
                                                            {{ $staff->position_kh.$teacherPrimaries[$t_index]->grade_kh }}
                                                            
                                                        @else
                                                            {{ $staff->position_kh }}
                                                        @endif
                                                    </td>
                                                    <td class="text-left">{{ __('') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p style="font-size:12px;width:100%;">{{ __('មន្រ្តីរាជការទាំងអស់ ត្រូវបំពេញភារកិច្ចរៀងៗខ្លួនចាប់ពីពេលនេះតទៅ។') }}</p>
                                </div>
                            </div>

                            <div class="row" style="margin-top:30px;">
                                <div class="col align-self-start" style="margin-top:60px;">
                                    <p class="text-center">បានឃើញ និង ឯកភាព</p>
                                    <h5 class="profile-ministry text-center" style="font-size:12px;">ប្រធានការិយាល័យអប់រំ យុវជន និងកីឡាស្រុក</h5>
                                </div>
                                <div class="col align-self-center"></div>
                                <div class="col align-self-end" style="margin-bottom:60px;">
                                    <p class="text-right" style="font-size:12px">ថ្ងៃ....................ខែ.............ឆ្នាំ...............ព.ស ២៥.......</p>
                                    <p class="text-right">..................,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
                                    <h5 class="profile-ministry text-center" style="font-size:12px;">នាយក/នាយិកា</h5>
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
