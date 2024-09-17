@extends('layouts.admin')

@push('styles')
    <style type="text/css">
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, 
        .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            border:1px #999 solid !important;
        }
    </style>
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-user"></i> {{ __('menu.manage_timetables') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('index', app()->getLocale()) }}">
                                <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#"> {{ __('menu.manage_timetables') }} </a></li>
                        <li class="breadcrumb-item active">{{ __('timetables.create_new_timetable') }}</li>
                    </ol>

                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Search -->
        @include('admin.timetables.primary.filter')

        <!-- Morning -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h1 class="card-title" style="width:100%;text-align:center;">
                            {{ __('កាលវិភាគប្រចាំសប្តាហ៍') }} <br>
                            {{ __('timetables.grade_1_to_3') }}
                            {{ __('ឆ្នាំសិក្សា') . $curAcademicYear->year_kh }}
                            {{ __('(វេនព្រឹក)') }}
                        </h1>

                        <a href="{{ route('timetable.printPrimaryTimetable', [app()->getLocale(), '13']) }}" 
                            class="btn btn-md btn-primary float-right" title="{{ __('button.print') }}" 
                            target="_blank" style="width:180px;">
                            <i class="fa fa-print"></i> {{ __('button.print') }}
                        </a>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('timetables.hour') }}</th>

                                    @foreach ($tdays as $d_index => $day)
                                    	@if ($day->day_id < 7)
                                    		<th class="text-center kh" style="width:14%;">{{ $day->day_kh }}</th>
                                    	@endif
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @include('admin.timetables.primary.primary_dropdown')
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <!-- Afternoon -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h1 class="card-title" style="width:100%;text-align:center;">
                            {{ __('កាលវិភាគប្រចាំសប្តាហ៍') }} <br>
                            {{ __('timetables.grade_1_to_3') }}
                            {{ __('ឆ្នាំសិក្សា') . $curAcademicYear->year_kh }}
                            {{ __('(វេនរសៀល)') }}
                        </h1>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('timetables.hour') }}</th>

                                    @foreach ($tdays as $d_index => $day)
                                    	@if ($day->day_id < 7)
                                    		<th class="text-center" style="width:14%;">{{ $day->day_kh }}</th>
                                    	@endif
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @include('admin.timetables.primary.primary_dropdown_afternoon')
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $("#timetables-section").addClass("menu-open");
            $("#timetable_primary_1 > a").addClass("active");

            // Dropdown Event
            $('.teacher_subject_dropdown').change(function() {
                loadModalOverlay(true, 1000);
                var addURL = $(this).data('add-url');

                $.ajax({
                    type: "POST",
                    url: addURL,
                    data: {
                        academic_id: $(this).data('academic-id'),
                        day_id: $(this).data('day-id'),
                        hour_id: $(this).data('hour-id'),
                        shift: $(this).data('shift'),
                        subject_id: $(this).val(),
                    },
                    success: function (timetable) {
                        if (timetable == 'duplicated') {
                            Swal.fire({
                                icon: 'error',
                                text: "{{ __('timetables.duplicated') }}"
                            }).then(function() {
                                location.reload();
                            });
                        }
                        else {
                            // Toast
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                autohide: true,
                                delay: 3000,
                                title: 'Success',
                                body: "{{ __('validation.add_success') }}",
                            });
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
    </script>
@endpush
