@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manage_academic_year') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manage_academic_year') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_academic_year') }}</li>
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

    <!-- Form -->
    @include('admin.academic_years.form')

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manage_academic_year') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.academic_year_kh') }}</th>
                                <th>{{ __('common.academic_year_en') }}</th>
                                <th class="text-center">{{ __('common.cur_academic_year') }}</th>
                                <th>{{ __('common.start_date') }}</th>
                                <th>{{ __('common.end_date') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($academicYears as $index => $academicYear)

                                <tr id="record-{{ $academicYear->year_id }}">
                                    <td>{{ $academicYears->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $academicYear->year_kh }}</td>
                                    <td>{{ $academicYear->year_en }}</td>
                                    <td class="text-center">
                                        @if ($academicYear->cur_year == 1)
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>
                                    <td>{{ $academicYear->start_date > 0 ? 
                                        date('d-m-Y', strtotime($academicYear->start_date)) : '' }}</td>
                                    <td>{{ $academicYear->end_date > 0 ? 
                                        date('d-m-Y', strtotime($academicYear->end_date)) : '' }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('academic-years.edit', [app()->getLocale(), $academicYear->year_id]) }}" data-update-url="{{ route('academic-years.update', [app()->getLocale(), $academicYear->year_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $academicYear->year_id }}" data-route="{{ route('academic-years.destroy', [app()->getLocale(), $academicYear->year_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $academicYears->links() }}</div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#gen-management").addClass("menu-open");
            $("#others > a").addClass("active");

            $('[data-mask]').inputmask();

            // Validation
            $("#frmCreateAcademicYear").validate({
                rules: {
                    year_kh: "required",
                },
                messages: {
                    year_kh: "{{ __('validation.required_field') }}",
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
                    $("#year_kh").val(data.year_kh);
                    $("#year_en").val(data.year_en);
                    $("#academic_start_date").val(data.start_date);
                    $("#academic_end_date").val(data.end_date);
                    $("#cur_year").prop('checked', data.cur_year);

                    $("#frmCreateAcademicYear").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateAcademicYear").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateAcademicYear").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateAcademicYear").attr("action", addURL);

            });

        });

    </script>

@endpush
