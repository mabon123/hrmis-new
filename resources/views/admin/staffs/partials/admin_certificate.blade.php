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
                                <div class="col-sm-4 align-self-start">
                                    <h5 class="profile-ministry">ក្រសួងអប់រំ យុវជន និង កីឡា</h5>
                                    <h6 class="kh" style="padding-left:55px;">
                                        <strong>{{ __('នាយកដ្ឋានរដ្ឋបាល') }}</strong>
                                    </h6>
                                    <p class="kh">លេខៈ ...........</p>
                                </div>
                            </div>

                            <div class="row">
                                <h5 class="text-center profile-ministry">
                                    {{ __('វិញ្ញាបនប័ត្ររដ្ឋបាល') }}
                                </h5>
                                <h6 class="text-center profile-ministry" style="font-size:15px;">
                                    {{ __('ប្រធាននាយកដ្ឋានរដ្ឋបាល') }}
                                </h6>
                                <h6 class="text-center profile-subtitle" style="font-size:15px;">
                                    {{ __('សូមបញ្ជក់ថា៖') }}
                                </h6>
                            </div>

                            <div class="container" style="padding-left:120px;padding-right:50px;">
                                <div class="row profile-item">
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-4 kh"><strong>{{ __('ឈ្មោះ') }}</strong></div>
                                            <div class="col-sm-7">
                                                <span class="profile-ministry">
                                                    {{ $staff->surname_kh.' '.$staff->name_kh }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-5 kh"><strong>{{ __('អក្សរឡាតាំង') }}</strong></div>
                                            <div class="col-sm-7">
                                                <span class="profile-ministry" style="text-transform:uppercase;">
                                                    <strong>{{ $staff->surname_en.' '.$staff->name_en }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-2 kh">
                                        <strong>{{ __('ភេទៈ') }}</strong>
                                        {{ $staff->sex == '1' ? 'ប្រុស' : 'ស្រី' }}
                                    </div>

                                    <div class="col-sm-4 kh">
                                        <strong>{{ __('កើតថ្ងៃទី') }}</strong>
                                        {{ __('២០') }}
                                        <strong>{{ __('ខែ') }}</strong>
                                        {{ __('កុម្ភៈ') }}
                                        <strong>{{ __('ឆ្នាំ') }}</strong>
                                        {{ __('១៩៨៩') }}
                                    </div>

                                    <div class="col-sm-2 kh">
                                        <strong>{{ __('សញ្ជាតិ') }}</strong>
                                        {{ __('ខ្មែរ') }}
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-12 kh">
                                        <strong>{{ __('ទីកន្លែងកំណើតៈ​ ភូមិ') }}</strong>
                                        {{ !empty($staff->addressVillage) ? $staff->addressVillage->name_kh : '' }}

                                        <strong>{{ __('ឃុំ/សង្កាត់') }}</strong>
                                        {{ !empty($staff->addressCommune) ? $staff->addressCommune->name_kh : '' }}

                                        <strong>{{ __('ស្រុក/ខណ្ឌ') }}</strong>
                                        {{ !empty($staff->addressDistrict) ? $staff->addressDistrict->name_kh : '' }}

                                        <strong>{{ __('ខេត្ត/ក្រុង') }}</strong>
                                        {{ !empty($staff->addressProvince) ? $staff->addressProvince->name_kh : '' }}
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-12 kh">
                                        <strong>{{ __('ក្របខណ្ឌៈ') }}</strong>
                                        {{ $position }}
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-12 kh">
                                        <strong>{{ __('ឋានៈ/តួនាទីៈ') }}</strong>
                                        {{ $officialRank }}
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-12 kh">
                                        <strong>{{ __('ប្រភេតកាំប្រាក់ៈ') }}</strong>
                                        {{ $salaryLevel }}
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-12 kh">
                                        <strong>{{ __('បម្រើការងារៈ') }}</strong>
                                        {{ $office.' '.$location.' នៃក្រសួងអប់រំ យុវជន និងកីឡា' }}
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-12 kh">
                                        <strong>{{ __('ប្រាក់បៀរវត្សៈ') }}</strong>
                                        {{ '៨៨០ ០០០ (ប៉ែតសិបប្រាំបីម៉ឺនរៀលគត់)' }}
                                    </div>
                                </div>

                                <div class="row profile-item">
                                    <div class="col-sm-12 kh" style="line-height:32px;">
                                        {{ __('វិញ្ញាបនប័ត្ររដ្ឋបាលនេះ ចេញឲ្យសាមីជនប្រើប្រាស់តាមផ្លូវច្បាប់ ដែលអាចប្រើប្រាស់បាន និងមានសុពលភាពរយៈពេល ០៣ (បី) ខែ ចាប់ពីថ្ងៃចុះហត្ថលេខាតទៅ។') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top:30px;margin-bottom:150px;">
                                <div class="col align-self-start"></div>
                                <div class="col align-self-center"></div>
                                <div class="col-sm-5 align-self-end">
                                    <p class="text-right kh">ថ្ងៃ.....................ខែ........ឆ្នាំ.......សំរិទ្ធិស័ក ព.ស. ២៥.....</p>
                                    <p class="text-right kh">រាជធានីភ្នំពេញុ,ថ្ងៃទី..........ខែ.............ឆ្នាំ...............</p>
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

    <script type="text/javascript"> $(function() { window.print(); }); </script>
</body>

</html>