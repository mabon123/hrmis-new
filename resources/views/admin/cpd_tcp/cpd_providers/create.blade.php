@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.cpd_provider') }}
                </h1>
            </div>
            <?php /* ?><div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.contract_teacher_info') }}</li>
                    <li class="breadcrumb-item active">{{ __('menu.new_contract_teacher') }}</li>
                </ol>
            </div><?php */ ?>
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

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-info card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active">{{ __('common.basic_info') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body custom-card">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            @if ( isset($cpd_provider) )
                                {!! Form::model($cpd_provider, ['route' => ['cpd-providers.update', 
                                    [app()->getLocale(), $cpd_provider->provider_id]], 'method' => 'PUT', 
                                    'id' => 'frmCreateCPDCourse', 'files' => true]) !!}
                            @else
                                {!! Form::open(['route' => ['cpd-providers.store', [app()->getLocale()]], 
                                'method' => 'POST', 'id' => 'frmCreateCPDProvider', 'files' => true]) !!}
                            @endif

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_type_id">@lang('cpd.provider_type') <span 
                                            class="required">*</span></label>

                                        {{ Form::select('provider_type_id', [
                                            '' => __('common.choose').' ...'] + $providerTypes, null, 
                                            ['id' => 'provider_type_id', 'class' => 'form-control select2 kh', 
                                            'style' => 'width:100%;']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_cat_id">@lang('cpd.provider_cat') <span 
                                            class="required">*</span></label>

                                        {{ Form::select('provider_cat_id', $providerCats, null, 
                                            ['id' => 'provider_cat_id', 'class' => 'form-control select2 kh', 
                                            'style' => 'width:100%;', 'disabled' => (isset($cpd_provider) ? false : true)]) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="accreditation_id">@lang('cpd.accreditation') <span 
                                            class="required">*</span></label>

                                        {{ Form::select('accreditation_id', [
                                            '' => __('common.choose').' ...'] + $accreditations, null, 
                                            ['id' => 'accreditation_id', 'class' => 'form-control select2 kh', 
                                            'style' => 'width:100%;']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="accredited_date">@lang('cpd.accredited_date') <span 
                                            class="required">*</span></label>

                                        <div class="input-group date" data-provide="datepicker"
                                            data-date-format="dd-mm-yyyy">
                                            {{ Form::text('accreditation_date', null, ['class' => 'form-control datepicker '.($errors->has('accreditation_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => 'dd-mm-yyyy']) }}
                                            <div class="input-group-addon">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-box">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_kh">@lang('cpd.provider_kh') <span 
                                            class="required">*</span></label>

                                        {{ Form::text('provider_kh', null, ['id' => 'provider_kh', 'class' => 'form-control kh', 'maxlength' => 150, 'autocomplete' => 'off']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_en">@lang('cpd.provider_en') <span 
                                            class="required">*</span></label>

                                        {{ Form::text('provider_en', null, ['id' => 'provider_en', 'class' => 'form-control kh', 'maxlength' => 50, 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_phone">@lang('common.telephone') <span 
                                            class="required">*</span></label>

                                        {{ Form::text('provider_phone', null, ['id' => 'provider_phone', 'class' => 'form-control kh', 'maxlength' => 50, 'autocomplete' => 'off']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_email">@lang('common.email')</label>

                                        {{ Form::text('provider_email', null, ['id' => 'provider_email', 
                                            'class' => 'form-control kh', 'maxlength' => 50, 'autocomplete' => 'off']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_email">@lang('common.payroll_num')</label>

                                        {{ Form::text('payroll_id', null, ['id' => 'payroll_id', 
                                            'class' => 'form-control', 'maxlength' => 10, 'autocomplete' => 'off', 'disabled' => true]) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="provider_logo">@lang('cpd.provider_logo')</label>

                                        {{ Form::file('provider_logo', ['id' => 'provider_logo', 'class' => 'form-control',]) }}
                                    </div>
                                </div>

                                @if (isset($cpd_provider))
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <img src="{{ asset('storage/images/cpd_providers/'.$cpd_provider->provider_logo) }}" style="width:42%;border:1px #ddd solid;" alt="{{ $cpd_provider->provider_en }}">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="vil_code">@lang('cpd.field_desc_kh')</label>
                                        {{ Form::textarea(
                                            'description_kh', null, 
                                            [
                                                'id' => 'description_kh', 
                                                'class' => 'form-control kh summernote', 
                                                'style' => 'width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;'
                                            ]) 
                                        }}
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="vil_code">@lang('cpd.field_desc_en')</label>
                                        {{ Form::textarea(
                                            'description_en', null, 
                                            [
                                                'id' => 'description_en', 
                                                'class' => 'form-control kh summernote', 
                                                'style' => 'width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;'
                                            ]) 
                                        }}
                                    </div>
                                </div>
                            </div>

                            <h4>{{ __('common.current_address') }}</h4>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pro_code">@lang('common.province') <span 
                                            class="required">*</span></label>

                                        {{ Form::select('pro_code', ['' => __('common.choose').' ...'] + $provinces, null, 
                                            ['id' => 'pro_code', 'class' => 'form-control select2 kh']) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dis_code">@lang('common.district') <span 
                                            class="required">*</span></label>

                                        {{ Form::select('dis_code', ['' => __('common.choose').' ...'] + 
                                            (isset($districts) ? $districts : []), null, 
                                            ['id' => 'dis_code', 'class' => 'form-control select2 kh', 
                                            'disabled' => (!isset($cpd_provider->pro_code) ? true : false)]) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="com_code">@lang('common.commune') <span 
                                            class="required">*</span></label>

                                        {{ Form::select('com_code', ['' => __('common.choose').' ...'] + 
                                            (isset($communes) ? $communes : []), null, 
                                            ['id' => 'com_code', 'class' => 'form-control select2 kh', 
                                            'disabled' => (!isset($cpd_provider->dis_code) ? true : false)]) }}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="vil_code">@lang('common.village') <span 
                                            class="required">*</span></label>

                                        {{ Form::select('vil_code', ['' => __('common.choose').' ...'] + 
                                            (isset($villages) ? $villages : []), null, 
                                            ['id' => 'vil_code', 'class' => 'form-control select2 kh', 
                                            'disabled' => (!isset($cpd_provider->com_code) ? true : false)]) }}
                                    </div>
                                </div>
                            </div>
                            <br />

                            <h4>{{ __('login.account_login') }}</h4>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="level_id">{{__('login.level')}} <span
                                                style="color:#f00">*</span></label>
                                        <select name="level_id" class="form-control select2">
                                            <option value="1">CPD Provider</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="role_id">{{__('login.role')}}<span
                                                style="color:#f00">*</span></label>
                                        <select name="role_id" class="form-control select2">
                                            <option value="3">CPD Provider </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="username"> {{__('login.username')}} <span
                                                style="color:#f00">*</span></label>
                                        <input type="text" name="username" value="{{ old('username') ? old('username') : ((isset($cpd_provider) and $providerUser) ? $providerUser->username : '') }}"
                                            class="form-control" />
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="password">{{__('login.password')}} <span
                                                style="color:#f00">*</span></label>
                                        <input type="password" name="password" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table style="margin:auto;">
                                        <tr>
                                            <td style="padding:5px">
                                                <button type="submit" class="btn btn-info btn-save"
                                                    style="width:150px;">
                                                    <i class="far fa-save"></i> {{ __('button.save') }}
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

<script src="{{ asset('js/location.js') }}"></script>
<script src="{{ asset('js/contstaff.js') }}"></script>

<script>
$(function() {

    $('[data-mask]').inputmask();

    $("#cpd-provider").addClass("menu-open");
    $("#create-provider > a").addClass("active");
    $('.summernote').summernote({height:120});

    // Validation
    $("#frmCreateCPDProvider").validate({
        rules: {
            provider_type_id: "required",
            provider_cat_id: "required",
            accreditation_id: "required",
            accreditation_date: "required",
            provider_kh: "required",
            provider_en: "required",
            provider_phone: "required",
            pro_code: "required",
            dis_code: "required",
            com_code: "required",
            vil_code: "required",
            level_id: "required",
            role_id: "required",
            username: "required",
            password: "required",
        },
        messages: {
            provider_type_id: "{{ __('validation.required_field') }}",
            provider_cat_id: "{{ __('validation.required_field') }}",
            accreditation_id: "{{ __('validation.required_field') }}",
            accreditation_date: "{{ __('validation.required_field') }}",
            provider_kh: "{{ __('validation.required_field') }}",
            provider_en: "{{ __('validation.required_field') }}",
            provider_phone: "{{ __('validation.required_field') }}",
            pro_code: "{{ __('validation.required_field') }}",
            dis_code: "{{ __('validation.required_field') }}",
            com_code: "{{ __('validation.required_field') }}",
            vil_code: "{{ __('validation.required_field') }}",
            level_id: "{{ __('validation.required_field') }}",
            role_id: "{{ __('validation.required_field') }}",
            username: "{{ __('validation.required_field') }}",
            password: "{{ __('validation.required_field') }}",
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
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    // Provider category event
    $("#provider_type_id").change(function() {
        $("#provider_cat_id").find('option:not(:first)').remove();
        $("#provider_cat_id").prop("disabled", true);

        // If individual => enable payroll_id
        if ($(this).val() == 2) { $("#payroll_id").prop("disabled", false); }
        else { $("#payroll_id").prop("disabled", true); }

        if ($(this).val() > 0) {
            $("#provider_cat_id").prop("disabled", false);

            $.ajax({
                type: "GET",
                url: "/provider-type/" + $(this).val() + "/provider-category",
                success: function (provider_cat) {
                    var providerCatLength = Object.keys(provider_cat).length;
                    
                    if ( providerCatLength > 0 ) {
                        for(var key in provider_cat) {
                            $("#provider_cat_id").append('<option value="'+key+'">'+ provider_cat[key] +'</option>');
                        }
                    }
                },
                error: function (err) {
                    console.log('Error:', err);
                }
            });
        }
    });

});
</script>

@endpush