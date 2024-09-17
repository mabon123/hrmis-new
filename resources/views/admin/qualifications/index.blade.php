@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_qualification') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manange_qualification') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_qualification') }}</li>
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

    <form method="post" id="frmCreateQualification" action="{{ route('qualification-codes.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_qualification') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="qualification_kh">
                                {{ __('common.qualification_kh') }} 
                                <span class="required">*</span>
                            </label>

                            <input type="text" name="qualification_kh" id="qualification_kh" value="{{ old('qualification_kh') }}" maxlength="150" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="qualification_en">{{ __('common.qualification_en') }}</label>

                            <input type="text" name="qualification_en" id="qualification_en" value="{{ old('qualification_en') }}" maxlength="50" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="qualification_hierachy">
                                {{ __('common.hierachy') }}
                                <span class="required">*</span>
                            </label>

                            <input type="number" name="qualification_hierachy" id="qualification_hierachy" value="{{ old('qualification_hierachy') }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('qualification-codes.store', app()->getLocale()) }}" style="width:150px;">
                    <i class="far fa-times-circle"></i>&nbsp;{{ __('button.reset') }}
                </button>

                <button type="submit" class="btn btn-info" style="width:150px;">
                    <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
                </button>
            </div>
        </div>
    </form>

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manange_qualification') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.qualification_kh') }}</th>
                                <th>{{ __('common.qualification_en') }}</th>
                                <th class="text-center">{{ __('common.hierachy') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($qualifications as $index => $qualification)

                                <tr id="record-{{ $qualification->qualification_code }}">
                                    <td>{{ $qualifications->firstItem() + $index }}</td>

                                    <td class="kh">{{ $qualification->qualification_kh }}</td>
                                    <td>{{ $qualification->qualification_en }}</td>
                                    <td class="text-center">{{ $qualification->qualification_hierachy }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('qualification-codes.edit', [app()->getLocale(), $qualification->qualification_code]) }}" data-update-url="{{ route('qualification-codes.update', [app()->getLocale(), $qualification->qualification_code]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $qualification->qualification_code }}" data-route="{{ route('qualification-codes.destroy', [app()->getLocale(), $qualification->qualification_code]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $qualifications->links() }}</div>
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
            $("#qualification > a").addClass("active");

            // Validation
            $("#frmCreateQualification").validate({
                rules: {
                    qualification_kh: "required",
                    qualification_hierachy: "required",
                },
                messages: {
                    qualification_kh: "{{ __('validation.required_field') }}",
                    qualification_hierachy: "{{ __('validation.required_field') }}",
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

            // Edit professional type
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#qualification_kh").val(data.qualification_kh);
                    $("#qualification_en").val(data.qualification_en);
                    $("#qualification_hierachy").val(data.qualification_hierachy);

                    $("#frmCreateQualification").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateQualification").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateQualification").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateQualification").attr("action", addURL);

            });

        });

    </script>

@endpush
