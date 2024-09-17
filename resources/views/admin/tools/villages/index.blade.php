@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manage_village') }}
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
                    <li class="breadcrumb-item"><a href="{{ route('villages.index', app()->getLocale()) }}"> 
                        {{ __('common.manage_village') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_village') }}</li>
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
                data-add-url="{{ route('villages.store', app()->getLocale()) }}">
                <i class="fas fa-plus"></i> {{ __('common.create_village') }}</button>
        </div>
    </div>

    <!-- Validations -->
    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Search -->
    @include('admin.tools.villages.search')

    <!-- Commune listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manage_village').' ('.$villages->total().')' }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.province') }}</th>
                                <th>{{ __('common.district') }}</th>
                                <th>{{ __('common.commune') }}</th>
                                <th>{{ __('common.vil_code') }}</th>
                                <th>{{ __('common.village_kh') }}</th>
                                <th>{{ __('common.village_en') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($villages as $index => $village)

                                <tr id="record-{{ $village->vil_code }}">
                                    <td>{{ $villages->firstItem() + $index }}</td>
                                    <td class="kh">{{ $village->commune->district->province->name_kh }}</td>
                                    <td class="kh">{{ $village->commune->district->name_kh }}</td>
                                    <td class="kh">{{ $village->commune->name_kh }}</td>
                                    <td>{{ $village->vil_code }}</td>
                                    <td class="kh">{{ $village->name_kh }}</td>
                                    <td>{{ $village->name_en }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('villages.edit', [app()->getLocale(), $village->vil_code]) }}" data-update-url="{{ route('villages.update', [app()->getLocale(), $village->vil_code]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $village->vil_code }}" data-route="{{ route('villages.destroy', [app()->getLocale(), $village->vil_code]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($villages->hasPages())
                        {!! $villages->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.tools.villages.modal_form')

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            $("#gen-management").addClass("menu-open");
            $("#village > a").addClass("active");

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

            // Event on commune dropdown
            $("#com_code").change(function() {
                $("#commune_code").val($(this).val());
            });

            // Edit village
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (village) {
                    // Province
                    $("#pro_code option[value='"+village.pro_code+"']").prop("selected", true);
                    $("#select2-pro_code-container")
                        .text($("#pro_code option[value='"+village.pro_code+"']").text());

                    // District
                    $("#dis_code").empty();
                    $("#dis_code").append('<option value="">ជ្រើសរើស ...</option>');

                    $.ajax({
                        type: "GET",
                        url: "/provinces/" + village.pro_code + "/districts",
                        success: function (districts) {
                            for(var index in districts) {
                                $("#dis_code").append('<option value="'+districts[index].dis_code+'">'+ districts[index].name_kh +'</option>');

                                if( village.dis_code == districts[index].dis_code ) {
                                    $("#select2-dis_code-container").text(districts[index].name_kh);
                                    $("#dis_code option[value='"+village.dis_code+"']").prop("selected", true);
                                }
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });

                    $("#dis_code").prop("disabled", false);

                    // Commune
                    $("#com_code").empty();
                    $("#com_code").append('<option value="">ជ្រើសរើស ...</option>');

                    $.ajax({
                        type: "GET",
                        url: "/districts/" + village.dis_code + "/communes",
                        success: function (communes) {
                            for(var index in communes) {
                                $("#com_code").append('<option value="'+communes[index].com_code+'">'+ communes[index].name_kh +'</option>');

                                if( village.com_code == communes[index].com_code ) {
                                    $("#select2-com_code-container").text(communes[index].name_kh);
                                    $("#com_code option[value='"+village.com_code+"']").prop("selected", true);
                                }
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });

                    $("#com_code").prop("disabled", false);

                    $("#commune_code").val(village.com_code);
                    $("#village_code").val(village.village_code);
                    $("#name_kh").val(village.name_kh);
                    $("#name_en").val(village.name_en);
                    $("#note").val(village.note);

                    $("input[name='_method']").remove();
                    $("#frmNewRecord").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmNewRecord").prepend(putMethod);
                    $("#modal-form").modal("show");
                });

            });

            // Province dropdown on search
            $("#province_code").change(function() {
                generateChildDropdownInfo($(this).val(), `/provinces/${$(this).val()}/districts`, $('#district_code'), 'dis_code');
            });

            // District dropdown on search
            $("#district_code").change(function() {
                generateChildDropdownInfo($(this).val(), `/districts/${$(this).val()}/communes`, $('#search_commune_code'), 'com_code');
            });
        });
    </script>
@endpush
