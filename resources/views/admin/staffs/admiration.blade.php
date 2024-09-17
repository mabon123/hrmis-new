@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    @include('admin.staffs.partials.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @include('admin.validations.validate')
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card card-info card-tabs">
                    <div class="card-header p-0 pt-1">
                        @include('admin.staffs.partials.header_tab')
                    </div>

                    <div class="card-body custom-card">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-personal_details" role="tabpanel" aria-labelledby="custom-tabs-personal_details-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 style="border-bottom:none;margin-bottom:15px;">
                                            <span class="section-num">@lang('number.num7').</span>
                                            {{ __('common.admiration') }}
                                        </h4>

                                        <table class="table table-bordered table-head-fixed text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>{{__('common.admiration_type')}}</th>
                                                    <th>{{__('common.provided_by')}}</th>
                                                    <th>{{__('common.date_obtained')}}</th>
                                                    <th>@lang('common.prokah_num')</th>
                                                    <th>@lang('common.prokah_attachment')</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                
                                                @foreach($admirations as $index => $admiration)

                                                    <tr id="record-{{$admiration->admiration_id}}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="kh">{{ $admiration->admiration }}</td>
                                                        <td class="kh">{{ !empty($admiration->admirationSource) ? $admiration->admirationSource->source_kh : '' }}</td>
                                                        <td>{{ $admiration->admiration_date > 0 ? date('d-m-Y', strtotime($admiration->admiration_date)) : '' }}</td>

                                                        <td class="text-center">{{ $admiration->prokah_num }}</td>
                                                        <td>
                                                            @if (!empty($admiration->prokah_doc))
                                                                <a href="{{ asset('storage/images/ref_documents/'.$admiration->prokah_doc) }}" target="_blank"><u>@lang('common.view_file')</u></a>
                                                            @endif
                                                        </td>

                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('admirations.edit', [app()->getLocale(), $staff->payroll_id, $admiration->admiration_id]) }}" data-update-url="{{ route('admirations.update', [app()->getLocale(), $staff->payroll_id, $admiration->admiration_id]) }}"><i class="far fa-edit"></i> @lang('button.edit')</button>

                                                            <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('admirations.destroy', [app()->getLocale(), $staff->payroll_id, $admiration->admiration_id]) }}"><i class="fas fa-trash-alt"></i> @lang('button.delete')</button>
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-add" data-add-url="{{ route('admirations.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:220px;"><i class="fas fa-plus"></i> {{ __('button.addtolist') }}</button>
                                    </div>

                                    <!-- Modal create new short course -->
                                    @include('admin.staffs.modals.modal_admiration')
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
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

            $('[data-mask]').inputmask();

            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-admiration").addClass("active");

            // Validation
            $("#frmCreateAdmiration").validate({
                rules: {
                    admiration_type_id: "required",
                    admiration_source_id: "required",
                    admiration_date: "required",
                },
                messages: {
                    admiration_type_id: "{{ __('validation.required_field') }}",
                    admiration_source_id: "{{ __('validation.required_field') }}",
                    admiration_date: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    $("#modal-admiration").hide();
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

            // CREATE NEW ADMIRATION
            $("#btn-add").click(function() {
                var addURL = $(this).data("add-url");

                $("#frmCreateAdmiration").trigger("reset");
                $("#select2-admiration_type_id-container").text('ជ្រើសរើស ...');
                $("#select2-admiration_source_id-container").text('ជ្រើសរើស ...');

                $("input[name='_method']").remove();
                $("#frmCreateAdmiration").attr("action", addURL);
                $("#modal-admiration").modal("show");
            });

            // Prokah ref document
            $("#prokah_doc").change(function() {
                $("#ref-name").text("");
            });


            // Edit admiration/blame info
            $(document).on("click", ".btn-edit", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function(admiration) {

                    $("#admiration_type_id option[value='"+admiration.admiration_type_id+"']").prop("selected", true);
                    $("#select2-admiration_type_id-container")
                        .text($("#admiration_type_id option[value='"+admiration.admiration_type_id+"']").text());

                    if( admiration.admiration_source_id != null ) {
                        $("#admiration_source_id option[value='"+admiration.admiration_source_id+"']").prop("selected", true);
                        $("#select2-admiration_source_id-container")
                            .text($("#admiration_source_id option[value='"+admiration.admiration_source_id+"']").text());
                    } else {
                        $("#select2-admiration_source_id-container").text('ជ្រើសរើស ...');
                        $("#admiration_source_id").find("option").prop("selected", false);
                    }

                    $("#admiration_date").val(admiration.admiration_date);
                    $("#admiration").val(admiration.admiration);
                    $("#prokah_num").val(admiration.prokah_num);
                    $("#ref-name").text(" : " + admiration.prokah_doc);

                    $("input[name='_method']").remove();
                    $("#frmCreateAdmiration").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateAdmiration").prepend(putMethod);
                    $("#modal-admiration").modal("show");
                });

            });

        });

    </script>

@endpush
