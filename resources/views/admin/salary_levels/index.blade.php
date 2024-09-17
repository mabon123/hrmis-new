@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_salary_level') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manange_salary_level') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_salary_level') }}</li>
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

    <form method="post" id="frmCreateSalaryLevel" action="{{ route('salary-levels.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_salary_level') }}</h3>

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
                            <label for="salary_level_kh">
                                {{ __('common.salary_level_kh') }} <span class="required">*</span>
                            </label>

                            <input type="text" name="salary_level_kh" id="salary_level_kh" value="{{ old('salary_level_kh') }}" maxlength="6" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="salary_level_en">{{ __('common.salary_level_en') }}</label>

                            <input type="text" name="salary_level_en" id="salary_level_en" value="{{ old('salary_level_en') }}" maxlength="2" autocomplete="off" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('salary-levels.store', app()->getLocale()) }}" style="width:150px;">
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
                    <h3 class="card-title">{{ __('common.manange_salary_level') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">{{ __('common.salary_level_kh') }}</th>
                                <th class="text-center">{{ __('common.salary_level_en') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($salaryLevels as $index => $salaryLevel)

                                <tr id="record-{{ $salaryLevel->salary_level_id }}">
                                    <td>{{ $salaryLevels->firstItem() + $index }}</td>
                                    
                                    <td class="kh text-center">{{ $salaryLevel->salary_level_kh }}</td>
                                    <td class="text-center">{{ $salaryLevel->salary_level_en }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('salary-levels.edit', [app()->getLocale(), $salaryLevel->salary_level_id]) }}" data-update-url="{{ route('salary-levels.update', [app()->getLocale(), $salaryLevel->salary_level_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $salaryLevel->salary_level_id }}" data-route="{{ route('salary-levels.destroy', [app()->getLocale(), $salaryLevel->salary_level_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $salaryLevels->links() }}</div>
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
            $("#salary-level > a").addClass("active");

            // Validation
            $("#frmCreateSalaryLevel").validate({
                rules: {
                    salary_level_kh: "required",
                },
                messages: {
                    salary_level_kh: "{{ __('validation.required_field') }}",
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

            // Edit salary level
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#salary_level_kh").val(data.salary_level_kh);
                    $("#salary_level_en").val(data.salary_level_en);

                    $("#frmCreateSalaryLevel").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateSalaryLevel").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateSalaryLevel").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateSalaryLevel").attr("action", addURL);

            });

        });

    </script>

@endpush