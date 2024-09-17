@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.cpd_structured_course') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.cpd_structured_course') }}</li>
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
                    <h3 class="card-title">{{ __('menu.cpd_structured_course') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cpd.course_code') }}</th>
                                <th>{{ __('cpd.course_kh') }}</th>
                                <th>{{ __('cpd.course_en') }}</th>
                                <th>{{ __('cpd.course_type') }}</th>
                                <th>{{ __('cpd.duration') }}</th>
                                <th>{{ __('cpd.credits') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($courses as $index => $course)

                                <tr id="record-{{ $course->cpd_course_id }}">
                                    <td>{{ $courses->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $course->cpd_course_code }}</td>
                                    <td class="kh">{{ $course->cpd_course_kh }}</td>
                                    <td>{{ $course->cpd_course_en }}</td>
                                    <td class="kh">{{ $course->courseType->cpd_course_type_kh }}</td>
                                    <td>{{ $course->duration_hour.' hr' }}</td>
                                    <td>{{ $course->credits }}</td>

                                    <td class="text-center">
                                        @if( $course->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                    	<a href="{{ route('cpd-courses.edit', [app()->getLocale(), $course->cpd_course_id]) }}" class="btn btn-xs btn-info" title="Edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $course->cpd_course_id }}" data-route="{{ route('cpd-courses.destroy', [app()->getLocale(), $course->cpd_course_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $courses->links() }}</div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#structured-course").addClass("menu-open");
            $("#structured-course-list > a").addClass("active");

        });

    </script>

@endpush
