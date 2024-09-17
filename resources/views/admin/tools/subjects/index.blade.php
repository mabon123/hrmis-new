@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_subject') }}
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
                    <li class="breadcrumb-item"><a href="{{ route('subjects.index', app()->getLocale()) }}">
                        {{ __('common.manange_subject') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_subject') }}</li>
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
                data-add-url="{{ route('subjects.store', app()->getLocale()) }}">
                <i class="fas fa-plus"></i> {{ __('common.create_subject') }}</button>
        </div>
    </div>

    <!-- Validations -->
    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Search -->
    @include('admin.tools.subjects.search')

    <!-- Subject listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manange_subject') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.subject_kh') }}</th>
                                <th>{{ __('common.subject_en') }}</th>
                                <th>{{ __('common.edu_level') }}</th>
                                <th>{{ __('common.hierachy') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($subjects as $index => $subject)

                                <tr id="record-{{ $subject->subject_id }}">
                                    <td>{{ $subjects->firstItem() + $index }}</td>

                                    <td class="kh">{{ $subject->subject_kh }}</td>
                                    <td>{{ $subject->subject_en }}</td>
                                    <td class="kh">{{ $subject->educationLevel ? $subject->educationLevel->edu_level_kh : '' }}</td>
                                    <td>{{ $subject->subject_hierachy }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('subjects.edit', [app()->getLocale(), $subject->subject_id]) }}" data-update-url="{{ route('subjects.update', [app()->getLocale(), $subject->subject_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('subjects.destroy', [app()->getLocale(), $subject->subject_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($subjects->hasPages())
                        {!! $subjects->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.tools.subjects.modal_form')

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            $("#gen-management").addClass("menu-open");
            $("#subject > a").addClass("active");

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

            // Edit Subject
            $(document).on("click", ".btn-edit", function() {
                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#subject_kh").val(data.subject_kh);
                    $("#subject_en").val(data.subject_en);
                    $("#subject_shortcut").val(data.subject_shortcut);
                    $("#edu_level_id").val(data.edu_level_id).change();
                    $("#subject_hierachy").val(data.subject_hierachy);

                    $("#h_g7").val(data.h_g7);
                    $("#h_g8").val(data.h_g8);
                    $("#h_g9").val(data.h_g9);
                    $("#h_g10").val(data.h_g10);
                    $("#h_g11_sc").val(data.h_g11_sc); 
                    $("#h_g11_ss").val(data.h_g11_ss);
                    $("#h_g12_sc").val(data.h_g12_sc);
                    $("#h_g12_ss").val(data.h_g12_ss);
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
