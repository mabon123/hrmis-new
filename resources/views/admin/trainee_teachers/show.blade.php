@extends('layouts.admin')

@push('styles')
    <style>
        .form-group.has-error .select2 .select2-selection {
            border-color: #dc3545;
        }
    </style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.trainee_teacher_info') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>{{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('trainees.index', app()->getLocale()) }}">{{ __('menu.trainee_teacher_info') }}</a>
                    </li>
                    @if (isset($trainee))
                        <li class="breadcrumb-item active">{{ $trainee->{'location_'.app()->getLocale()} }}</li>
                    @endif
                    <li class="breadcrumb-item active">{{ isset($trainee) ? __('button.edit') : __('button.create_new') }}</li>
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

    {!! Form::model($trainee, ['route' => ['trainees.update', [app()->getLocale(), $trainee->trainee_payroll_id]], 'method' => 'PUT', 'id' => 'trainee-teacher-form', 'enctype' => 'multipart/form-data']) !!}

    <div class="card card-info card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-trainee_teacher_info-tab" data-toggle="pill"
                        href="#custom-tabs-trainee_teacher_info" role="tab"
                        aria-controls="custom-tabs-trainee_teacher_info"
                        aria-selected="true">{{ __('menu.trainee_teacher_info') }}</a>
                </li>
            </ul>
        </div>
        <div class="card-body custom-card">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-trainee_teacher_info" role="tabpanel"
                    aria-labelledby="custom-tabs-trainee_teacher_info-tab">
                    @include('admin.trainee_teachers.partials.trainee_teacher_info')
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/location.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

    <script>
        $(function() {
            $("#trainee-teacher").addClass("menu-open");
            $("#create-trainee-teacher > a").addClass("active");

            $('[data-mask]').inputmask();
            $('input').prop('disabled', true)
            $('select').prop('disabled', true)
        });
    </script>

@endpush
