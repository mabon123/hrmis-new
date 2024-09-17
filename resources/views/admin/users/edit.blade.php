@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fa fa-user"></i> {{ __('menu.manage_user') }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                                {{ __('menu.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index', app()->getLocale()) }}"> {{ __('menu.manage_user') }} </a></li>
                        <li class="breadcrumb-item active">{{ __('login.edit_user') }}</li>
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

        <form method="post" id="frmUpdateUser" action="{{ route('users.update', [app()->getLocale(), $user->id]) }}">
            @csrf
            @method('PUT')

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('login.edit_user') }}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Username -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="username">
                                    {{ __('login.username') }}
                                    <span class="required">*</span>
                                </label>

                                <input type="text" name="username" value="{{ $user->username }}" class="form-control">
                            </div>
                        </div>

                        <!-- Payroll ID -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="payroll_id">
                                    {{ __('common.payroll_num') }}
                                    <span class="required">*</span>
                                </label>

                                <input type="number" name="payroll_id" value="{{ $user->payroll_id }}" maxlength="10" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="level_id">
                                    {{ __('login.level') }}
                                    <span class="required">*</span>
                                </label>

                                <select name="level_id" class="form-control kh select2">
                                    <option value="">{{ __('common.choose') }} ...</option>

                                    @foreach($levels as $key => $level)
                                        <option value="{{ $key }}" {{ $user->level_id == $key ? 'selected' : '' }}>
                                            {{ $level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- User roles -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="role_id">
                                    {{ __('login.role') }}
                                    <span class="required">*</span>
                                </label>

                                <select name="role_id" class="form-control kh select2">
                                    <option value="">{{ __('common.choose') }} ...</option>
                                    
                                    @foreach($roles as $key => $role)
                                        <option value="{{ $key }}" {{ $user->roles[0]->role_id == $key ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Registration Type -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="reg_type">{{ __('login.registered_by') }}</label>
                                @php
                                    $regtypes = ['1' => 'HRMIS User', '2' => 'Mobile User', '3' => 'CPD Website User'];
                                @endphp
                                {{ Form::select('reg_type', $regtypes, $user->reg_type, ['class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Active -->
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="active" name="active" value="1" {{ $user->active == 1 ? 'checked' : '' }}>
                                    <label for="active">{{__('login.active')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User role permission -->
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="table table-hover table-bordered table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('login.module_name') }}</th>
                                    <th class="text-center">{{ __('login.read') }}</th>
                                    <th class="text-center">{{ __('login.create') }}</th>
                                    <th class="text-center">{{ __('login.update') }}</th>
                                    <th class="text-center">{{ __('login.delete') }}</th>
                                </tr>
                            </thead>

                            <?php

                            $permission_items = [
                                ['ពត៌មានបុគ្គលិក', 'staffs', 1, 1, 1, 1],
                                ['ព័ត៌មានគ្រូបង្រៀនកិច្ចសន្យា', 'cont-staffs', 1, 1, 1, 1],
                                ['ព័ត៌មានអង្គភាព', 'schools', 1, 1, 1, 1],
                                ['ព័ត៌មានគរុសិស្ស-និស្សិត', 'trainee-teacher', 1, 1, 1, 1],
                                ['បញ្ជីគ្រូចេញថ្មី', 'trainee-teacher-list', 1, 0, 1, 0],
                                ['អ្នកផ្តល់សេវា អវប (CPD)', 'cpd-provider', 1, 1, 1, 1],
                                ['Scheduled CPD Offerings', 'cpd-schedule-course', 1, 1, 1, 1],
                                ['CPD Offerings', 'cpd-structured-course', 1, 1, 1, 1],
                                ['គ្រប់គ្រងការចុះឈ្មោះអ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ', 'manage-user-registration', 1, 0, 0, 0],
                                ['គ្រប់គ្រង Multi-Criteria Search', 'manage-multi-criteria-search', 1, 0, 0, 0],
                                ['មើលរបាយការណ៍ & តារាងទិន្នន័យ', 'report-and-chart', 1, 0, 0, 0],
                                ['គ្រប់គ្រង ម៉ូឌុលគន្លងអាជីព', 'tcp-appraisal', 1, 1, 1, 1],
                                ['ត្រួតពិនិត្យការស្នើសុំគន្លងអាជីព', 'tcp-appraisal-requests', 1, 0, 0, 0],
                                ['គ្រប់គ្រងកាលវិភាគ', 'manage-timetables', 1, 0, 0, 0],
                                ['គ្រប់គ្រងរបាយការណ៍លើលខ្វះគ្រូ', 'manage-staff-allocation', 1, 0, 0, 0],
                            ];

                            ?>

                            <tbody>

                                @foreach($permission_items as $index => $permissions)

                                    <?php
                                        $view = 'view-'.$permissions[1];
                                        $create = 'create-'.$permissions[1];
                                        $update = 'edit-'.$permissions[1];
                                        $delete = 'delete-'.$permissions[1];
                                    ?>

                                    <tr>
                                        <td>{{ $permissions[0] }}</td>

                                        <td class="text-center">
                                            @if ($permissions[2] == 1)
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" name="{{ $view }}" id="{{ $view }}" value="1" {{ $user->roles[0]->can($view) ? 'checked disabled' : ($user->can($view) ? 'checked' : '') }}>
                                                    <label for="{{ $view }}"></label>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($permissions[3] == 1)
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" name="{{ $create }}" id="{{ $create }}" value="1" {{ $user->roles[0]->can($create) ? 'checked disabled' : ($user->can($create) ? 'checked' : '') }}>
                                                    <label for="{{ $create }}"></label>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($permissions[4] == 1)
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" name="{{ $update }}" id="{{ $update }}" value="1" {{ $user->roles[0]->can($update) ? 'checked disabled' : ($user->can($update) ? 'checked' : '') }}>
                                                    <label for="{{ $update }}"></label>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($permissions[5] == 1)
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" name="{{ $delete }}" id="{{ $delete }}" value="1" {{ $user->roles[0]->can($delete) ? 'checked disabled' : ($user->can($delete) ? 'checked' : '') }}>
                                                    <label for="{{ $delete }}"></label>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('users.index', app()->getLocale()) }}" class="btn btn-danger" 
                        onclick="loadModalOverlay(true, 500)" style="width:150px;">
                        <i class="far fa-times-circle"></i>&nbsp;{{ __('button.cancel') }}
                    </a>
                    
                    <button type="submit" class="btn btn-info" style="width:150px;">
                        <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
                    </button>
                </div>
            </div>
        </form>
    </section>

@endsection

@push('scripts')

    <script>
        
        $(function() {

            $("#user").addClass("menu-open");
            $("#manage-user > a").addClass("active");

            // Validation
            $("#frmCreateUser").validate({
                rules: {
                    username: "required",
                    password: "required",
                    payroll_id: "required",
                    level_id: "required",
                    role_id: "required",
                },
                messages: {
                    username: "{{ __('validation.required_field') }}",
                    password: "{{ __('validation.required_field') }}",
                    payroll_id: "{{ __('validation.required_field') }}",
                    level_id: "{{ __('validation.required_field') }}",
                    role_id: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    loadModalOverlay(true, 1000);
                    frm.submit();
                },
                invalidHandler: function(event, validator) {
                    var errors = validator.numberOfInvalids();
                    
                    if (errors) {
                        toastMessage("bg-danger", "{{ __('validation.error_message') }}");
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#frmUpdateUser').submit(function() {
                loadModalOverlay(true, 1000);
            });

        });

    </script>

@endpush
