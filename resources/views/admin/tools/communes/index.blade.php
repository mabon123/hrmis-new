@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manage_commune') }}
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
                    <li class="breadcrumb-item"><a href="{{ route('communes.index', app()->getLocale()) }}"> 
                        {{ __('common.manage_commune') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_commune') }}</li>
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
                data-add-url="{{ route('communes.store', app()->getLocale()) }}" style="width:220px;">
                <i class="fas fa-plus"></i> {{ __('common.create_commune') }}</button>
        </div>
    </div>

    <!-- Validations -->
    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Search -->
    @include('admin.tools.communes.search')

    <!-- Commune listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manage_commune').' ('.$communes->total().')' }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.province') }}</th>
                                <th>{{ __('common.district') }}</th>
                                <th>{{ __('common.com_code') }}</th>
                                <th>{{ __('common.commune_kh') }}</th>
                                <th>{{ __('common.commune_en') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($communes as $index => $commune)

                                <tr id="record-{{ $commune->com_code }}">
                                    <td>{{ $communes->firstItem() + $index }}</td>
                                    <td class="kh">{{ $commune->district->province->name_kh }}</td>
                                    <td class="kh">{{ $commune->district->name_kh }}</td>
                                    <td>{{ $commune->com_code }}</td>
                                    <td class="kh">{{ $commune->name_kh }}</td>
                                    <td>{{ $commune->name_en }}</td>

                                    <td class="text-center">
                                        @if( $commune->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('communes.edit', [app()->getLocale(), $commune->com_code]) }}" data-update-url="{{ route('communes.update', [app()->getLocale(), $commune->com_code]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $commune->com_code }}" data-route="{{ route('communes.destroy', [app()->getLocale(), $commune->com_code]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($communes->hasPages())
                        {!! $communes->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.tools.communes.modal_form')

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            $("#gen-management").addClass("menu-open");
            $("#commune > a").addClass("active");

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
                $("#dis_code").val('').change();
                $("input[name='_method']").remove();
                $("#frmNewRecord").attr("action", addURL);
                $("#modal-form").modal("show");
            });

            // Event on province dropdown
            $("#dis_code").change(function() {
                $("#district_code").val($(this).val());
            });

            // Edit district
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (commune) {
                    // Province
                    $("#pro_code option[value='"+commune.pro_code+"']").prop("selected", true);
                    $("#select2-pro_code-container")
                        .text($("#pro_code option[value='"+commune.pro_code+"']").text());

                    // District
                    $("#dis_code").empty();
                    $("#dis_code").append('<option value="">ជ្រើសរើស ...</option>');

                    $.ajax({
                        type: "GET",
                        url: "/provinces/" + commune.pro_code + "/districts",
                        success: function (districts) {
                            for(var index in districts) {
                                $("#dis_code").append('<option value="'+districts[index].dis_code+'">'+ districts[index].name_kh +'</option>');

                                if( commune.dis_code == districts[index].dis_code ) {
                                    $("#select2-dis_code-container").text(districts[index].name_kh);
                                    $("#dis_code option[value='"+commune.dis_code+"']").prop("selected", true);
                                }
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });

                    $("#dis_code").prop("disabled", false);

                    $("#district_code").val(commune.dis_code);
                    $("#commune_code").val(commune.commune_code);
                    $("#name_kh").val(commune.name_kh);
                    $("#name_en").val(commune.name_en);
                    $("#note").val(commune.note);
                    $("#active").prop("checked", commune.active == 1 ? true : false);

                    $("input[name='_method']").remove();
                    $("#frmNewRecord").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmNewRecord").prepend(putMethod);
                    $("#modal-form").modal("show");
                });
            });

            // Province dropdown on search
            $("#province_code").change(function() {
                generateChildDropdownInfo($(this).val(), `/provinces/${$(this).val()}/districts`, $('#search_district_code'), 'dis_code');
            });
        });
    </script>
@endpush
