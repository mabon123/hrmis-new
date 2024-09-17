@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manage_district') }}
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
                    <li class="breadcrumb-item"><a href="{{ route('districts.index', app()->getLocale()) }}"> 
                        {{ __('common.manage_district') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_district') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row row-box">
        <div class="col-md-6">
            <button type="button" id="btn-add" class="btn btn-info" 
                data-add-url="{{ route('districts.store', app()->getLocale()) }}" style="width:220px;">
                <i class="fas fa-plus"></i> {{ __('common.create_district') }}</button>
        </div>
    </div>

    <!-- Validations -->
    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Search -->
    @include('admin.tools.districts.search')

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manage_district').' ('.$districts->total().')' }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.province') }}</th>
                                <th>{{ __('common.dis_code') }}</th>
                                <th>{{ __('common.district_kh') }}</th>
                                <th>{{ __('common.district_en') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($districts as $index => $district)

                                <tr id="record-{{ $district->dis_code }}">
                                    <td>{{ $districts->firstItem() + $index }}</td>
                                    <td class="kh">{{ $district->province->name_kh }}</td>
                                    <td>{{ $district->dis_code }}</td>
                                    <td class="kh">{{ $district->name_kh }}</td>
                                    <td>{{ $district->name_en }}</td>

                                    <td class="text-center">
                                        @if( $district->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('districts.edit', [app()->getLocale(), $district->dis_code]) }}" data-update-url="{{ route('districts.update', [app()->getLocale(), $district->dis_code]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $district->dis_code }}" data-route="{{ route('districts.destroy', [app()->getLocale(), $district->dis_code]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($districts->hasPages())
                        {!! $districts->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.tools.districts.modal_form')

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            $("#gen-management").addClass("menu-open");
            $("#district > a").addClass("active");

            // Validation
            $("#frmNewRecord").validate({
                submitHandler: function(frm) {
                    $('#modal-form').modal('hide');
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
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });

            // Add
            $('#btn-add').click(function() {
                var addURL = $(this).data("add-url");
                $("#frmNewRecord").trigger("reset");
                $("#pro_code").val('').change();
                $("input[name='_method']").remove();
                $("#frmNewRecord").attr("action", addURL);
                $("#modal-form").modal("show");
            });

            // Event on province dropdown
            $("#province_dropdown").change(function() {
                $("#dis_code").val($(this).val());
            });

            // Edit district
            $(document).on("click", ".btn-edit", function() {
                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (district) {
                    $("#pro_code").val(district.pro_code).change();
                    $("#dis_code").val(district.dis_code);
                    $("#name_kh").val(district.name_kh);
                    $("#name_en").val(district.name_en);
                    $("#note").val(district.note);
                    $("#active").prop("checked", district.active == 1 ? true : false);

                    $("input[name='_method']").remove();
                    $("#frmNewRecord").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmNewRecord").prepend(putMethod);
                    $("#modal-form").modal("show");
                });
            });
        });
    </script>
@endpush
