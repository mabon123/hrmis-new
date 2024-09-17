@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manage_pos_cat') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manage_pos_cat') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_pos_cat') }}</li>
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

    <form method="post" id="frmCreatePosCat" action="{{ route('position-categories.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_pos_cat') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="pos_category_kh">
                                {{ __('common.pos_cat_kh') }} <span class="required">*</span>
                            </label>

                            <input type="text" name="pos_category_kh" id="pos_category_kh" value="{{ old('pos_category_kh') }}" maxlength="180" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="pos_category_en">{{ __('common.pos_cat_en') }}</label>

                            <input type="text" name="pos_category_en" id="pos_category_en" value="{{ old('pos_category_en') }}" maxlength="60" autocomplete="off" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('position-categories.store', app()->getLocale()) }}" style="width:150px;">
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
                    <h3 class="card-title">{{ __('common.manage_pos_cat') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.pos_cat_kh') }}</th>
                                <th>{{ __('common.pos_cat_en') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($posCats as $index => $posCat)

                                <tr id="record-{{ $posCat->pos_category_id }}">
                                    <td>{{ $posCats->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $posCat->pos_category_kh }}</td>
                                    <td>{{ $posCat->pos_category_en }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('position-categories.edit', [app()->getLocale(), $posCat->pos_category_id]) }}" data-update-url="{{ route('position-categories.update', [app()->getLocale(), $posCat->pos_category_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('position-categories.destroy', [app()->getLocale(), $posCat->pos_category_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $posCats->links() }}</div>
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
            $("#position-category > a").addClass("active");

            // Validation
            $("#frmCreatePosCat").validate({
                rules: {
                    pos_category_kh: "required",
                },
                messages: {
                    pos_category_kh: "{{ __('validation.required_field') }}",
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

            // Edit position category
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#pos_category_kh").val(data.pos_category_kh);
                    $("#pos_category_en").val(data.pos_category_en);

                    $("#frmCreatePosCat").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreatePosCat").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreatePosCat").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreatePosCat").attr("action", addURL);

            });

        });

    </script>

@endpush
