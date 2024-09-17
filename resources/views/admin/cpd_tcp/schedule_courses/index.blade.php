@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.cpd_schedule_course') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.cpd_schedule_course') }}</li>
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
                    <h3 class="card-title">{{ __('menu.cpd_schedule_course') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cpd.course') }}</th>
                                <th>{{ __('cpd.learning_option') }}</th>
                                <th>{{ __('cpd.participant_num') }}</th>
                                <th>{{ __('cpd.registration_start_date') }}</th>
                                <th>{{ __('cpd.registration_end_date') }}</th>
                                <th>{{ __('common.start_date') }}</th>
                                <th>{{ __('common.end_date') }}</th>
                                <th>{{ __('menu.cpd_provider') }}</th>
                                <th>{{ __('cpd.via_mobile_app') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($scheduleCourses as $index => $scheduleCourse)

                            <tr id="record-{{ $scheduleCourse->schedule_course_id }}">
                                <td>{{ $scheduleCourses->firstItem() + $index }}</td>

                                <td class="kh">
                                    <a href="#" target="_blank" title="View detail">
                                        {{ $scheduleCourse->CPDCourse->cpd_course_kh }}
                                    </a>
                                </td>
                                <td class="kh">{{ $scheduleCourse->learningOption->learning_option_kh }}</td>
                                <td>{{ $scheduleCourse->participant_num }}</td>
                                <td>
                                    {{ $scheduleCourse->reg_start_date ? 
                                            date('d-m-Y', strtotime($scheduleCourse->reg_start_date)) : '---' }}
                                </td>
                                <td>
                                    {{ $scheduleCourse->reg_end_date ? 
                                            date('d-m-Y', strtotime($scheduleCourse->reg_end_date)) : '---' }}
                                </td>
                                <td>{{ date('d-m-Y', strtotime($scheduleCourse->start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($scheduleCourse->end_date)) }}</td>
                                <td class="kh">{{ $scheduleCourse->provider->provider_kh }}</td>
                                <td class="text-center">
                                    @if($scheduleCourse->is_mobile == 1)
                                    <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                    @else
                                    <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if (auth()->user()->hasRole('administrator') || (auth()->user()->hasRole('cpd_provider') && $scheduleCourse->is_mobile == 1))
                                    <a href="{{ route('cpd-schedule-courses.edit', [app()->getLocale(), $scheduleCourse->schedule_course_id]) }}" class="btn btn-xs btn-info" title="Edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>
                                    <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $scheduleCourse->schedule_course_id }}" data-route="{{ route('cpd-schedule-courses.destroy', [app()->getLocale(), $scheduleCourse->schedule_course_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    @endif
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $scheduleCourses->links() }}</div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script src="{{ asset('js/delete.handler.js') }}"></script>

<script>
    $(function() {

        $("#schedule-course").addClass("menu-open");
        $("#schedule-course-list > a").addClass("active");

    });
</script>

@endpush