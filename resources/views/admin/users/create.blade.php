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
                    <li class="breadcrumb-item"><a href="#"> {{ __('menu.manage_user') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('login.create_user') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">

            @if ($errors->any())

                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif

            @if (session()->has('success'))
            <div class="alert alert-success">
                @if(is_array(session()->get('success')))
                <ul>
                    @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @else
                {{ session()->get('success') }}
                @endif
                <button class="close" data-dismiss="alert" type="button">×</button>
            </div>
            @endif
        </div>
    </div>

    <form method="post" id="frmCreateUser" action="{{ route('users.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('login.create_user') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-6 col-md-offset-3 col-sm-12">
                        <div class="form-group">
                            <label for="username"> {{__('login.username')}} <span
                                    style="color:#f00">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" 
                                class="form-control @error('username') is-invalid @enderror">
                        </div>

                        <div class="form-group">
                            <label for="password">{{__('login.password')}} <span
                                    style="color:#f00">*</span></label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="payroll_id">{{__('common.payroll_num')}} <span style="color:#f00">*</span></label>
                            <input type="number" name="payroll_id" value="{{ old('payroll_id') }}" maxlength="20" 
                                class="form-control @error('payroll_id') is-invalid @enderror">
                        </div>

                        <div class="form-group">
                            <label for="level_id">{{__('login.level')}} <span style="color:#f00">*</span></label>

                            {{ Form::select('level_id', ['' => __('common.choose').' ...'] + $levels, old('level_id'), 
                                ['id' => 'role_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
                        </div>

                        <!-- User roles -->
                        <div class="form-group">
                            <label for="role_id">{{__('login.role')}}<span style="color:#f00">*</span></label>

                            {{ Form::select('role_id', ['' => __('common.choose').' ...'] + $roles, old('role_id'), 
                                ['id' => 'role_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
                        </div>

                        <!-- Active -->
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="active" name="active" value="1" checked>
                                <label for="active">{{__('login.active')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('users.index', app()->getLocale()) }}" class="btn btn-danger" 
                    onclick="loadModalOverlay()" style="width:150px;">
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
            $("#create-user > a").addClass("active");

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
                    loadModalOverlay();
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

        });

    </script>

@endpush
