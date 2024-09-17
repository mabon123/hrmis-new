@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manage_grade') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fa fa-dashboard"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('grades.index', app()->getLocale()) }}"> 
                        {{ __('common.manage_grade') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_grade') }}</li>
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
                data-add-url="{{ route('grades.store', app()->getLocale()) }}">
                <i class="fas fa-plus"></i> {{ __('common.create_grade') }}</button>
        </div>
    </div>

    <!-- Validations -->
    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Search -->
    @include('admin.tools.grade.search')

    <!-- Grade listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manage_grade').' ('.$grades->total().')' }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.grade_kh') }}</th>
                                <th>{{ __('common.grade_en') }}</th>
                                <th>{{ __('common.edu_level') }}</th>
                                <th>{{ __('common.description') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($grades as $index => $grade)

                                <tr id="record-{{ $grade->grade_id }}">
                                    <td>{{ $grades->firstItem() + $index }}</td>

                                    <td class="kh">{{ $grade->grade_kh }}</td>
                                    <td>{{ $grade->grade_en }}</td>
                                    <td class="kh">{{ $grade->educationLevel ? $grade->educationLevel->edu_level_kh : '' }}</td>
                                    <td>{{ $grade->description }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('grades.edit', [app()->getLocale(), $grade->grade_id]) }}" data-update-url="{{ route('grades.update', [app()->getLocale(), $grade->grade_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('grades.destroy', [app()->getLocale(), $grade->grade_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($grades->hasPages())
                        {!! $grades->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@include('admin.tools.grade.modal_form')

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            $("#gen-management").addClass("menu-open");
            $("#others > a").addClass("active");

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
                $("#edu_level_id").val('').change();
                $("input[name='_method']").remove();
                $("#frmNewRecord").attr("action", addURL);
                $("#modal-form").modal("show");
            });

            // Edit Grade
            $(document).on("click", ".btn-edit", function() {
                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#grade_kh").val(data.grade_kh);
                    $("#grade_en").val(data.grade_en);
                    $("#edu_level_id").val(data.edu_level_id).change();
                    $("#description").val(data.description);

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
