@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('login.manage_role') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fa fa-dashboard"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#"> {{ __('login.manage_role') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('login.edit_role') }}</li>
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

    <form method="post" id="frmCreateRole" action="{{ route('roles.update', [app()->getLocale(), $role->role_id]) }}">
        @csrf
        @method('PUT')

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('login.edit_role') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="role_kh">
                                {{ __('login.role_kh') }} <span class="required">*</span>
                            </label>

                            <input type="text" name="role_kh" id="role_kh" value="{{ $role->role_kh }}" maxlength="150" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="role_en">{{ __('login.role_en') }}</label>

                            <input type="text" name="role_en" id="role_en" value="{{ $role->role_en }}" maxlength="50" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="role_slug">{{ __('login.role_slug') }} <span class="required">*</span></label>

                            <input type="text" name="role_slug" id="role_slug" value="{{ $role->role_slug }}" maxlength="100" autocomplete="off" class="form-control @error('role_slug') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group clearfix" style="margin-top:40px;">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="active" name="active" value="1" {{ $role->active == 1 ? 'checked' : '' }}>
                                <label for="active">{{__('login.active')}}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User role permission -->
                @include('admin.roles.partials.permission')
            </div>

            <div class="card-footer">
                <a href="{{ route('roles.index', app()->getLocale()) }}" class="btn btn-danger" 
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
    
    <!-- Validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        
        $(function() {

            $("#user-role").addClass("menu-open");
            $("#manage-role > a").addClass("active");

            // Validation
            $("#frmCreateRole").validate({
                rules: {
                    role_kh: "required",
                    role_slug: "required",
                },
                messages: {
                    role_kh: "{{ __('validation.required_field') }}",
                    role_slug: "{{ __('validation.required_field') }}",
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
