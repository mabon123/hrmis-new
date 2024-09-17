@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manage_admiration_type') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manage_admiration_type') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_admiration_type') }}</li>
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

    <form method="post" id="frmCreateType" action="{{ route('admiration-types.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_admiration_type') }}</h3>

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
                            <label for="admiration_type_kh">
                                {{ __('common.admiration_type_kh') }} <span class="required">*</span>
                            </label>

                            <input type="text" name="admiration_type_kh" id="admiration_type_kh" value="{{ old('admiration_type_kh') }}" maxlength="100" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="admiration_type_en">{{ __('common.admiration_type_en') }}</label>

                            <input type="text" name="admiration_type_en" id="admiration_type_en" value="{{ old('admiration_type_en') }}" maxlength="50" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group clearfix" style="margin-top:40px;">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="active" name="active" value="1" checked>
                                <label for="active">{{__('login.active')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('admiration-types.store', app()->getLocale()) }}" style="width:150px;">
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
                    <h3 class="card-title">{{ __('common.manage_admiration_type') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.admiration_type_kh') }}</th>
                                <th>{{ __('common.admiration_type_en') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($admirationTypes as $index => $type)

                                <tr id="record-{{ $type->admiration_type_id }}">
                                    <td>{{ $admirationTypes->firstItem() + $index }}</td>

                                    <td class="kh">{{ $type->admiration_type_kh }}</td>
                                    <td>{{ $type->admiration_type_en }}</td>

                                    <td class="text-center">
                                        @if( $type->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('admiration-types.edit', [app()->getLocale(), $type->admiration_type_id]) }}" data-update-url="{{ route('admiration-types.update', [app()->getLocale(), $type->admiration_type_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $type->admiration_type_id }}" data-route="{{ route('admiration-types.destroy', [app()->getLocale(), $type->admiration_type_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $admirationTypes->links() }}</div>
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
            $("#frmCreateType").validate({
                rules: {
                    admiration_type_kh: "required",
                },
                messages: {
                    admiration_type_kh: "{{ __('validation.required_field',['attribute' => __('common.admiration_type_kh')]) }}",
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

            // Edit office
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#admiration_type_kh").val(data.admiration_type_kh);
                    $("#admiration_type_en").val(data.admiration_type_en);

                    if ( data.active === 1 ) {
                        $("#active").prop("checked", true);
                    } else {
                        $("#active").prop("checked", false);
                    }

                    $("#frmCreateType").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateType").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateType").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateType").attr("action", addURL);

            });

        });

    </script>

@endpush