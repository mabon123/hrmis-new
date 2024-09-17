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
                    <li class="breadcrumb-item active">{{ __('login.reset_password') }}</li>
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

    {!! Form::open(
        ['route' => ['password.update', [app()->getLocale(), $user->id]], 
        'method' => 'PUT', 
        'id' => 'form-reset-password']) 
    !!}
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('login.reset_password') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" 
                        data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <h5 class="text-center">User Account: {{ $user->staff->surname_kh.' '.$user->staff->name_kh }}</h5>

                <div class="row justify-content-md-center">
                    <div class="col-md-6 col-md-offset-3 col-sm-12">
                        <div class="form-group">
                            <label for="password">{{ __('login.password') }} 
                                <span class="required">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('login.confirm_pwd') }} 
                                <span class="required">*</span></label>
                            <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info" style="width:150px;">
                    <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
                </button>
            </div>
        </div>
    {{ Form::close() }}
</section>

@endsection

@push('scripts')

    <script>
        
        $(function() {
            $("#user").addClass("menu-open");
            $("#manage-user > a").addClass("active");
            
            // Validation
            $("#form-reset-password").validate({
                rules: {
                    password: "required",
                    password_confirmation: "required",
                },
                messages: {
                    password: "{{ __('validation.required_field') }}",
                    password_confirmation: "{{ __('validation.required_field') }}",
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
