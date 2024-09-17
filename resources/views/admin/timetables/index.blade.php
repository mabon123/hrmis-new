@extends('layouts.admin')

@push('styles')
    <style type="text/css">
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, 
        .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            border:1px #999 solid !important;
        }
        table th{
            position: sticky;
            top: 50px;
            background: white;
            text-align: center;
            color: black;
            border: 1xp solid #ccc; 
            z-index: 2;            
        }   
        table td{
            background: #fff;
            text-align: center;
            border: 1xp solid #ccc; 
        }    
        td:first-child,
        th:first-child{
            position: sticky; 
            left: 0px;
            border: 1xp solid #ccc;
            z-index: 1;
        }
        td:nth-child(1),
        th:nth-child(1){
            position: sticky;       
            left: 0px;
            z-index: 1;
        }
        th:first-child,
        th:nth-child(1){
            z-index: 1;
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
    <section class="content table-striped table-head-fixed text-nowrap" >
        <!-- Search -->
        @include('admin.timetables.filter')

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h1 class="card-title" style="width:100%;text-align:center;">
                            {{ __('timetables.create_new_timetable') }}</h1>
                    </div>

                    <div >
                        <table class="table table-bordered table-striped text-nowrap">
                            <thead>                                
                                <tr>
                                    <th>{{ __('timetables.day') }}</th>
                                    <th>{{ __('timetables.hour') }}</th>                                    
                                    @foreach ($tgrades as $tgrade)
                                        <th class="kh">
                                            <div class="table-head-fixed text-nowrap">
                                            {{ $tgrade->grade->grade_kh.' '.$tgrade->grade_name }}

                                            <a href="{{ route('timetable.printTimetable', [app()->getLocale(), $tgrade->tgrade_id]) }}" 
                                                class="btn btn-sm btn-primary" title="{{ __('button.print') }}" 
                                                target="_blank">
                                                <i class="fa fa-print"></i> {{ __('button.print') }}
                                            </a>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>                               
                            </thead>

                            <tbody>
                                @if (request()->grade_id != 0)
                                @include('admin.timetables.dropdown')                               
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $("#timetables-section").addClass("menu-open");
            $("#timetable > a").addClass("active");

            // Dropdown Event
            $('.teacher_subject_dropdown').change(function() {
                loadModalOverlay(true, 1000);
                var addURL = $(this).data('add-url');

                $.ajax({
                    type: "POST",
                    url: addURL,
                    data: {
                        academic_id: $(this).data('academic-id'),
                        location_code: $(this).data('location-code'),
                        day_id: $(this).data('day-id'),
                        hour_id: $(this).data('hour-id'),
                        tgrade_id: $(this).data('tgrade-id'),
                        teacher_subject_id: $(this).val(),
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

            // Remove Timetable Event
            $('.btn_remove_timetable').click(function() {
                loadModalOverlay(true, 1000);
                var deleteURL = $(this).data('delete-url');

                $.ajax({
                    type: "DELETE",
                    url: deleteURL,
                    success: function (data) {
                        Swal.fire({
                            icon: 'error',
                            text: "{{ __('validation.delete_success') }}"
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
    </script>
@endpush
