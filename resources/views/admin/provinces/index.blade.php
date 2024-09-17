@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_province') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manange_province') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_province') }}</li>
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

    @if( Auth::user()->can('create-provinces') )

        <form method="post" id="frmCreateProvince" action="{{ route('provinces.store', app()->getLocale()) }}">
            @csrf

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.create_province') }}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="pro_code">
                                    {{ __('common.pro_code') }} <span class="required">*</span>
                                </label>

                                <input type="text" name="pro_code" id="pro_code" value="{{ old('pro_code') }}" maxlength="2" autocomplete="off" class="form-control @error('pro_code') is-invalid @enderror">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name_kh">
                                    {{ __('common.province_kh') }} <span class="required">*</span>
                                </label>

                                <input type="text" name="name_kh" id="name_kh" value="{{ old('name_kh') }}" maxlength="50" autocomplete="off" class="form-control kh">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name_en">{{ __('common.province_en') }}</label>

                                <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" maxlength="150" autocomplete="off" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group clearfix" style="margin-top:40px;">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="active" name="active" value="1" checked>
                                    <label for="active">{{__('login.active')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('provinces.store', app()->getLocale()) }}" style="width:150px;">
                        <i class="far fa-times-circle"></i>&nbsp;{{ __('button.reset') }}
                    </button>

                    <button type="submit" class="btn btn-info" style="width:150px;">
                        <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
                    </button>
                </div>
            </div>
        </form>

    @endif

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manange_province') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">{{ __('common.pro_code') }}</th>
                                <th>{{ __('common.province_kh') }}</th>
                                <th>{{ __('common.province_en') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($provinces as $index => $province)

                                <tr id="record-{{ $province->pro_code }}">
                                    <td>{{ $provinces->firstItem() + $index }}</td>
                                    <td class="text-center">{{ $province->pro_code }}</td>
                                    <td class="kh">{{ $province->name_kh }}</td>
                                    <td>{{ $province->name_en }}</td>

                                    <td class="text-center">
                                        @if( $province->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        @if( Auth::user()->can('edit-provinces') )

                                            <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('provinces.edit', [app()->getLocale(), $province->pro_code]) }}" data-update-url="{{ route('provinces.update', [app()->getLocale(), $province->pro_code]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        @endif

                                        @if( Auth::user()->can('delete-provinces') )

                                            <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $province->pro_code }}" data-route="{{ route('provinces.destroy', [app()->getLocale(), $province->pro_code]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>

                                        @endif
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $provinces->links() }}</div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#gen-management").addClass("menu-open");
            $("#province > a").addClass("active");

            // Validation
            $("#frmCreateProvince").validate({
                rules: {
                    pro_code: "required",
                    name_kh: "required",
                },
                messages: {
                    pro_code: "{{ __('validation.required_field') }}",
                    name_kh: "{{ __('validation.required_field') }}",
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

            // Edit province
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (province) {
                    $("#pro_code").val(province.pro_code);
                    $("#name_kh").val(province.name_kh);
                    $("#name_en").val(province.name_en);

                    if ( province.active === 1 ) {
                        $("#active").prop("checked", true);
                    } else {
                        $("#active").prop("checked", false);
                    }

                    $("#frmCreateProvince").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateProvince").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateProvince").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateProvince").attr("action", addURL);

            });

        });

    </script>

@endpush
