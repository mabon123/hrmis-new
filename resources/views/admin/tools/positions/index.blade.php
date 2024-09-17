@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_position') }}
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
                    <li class="breadcrumb-item"><a href="{{ route('positions.index', app()->getLocale()) }}"> 
                        {{ __('common.manange_position') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_position') }}</li>
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
                data-add-url="{{ route('positions.store', app()->getLocale()) }}">
                <i class="fas fa-plus"></i> {{ __('common.create_position') }}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Search -->
    @include('admin.tools.positions.search')

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manange_position').' ('.$positions->total().')' }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.position_kh') }}</th>
                                <th>{{ __('common.position_en') }}</th>
                                <th>{{ __('common.position_category') }}</th>
                                <th>{{ __('common.position_level') }}</th>
                                <th>{{ __('common.hierachy') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($positions as $index => $position)

                                <tr id="record-{{ $position->position_id }}">
                                    <td>{{ $positions->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $position->position_kh }}</td>
                                    <td>{{ $position->position_en }}</td>

                                    <td class="kh">{{ !empty($position->positionCategory) ? $position->positionCategory->pos_category_kh : '---' }}</td>

                                    <td class="kh">{{ !empty($position->positionLevel) ? $position->positionLevel->location_type_kh : '---' }}</td>

                                    <td class="text-center">{{ $position->position_hierarchy }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('positions.edit', [app()->getLocale(), $position->position_id]) }}" data-update-url="{{ route('positions.update', [app()->getLocale(), $position->position_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('positions.destroy', [app()->getLocale(), $position->position_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($positions->hasPages())
                        {!! $positions->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.tools.positions.modal_form')

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        
        $(function() {

            $("#gen-management").addClass("menu-open");
            $("#position > a").addClass("active");

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
                $("#pos_category_id").val('').change();
                $("#pos_level_id").val('').change();
                $("input[name='_method']").remove();
                $("#frmNewRecord").attr("action", addURL);
                $("#modal-form").modal("show");
            });

            // Edit official rank
            $(document).on("click", ".btn-edit", function() {
                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#position_kh").val(data.position_kh);
                    $("#position_en").val(data.position_en);
                    $("#position_hierarchy").val(data.position_hierarchy);

                    $("#pos_category_id").val(data.pos_category_id).change();
                    $("#pos_level_id").val(data.pos_level_id).change();

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
