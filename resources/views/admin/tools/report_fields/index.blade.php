@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fa fa-user"></i> {{ __('common.manage_report_field') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manage_report_field') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_report_field') }}</li>
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

    <form method="post" id="frmCreateReportField" action="{{ route('report-fields.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_report_field') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="table_name">{{ __('common.report_field_table') }} 
                                <span class="required">*</span></label>

                            <input type="text" name="table_name" id="table_name" value="{{ old('table_name') }}" maxlength="40" autocomplete="off" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field_name">{{ __('common.report_field_name') }}
                                <span class="required">*</span></label>

                            <input type="text" name="field_name" id="field_name" value="{{ old('field_name') }}" maxlength="30" autocomplete="off" class="form-control" required>
                        </div>
                    </div>

                    <!-- Report Field in Khmer -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="title_kh">{{ __('common.report_field_kh') }} 
                                <span class="required">*</span></label>

                            <input type="text" name="title_kh" id="title_kh" value="{{ old('title_kh') }}" class="form-control kh" required>
                        </div>
                    </div>

                    <!-- Report Field in English -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="title_en">{{ __('common.report_field_en') }}</label>

                            <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}" class="form-control">
                        </div>
                    </div>

                    <!-- Date Format -->
                    <div class="col-md-2">
                        <div class="form-group clearfix" >
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="is_date_field" name="is_date_field" value="0">
                                <label for="is_date_field">{{__('common.is_date_field')}}</label>
                            </div>
                        </div>
                    </div>

                    <!-- Active -->
                    <div class="col-md-1">
                        <div class="form-group clearfix" >
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="active" name="active" value="1" checked>
                                <label for="active">{{__('login.active')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('report-fields.store', app()->getLocale()) }}" style="width:150px;">
                    <i class="far fa-times-circle"></i>&nbsp;{{ __('button.reset') }}
                </button>

                <button type="submit" class="btn btn-info" style="width:150px;">
                    <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
                </button>
            </div>
        </div>
    </form>

    <!-- Grade listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.report_field_listing') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.report_field_table') }}</th>
                                <th>{{ __('common.report_field_name') }}</th>
                                <th>{{ __('common.report_field_kh') }}</th>
                                <th>{{ __('common.report_field_en') }}</th>
                                <th>{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($fields as $field)

                                <tr id="record-{{ $field->id }}">
                                    <td>{{ $fields->firstItem() + $loop->index }}</td>

                                    <td>{{ $field->table_name }}</td>
                                    <td>{{ $field->field_name }}</td>
                                    <td class="kh">{{ $field->title_kh }}</td>
                                    <td>{{ $field->title_en }}</td>

                                    <td class="text-center">
                                        @if( $field->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('report-fields.edit', [app()->getLocale(), $field->id]) }}" data-update-url="{{ route('report-fields.update', [app()->getLocale(), $field->id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('report-fields.destroy', [app()->getLocale(), $field->id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $fields->links() }}</div>
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
            $("#others > a").addClass("active");

            // Validation
            $("#frmCreateReportField").validate({
                rules: {
                    table_name: "required",
                    field_name: "required",
                    title_kh: "required",
                },
                messages: {
                    table_name: "{{ __('validation.required_field', ['attributes' => __('common.report_field_table')]) }}",
                    field_name: "{{ __('validation.required_field', ['attribute' => __('common.report_field_name')]) }}",
                    title_kh: "{{ __('validation.required_field', ['attribute' => __('common.report_field_kh')]) }}",
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
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });

            // Edit Grade
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#table_name").val(data.table_name);
                    $("#field_name").val(data.field_name);
                    $("#title_kh").val(data.title_kh);
                    $("#title_en").val(data.title_en);
                    $("#active").prop('checked', data.active == 1 ? true : false);

                    $("#frmCreateReportField").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateReportField").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {
                $("#frmCreateReportField").trigger("reset");
                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateReportField").attr("action", addURL);
            });

        });

    </script>

@endpush
