@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_location_type') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manange_location_type') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_location_type') }}</li>
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

    <form method="post" id="frmCreateLocationType" action="{{ route('location-types.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_location_type') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="location_type_kh">
                                {{ __('common.location_type_kh') }} <span class="required">*</span>
                            </label>

                            <input type="text" name="location_type_kh" id="location_type_kh" value="{{ old('location_type_kh') }}" maxlength="180" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="location_type_en">{{ __('common.location_type_en') }}</label>

                            <input type="text" name="location_type_en" id="location_type_en" value="{{ old('location_type_en') }}" maxlength="60" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="level_id">{{ __('common.level_id') }}</label>

                            <input type="number" name="level_id" id="level_id" value="{{ old('level_id') }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group clearfix" style="margin-top:40px;">
                            <input type="hidden" value="0" name="under_moeys">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="under_moeys" name="under_moeys" value="1" checked>
                                <label for="under_moeys">{{__('common.under_moeys')}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group clearfix" style="margin-top:40px;">
                            <input type="hidden" value="0" name="is_school">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="is_school" name="is_school" value="1" checked>
                                <label for="is_school">{{__('common.is_school')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('location-types.store', app()->getLocale()) }}" style="width:150px;">
                    <i class="far fa-times-circle"></i>&nbsp;{{ __('button.reset') }}
                </button>

                <button type="submit" class="btn btn-info" style="width:150px;">
                    <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
                </button>
            </div>
        </div>
    </form>

    <!-- Location type listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manange_location_type') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.location_type_kh') }}</th>
                                <th>{{ __('common.location_type_en') }}</th>
                                <th>{{ __('common.under_moeys') }}</th>
                                <th>{{ __('common.is_school') }}</th>
                                <th>{{ __('common.level_id') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($locationTypes as $index => $type)

                                <tr id="record-{{ $type->pos_category_id }}">
                                    <td>{{ $locationTypes->firstItem() + $index }}</td>

                                    <td class="kh">{{ $type->location_type_kh }}</td>
                                    <td>{{ $type->location_type_en }}</td>
                                    <td class="text-center">
                                        @if( $type->under_moeys )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if( $type->is_school )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>
                                    <td>{{ $type->level_id }}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('location-types.edit', [app()->getLocale(), $type->location_type_id]) }}" data-update-url="{{ route('location-types.update', [app()->getLocale(), $type->location_type_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('location-types.destroy', [app()->getLocale(), $type->location_type_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $locationTypes->links() }}</div>
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
            $("#location-type > a").addClass("active");

            // Validation
            $("#frmCreateLocationType").validate({
                rules: {
                    location_type_kh: "required",
                },
                messages: {
                    location_type_kh: "{{ __('validation.required_field', ['attribute' => __('common.location_type_kh')]) }}",
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

            // Edit location type
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#location_type_kh").val(data.location_type_kh);
                    $("#location_type_en").val(data.location_type_en);
                    $("#level_id").val(data.level_id);
                    $("#under_moeys").prop("checked", !!data.under_moeys);
                    $("#is_school").prop("checked", !!data.is_school);

                    $("#frmCreateLocationType").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateLocationType").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateLocationType").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateLocationType").attr("action", addURL);

            });

        });

    </script>

@endpush
