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
        .profile-title {
            font-family: 'Khmer OS Muol Light', Moul !important;
            width: 100%;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .profile-ministry {
            font-family: 'Khmer OS Muol Light', Moul !important;
            width: 100%;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .profile-subtitle {
            font-family: 'Khmer OS Muol Light', Moul !important;
            width: 100%;
            font-size: 16px;
            margin-bottom: 25px;
        }

        span.indent {
            font-size: 16px;
            padding-left: 22px;
        }

        span.indent-2 {
            font-size: 16px;
            padding-left: 35px;
        }

        .profile-item {
            margin-bottom: 15px;
        }

        .padding-0 {
            padding-left: 0px;
            padding-right: 0px;
        }

        .table.table-head-fixed thead tr:nth-child(1) th {
            box-shadow: none;
        }

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            border: 1px #999 solid !important;
        }
    </style>

    <style type="text/css" media="print">
        /*span.sept { padding-left: 10px; padding-right: 10px; }*/
        @page {
            size: landscape;
        }

        @media print {
            td.bg-green {
                background: #28a745 !important;
                color: #fff !important;
            }

            td.bg-red {
                background: #e36464 !important;
                color: #fff !important;
            }
        }
    </style>
</head>

<body class="lang-{{ config('app.locale') }}">
    <div class="container" style="width:100%;max-width:100%;">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="text-center profile-title" style="margin-bottom:8px;">{{ __('ព្រះរាជាណាចក្រកម្ពុជា') }}</h5>
                                <h5 class="text-center profile-title">{{ __('ជាតិ សាសនា ព្រះមហាក្សត្រ') }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="profile-ministry" style="margin-bottom:8px;">{{ $userWorkplace->location_kh }}</h5>
                            </div>

                            <div class="row">
                                <h5 class="text-center profile-subtitle" style="margin-bottom:8px;">
                                    បញ្ជីរាយនាមបុគ្គលិកអប់រំដែលសុំច្បាប់រយៈពេលខ្លី
                                </h5>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ល.រ</th>
                                                <th>{{ __('common.payroll_num') }}</th>
                                                <th>{{ __('common.name') }}</th>
                                                <th>{{ __('common.sex') }}</th>
                                                <th>{{ __('common.dob') }}</th>
                                                <th>{{ __('common.position') }}</th>
                                                <th>{{ __('ចំនួនថ្ងៃសុំច្បាប់') }}</th>
                                                <th>{{ __('common.start_date') }}</th>
                                                <th>{{ __('common.end_date') }}</th>
                                                <th>{{ __('មូលហេតុ') }}</th>
                                                <th>{{ __('common.location') }}</th>
                                                <th>{{ __('ផ្សេងៗ') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($staffs as $index => $staff)
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ $staff->payroll_id }}</td>
                                                <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                                <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                                <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                                <td class="kh">
                                                    {{ $staff->is_cont_staff == 1 ? $staff->contractPosition()->contract_type_kh : $staff->currentPosition()->position_kh }}
                                                </td>
                                                <td>{{ $staff->days }}</td>
                                                <td>{{ date('d-m-Y', strtotime($staff->start_date)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($staff->end_date)) }}</td>
                                                <td class="kh">{{ $staff->description }}</td>
                                                <td class="kh">{{ !empty($staff->currentWorkPlace()) ? $staff->currentWorkPlace()->location_kh : (!empty($staff->latestWorkPlace()) ? $staff->latestWorkPlace()->location_kh : '---') }}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top:0px;">
                                <div class="col align-self-start" style="margin-top:60px;"></div>
                                <div class="col align-self-center"></div>
                                <div class="col align-self-end" style="margin-bottom:0px;">
                                    <p class="text-right">ថ្ងៃ.................ខែ.............ឆ្នាំ..............ព.ស ២៥.......</p>
                                    <p class="text-right">...........................,ថ្ងៃទី..........ខែ.............ឆ្នាំ ២០.......</p>
                                    <h5 class="profile-ministry text-right" style="font-size:14px;padding-right:140px;">{{ __('ប្រធានអង្គភាព') }}</h5>
                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            window.print();
        });
    </script>
</body>

</html>