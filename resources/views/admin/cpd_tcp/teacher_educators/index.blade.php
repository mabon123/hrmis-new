@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.cpd_teacher_educator') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.cpd_teacher_educator') }}</li>
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

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('menu.cpd_teacher_educator') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.payroll_num') }}</th>
                                <th>{{ __('common.name') }}</th>
                                <th>{{ __('common.sex') }}</th>
                                <th>{{ __('common.telephone') }}</th>
                                <th>{{ __('cpd.position_to_teps') }}</th>
                                <th>{{ __('cpd.courses_certified') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($teacherEducators as $index => $teacherEducator)

                                <tr id="record-{{ $teacherEducator->teacher_educator_id }}">
                                    <td>{{ $teacherEducators->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $teacherEducator->payroll_id }}</td>

                                    <td class="kh">{{ $teacherEducator->staffInfo->surname_kh .' '. 
                                    	$teacherEducator->staffInfo->name_kh }}</td>

                                    <td class="kh">{{ $teacherEducator->staffInfo->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                    <td>{{ $teacherEducator->staffInfo->phone }}</td>

                                    <td>{{ !empty($teacherEducator->tempPosition) ? 
                                    	$teacherEducator->tempPosition->teps_position_kh : '---' }}</td>

                                    <td>
                                    	@foreach ($teacherEducator->teacherEDUCourses as $teacherEDUCourse)
                                    		<span class="badge bg-primary" style="padding:10px;">
                                    			{{ $teacherEDUCourse->CPDCourse->cpd_course_kh }}
                                    		</span>
                                    	@endforeach
                                    </td>

                                    <td class="text-right">
                                    	<a href="{{ route('cpd-teacher-educators.edit', [app()->getLocale(), $teacherEducator->teacher_educator_id]) }}" class="btn btn-xs btn-info" title="Edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $teacherEducator->teacher_educator_id }}" data-route="{{ route('cpd-teacher-educators.destroy', [app()->getLocale(), $teacherEducator->teacher_educator_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $teacherEducators->links() }}</div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#teacher-educator").addClass("menu-open");
            $("#educator-list > a").addClass("active");

        });

    </script>

@endpush
