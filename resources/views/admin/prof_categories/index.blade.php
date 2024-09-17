@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_prof_category') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manange_prof_category') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_prof_category') }}</li>
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

    <form method="post" id="frmCreateProfCategory" action="{{ route('professional-category.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_prof_category') }}</h3>

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
                            <label for="prof_category_kh">
                                {{ __('common.prof_category_kh') }} 
                                <span class="required">*</span>
                            </label>

                            <input type="text" name="prof_category_kh" id="prof_category_kh" value="{{ old('prof_category_kh') }}" maxlength="150" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="prof_category_en">{{ __('common.prof_category_en') }}</label>

                            <input type="text" name="prof_category_en" id="prof_category_en" value="{{ old('prof_category_en') }}" maxlength="50" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="prof_hierachy">
                                {{ __('common.hierachy') }}
                                <span class="required">*</span>
                            </label>

                            <input type="number" name="prof_hierachy" id="prof_hierachy" value="{{ old('prof_hierachy') }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('professional-category.store', app()->getLocale()) }}" style="width:150px;">
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
                    <h3 class="card-title">{{ __('common.manange_prof_category') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.prof_category_kh') }}</th>
                                <th>{{ __('common.prof_category_en') }}</th>
                                <th class="text-center">{{ __('common.hierachy') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($profCategories as $index => $profCategory)

                                <tr id="record-{{ $profCategory->prof_category_id }}">
                                    <td>{{ $profCategories->firstItem() + $index }}</td>
                                    <td class="kh">{{ $profCategory->prof_category_kh }}</td>
                                    <td>{{ $profCategory->prof_category_en }}</td>
                                    <td class="text-center">{{ $profCategory->prof_hierachy }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('professional-category.edit', [app()->getLocale(), $profCategory->prof_category_id]) }}" data-update-url="{{ route('professional-category.update', [app()->getLocale(), $profCategory->prof_category_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $profCategory->prof_category_id }}" data-route="{{ route('professional-category.destroy', [app()->getLocale(), $profCategory->prof_category_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $profCategories->links() }}</div>
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
            $("#professional-category > a").addClass("active");

            // Validation
            $("#frmCreateProfCategory").validate({
                rules: {
                    prof_category_kh: "required",
                    prof_hierachy: "required",
                },
                messages: {
                    prof_category_kh: "{{ __('validation.required_field') }}",
                    prof_hierachy: "{{ __('validation.required_field') }}",
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

            // Edit professional category
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#prof_category_kh").val(data.prof_category_kh);
                    $("#prof_category_en").val(data.prof_category_en);
                    $("#prof_hierachy").val(data.prof_hierachy);

                    $("#frmCreateProfCategory").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateProfCategory").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateProfCategory").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateProfCategory").attr("action", addURL);

            });

        });

    </script>

@endpush
