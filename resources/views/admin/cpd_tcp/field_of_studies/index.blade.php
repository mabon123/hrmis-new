@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('cpd.field_of_study') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('cpd.field_of_study') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row row-box">
        <div class="col-md-6">
            <button type="button" id="btn-add-field-study" class="btn btn-info" style="width:120px;">
                <i class="fas fa-plus"></i> @lang('button.add')
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('cpd.field_of_study') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cpd.field_code') }}</th>
                                <th>{{ __('cpd.field_kh') }}</th>
                                <th>{{ __('cpd.field_en') }}</th>
                                <th>{{ __('cpd.field_desc_kh') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($fieldStudies as $index => $fieldStudy)

                                <tr id="record-{{ $fieldStudy->cpd_field_id }}">
                                    <td>{{ $fieldStudies->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $fieldStudy->cpd_field_code }}</td>
                                    <td class="kh">{{ $fieldStudy->cpd_field_kh }}</td>
                                    <td>{{ $fieldStudy->cpd_field_en }}</td>
                                    <td class="kh">{!! $fieldStudy->cpd_field_desc_kh !!}</td>

                                    <td class="text-center">
                                        @if( $fieldStudy->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('cpd-field-of-studies.edit', [app()->getLocale(), $fieldStudy->cpd_field_id]) }}" data-update-url="{{ route('cpd-field-of-studies.update', [app()->getLocale(), $fieldStudy->cpd_field_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <?php /* ?><button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $fieldStudy->cpd_field_id }}" data-route="{{ route('cpd-field-of-studies.destroy', [app()->getLocale(), $fieldStudy->cpd_field_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button><?php */ ?>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>

                    @include('admin.cpd_tcp.field_of_studies.modal_field_study')
                </div>

                <div class="card-footer">{{ $fieldStudies->links() }}</div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#tcp_module").addClass("menu-open");
            $("#cdp_field_of_study > a").addClass("active");
            $('.textarea').summernote({height:100});

            // Validation
            $("#form_field_study").validate({
                rules: {
                    cpd_field_kh: "required",
                    cpd_field_code: "required",
                },
                messages: {
                    cpd_field_kh: "{{ __('validation.required_field') }}",
                    cpd_field_code: "{{ __('validation.required_field') }}",
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

            // Add new event
            $("#btn-add-field-study").click(function() {
                $("#form_field_study").trigger("reset");
                $("#cpd_field_desc_kh").summernote('code', null);
                $("#cpd_field_desc_en").summernote('code', null);
                $("#modal_field_study").modal("show");
            });

            // Form submit
            $("#form_field_study").submit(function() {
                //$("#modal_field_study").modal("hide");
            });

            // Edit office
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#cpd_field_code").val(data.cpd_field_code);
                    $("#cpd_field_kh").val(data.cpd_field_kh);
                    $("#cpd_field_en").val(data.cpd_field_en);
                    $("#cpd_field_desc_kh").summernote('code', data.cpd_field_desc_kh);
                    $("#cpd_field_desc_en").summernote('code', data.cpd_field_desc_en);
                    $("#active").prop("checked", (data.active == 1 ? true : false));

                    $("#form_field_study").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#form_field_study").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                    $("#modal_field_study").modal("show");
                    $("#modal_field_study").css('overflow-y', 'auto');
                });

            });

        });

    </script>

@endpush
