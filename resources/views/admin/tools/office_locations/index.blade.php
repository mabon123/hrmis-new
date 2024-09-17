@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-user"></i> {{ __('common.manange_office_location') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i> {{ __('menu.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#"> {{ __('common.manange_office_location') }} </a></li>
                        <li class="breadcrumb-item active">{{ __('common.create_office_location') }}</li>
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
                    data-add-url="{{ route('office-locations.store', app()->getLocale()) }}">
                    <i class="fas fa-plus"></i> {{ __('common.create_office_location') }}</button>
            </div>
        </div>

        <!-- Validations -->
        <div class="row">
            <div class="col-md-12">
                @include('admin.validations.validate')
            </div>
        </div>

        <!-- Search -->
        @include('admin.tools.office_locations.search')

        <!-- Office Location listing -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('common.manange_office_location').'('.$officeLocations->total().')' }}</h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('common.office') }}</th>
                                    <th>{{ __('common.province') }}</th>
                                    <th>{{ __('common.location') }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($officeLocations as $index => $location)

                                    <tr id="record-{{ $location->sys_admin_office_id }}">
                                        <td>{{ $officeLocations->firstItem() + $index }}</td>

                                        <td class="kh">{{ $location->office ? $location->office->office_kh : '' }}</td>
                                        <td class="kh">{{ $location->province ? $location->province->name_kh : '' }}</td>
                                        <td class="kh">{{ $location->location ? $location->location->location_kh : '' }}</td>

                                        <td class="text-right">
                                            <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('office-locations.edit', [app()->getLocale(), $location->sys_admin_office_id]) }}" data-update-url="{{ route('office-locations.update', [app()->getLocale(), $location->sys_admin_office_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                            <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('office-locations.destroy', [app()->getLocale(), $location->sys_admin_office_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        @if ($officeLocations->hasPages())
                            {!! $officeLocations->appends(Request::except('page'))->render() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include('admin.tools.office_locations.modal_form')
@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            $("#gen-management").addClass("menu-open");
            $("#office-location > a").addClass("active");

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
                $("#office_id").val('').change();
                $("#pro_code").val('').change();
                $("#location_code").val('').change();
                $("input[name='_method']").remove();
                $("#frmNewRecord").attr("action", addURL);
                $("#modal-form").modal("show");
            });

            // Edit Office Location
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#office_id").val(data.office_id).change();
                    $("#pro_code").val(data.pro_code).change();
                    $("#location_code").val(data.location_code).change();

                    $("input[name='_method']").remove();
                    $("#frmNewRecord").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmNewRecord").prepend(putMethod);
                    $("#modal-form").modal("show");
                });

            });

            // Province change -> auto-fill data for location belong to that province
            $("#province_kh").change(function() {
                $.ajax({
                    type: "GET",
                    url: "/provinces/" + $(this).val() + "/locations",
                    success: function (locations) {
                        var locationCount = Object.keys(locations).length;
                        $("#location_kh").find('option:not(:first)').remove();
                        
                        if ( locationCount > 0 ) {
                            for(var key in locations) {
                                $("#location_kh").append('<option value="'+key+'">'+ locations[key] +'</option>');
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            });

        });

    </script>

@endpush
