@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row mb-2">
        <div class="col-sm-6"><h1>{{ __('tcp.manage_profession_category') }}</h1></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i> {{ __('menu.home') }}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('profession-categories.index', app()->getLocale()) }}"> 
                    {{ __('tcp.manage_profession_category') }} </a></li>
                <li class="breadcrumb-item active">{{ __('tcp.create_profession_category') }}</li>
            </ol>

        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row row-box">
        <div class="col-md-6">
            <button type="button" id="btn-add" class="btn btn-info" 
                data-add-url="{{ route('profession-categories.store', app()->getLocale()) }}">
                <i class="fas fa-plus"></i> {{ __('tcp.create_profession_category') }}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('tcp.manage_profession_category').' ('.$professionCategories->total().')' }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('tcp.profession_category_kh') }}</th>
                                <th>{{ __('tcp.profession_category_en') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($professionCategories as $index => $profCategory)

                                <tr id="record-{{ $profCategory->tcp_prof_cat_id }}">
                                    <td>{{ $professionCategories->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $profCategory->tcp_prof_cat_kh }}</td>
                                    <td>{{ $profCategory->tcp_prof_cat_en }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" 
                                            data-edit-url="{{ route('profession-categories.edit', [app()->getLocale(), $profCategory->tcp_prof_cat_id]) }}" 
                                            data-update-url="{{ route('profession-categories.update', [app()->getLocale(), $profCategory->tcp_prof_cat_id]) }}">
                                            <i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" 
                                            data-route="{{ route('profession-categories.destroy', [app()->getLocale(), $profCategory->tcp_prof_cat_id]) }}">
                                            <i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($professionCategories->hasPages())
                        {!! $professionCategories->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.tools.prof_categories.modal_form')

@endsection

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
                //$("#pos_category_id").val('').change();
                //$("#pos_level_id").val('').change();
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
                    $("#tcp_prof_cat_kh").val(data.tcp_prof_cat_kh);
                    $("#tcp_prof_cat_en").val(data.tcp_prof_cat_en);
                    //$("#position_hierarchy").val(data.position_hierarchy);

                    //$("#pos_category_id").val(data.pos_category_id).change();
                    //$("#pos_level_id").val(data.pos_level_id).change();

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
