@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.contract_teacher_info') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.contract_teacher_info') }}</li>
                    <li class="breadcrumb-item active">{{ __('menu.new_contract_teacher') }}</li>
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

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-info card-tabs">
                <div class="card-header p-0 pt-1">
                    @include('admin.contract_teachers.header_tab')
                </div>
                
                <div class="card-body custom-card">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            
                            <?php /* ?><form method="post" id="frmUpdateContTeacher" action="{{ route('contract-teachers.update', [app()->getLocale(), $contract_teacher->contstaff_payroll_id]) }}" enctype="multipart/form-data"><?php */ ?>
                            {!! Form::model($contract_teacher, ['route' => ['contract-teachers.update', [app()->getLocale(), $contract_teacher->contstaff_payroll_id]], 'method' => 'PUT', 'id' => 'frmUpdateContTeacher', 'enctype' => 'multipart/form-data']) !!}
                                

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>{{ __('common.basic_info') }}</h4>

                                        @include('admin.contract_teachers.partials.general_info')
                                    </div>

                                    <!-- Place of Birth -->
                                    <div class="col-md-12">
                                        <h4>
                                            <span class="section-num">@lang('number.num4'). </span>
                                            {{ __('common.pob') }}
                                        </h4>

                                        @include('admin.contract_teachers.partials.birthplace_info')
                                    </div>

                                    <!-- Qualification info section -->
                                    <div class="col-md-12">
                                        <h4>
                                            <span class="section-num">{{ __('number.num5') }}. </span>
                                            {{ __('common.qualification') }}
                                        </h4>

                                        @include('admin.contract_teachers.partials.qualification_info')

                                        <?php /* ?><div class="row-box">
                                            <div class="row">
                                                <!-- Qualification -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="qualification_code">{{__('common.qualification')}}</label>

                                                        <select class="form-control select2" name="qualification_code" id="qualification_code" style="width: 100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>
                                                            
                                                            @foreach($qualificationCodes as $qualificationCode)
                                                                <option value="{{ $qualificationCode->qualification_code }}" {{ $contract_teacher->qualification_code == $qualificationCode->qualification_code ? 'selected' : '' }}>
                                                                    {{ $qualificationCode->qualification_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><?php */ ?>
                                    </div>

                                    <div id="div_workinfo" class="col-md-12">
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h3 class="card-title title-work-info">
                                                    {{ __('common.work_info') }}

                                                    <button type="button" id="btn-add-hist" data-add-url="{{ route('contract-teachers.work-histories.store', [app()->getLocale(), $contract_teacher->contstaff_payroll_id]) }}">
                                                        <i class="fa fa-plus"></i> @lang('button.add')
                                                    </button>
                                                </h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Start date -->
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="start_date">
                                                                <span class="section-num">{{ __('number.num6') }}.</span>
                                                                {{ __('common.start_date') }}
                                                            </label>

                                                            <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                                <input type="text" autocomplete="off" name="start_date" value="{{ (!empty($curpos) and $curpos->start_date > 0) ? date('d-m-Y', strtotime($curpos->start_date)) : '' }}" class="datepicker form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                                                <div class="input-group-addon">
                                                                    <span class="far fa-calendar-alt"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- End date -->
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="end_date">
                                                                <span class="section-num">{{ __('number.num7') }}.</span>
                                                                {{ __('common.end_date') }}
                                                            </label>

                                                            <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                                <input type="text" autocomplete="off" name="end_date" value="{{ (!empty($curpos) and $curpos->end_date > 0) ? date('d-m-Y', strtotime($curpos->end_date)) : null }}" class="datepicker form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                                                <div class="input-group-addon">
                                                                    <span class="far fa-calendar-alt"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contract teacher work histories -->
                                                @if( count($workHistories) > 0 )
                                                    @include('admin.contract_teachers.workhistory')
                                                @endif
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row-box">
                                            <h4>
                                                <span class="section-num">{{ __('number.num9') }}.</span>
                                                {{ __('common.current_address') }}
                                            </h4>

                                            <div class="row">
                                                <!-- House number -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="house_num">{{ __('common.house_number') }}</label>
                                                        <input type="text" name="house_num" value="{{ $contract_teacher->house_num }}" class="form-control" maxlength="8">
                                                    </div>
                                                </div>

                                                <!-- Group number -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="group_num">{{ __('common.group_number') }}</label>
                                                        <input type="text" name="group_num" value="{{ $contract_teacher->group_num }}" class="form-control" maxlength="10">
                                                    </div>
                                                </div>

                                                <!-- Street name or number -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="street_num">{{ __('common.street') }}</label>
                                                        <input type="text" name="street_num" value="{{ $contract_teacher->street_num }}" class="form-control kh" maxlength="50">
                                                    </div>
                                                </div>

                                                <!-- Province -->
                                                <?php /* ?><div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="adr_pro_code">{{ __('common.province') }}</label>

                                                        <select name="adr_pro_code" id="pro_code" class="form-control select2 kh" style="width:100%;">
                                                            <option value="">{{ __('common.choose') }} ...</option>

                                                            @foreach($provinces as $province)
                                                                <option value="{{ $province->pro_code }}" {{ $contract_teacher->adr_pro_code == $province->pro_code ? 'selected' : '' }}>
                                                                    {{ $province->name_kh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div><?php */ ?>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="adr_dis_code">{{ __('common.district') }}</label>

                                                        <select name="adr_dis_code" id="dis_code" class="form-control select2" style="width:100%;" disabled>
                                                            <option value="">{{ __('common.choose') }} ...</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="adr_com_code">{{ __('common.commune') }}</label>

                                                        <select name="adr_com_code" id="com_code" class="form-control select2" style="width:100%;" disabled>
                                                            <option value="">{{ __('common.choose') }} ...</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="adr_vil_code">{{ __('common.village') }}</label>

                                                        <select name="adr_vil_code" id="vil_code" class="form-control select2" style="width:100%;"​ disabled>
                                                            <option value="">{{ __('common.choose') }} ...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Phone number -->
                                                <div class="col-md-4">
                                                    <label for="phone">{{ __('common.telephone') }}</label>

                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                        </div>
                                                        <input type="text" name="phone" value="{{ $contract_teacher->phone }}" class="form-control" data-inputmask="'mask': ['999-999-9999', '+855 99 999 9999']" data-mask>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <table style="margin:auto;">
                                            <tr>
                                                <td style="padding:5px">
                                                    <a href="{{ route('contract-teachers.index', app()->getLocale()) }}" class="btn btn-danger btn-cancel" style="width:150px;">
                                                        <i class="far fa-times-circle"></i> @lang('button.cancel')
                                                    </a>
                                                </td>

                                                <td style="padding:5px">
                                                    <button type="submit" class="btn btn-info btn-save" style="width:150px;">
                                                        <i class="far fa-save"></i> {{ __('button.save') }}
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            {{ Form::close() }}

                            <!-- Modal work history -->
                            @include('admin.contract_teachers.modal_workhistory')

                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>

<input type="hidden" id="locationinfo" value="{{ $locations }}">

@endsection

@push('scripts')
    
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

    <!-- Validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>

        $(function() {

            $('[data-mask]').inputmask();

            $("#contract-teacher").addClass("menu-open");
            $("#contract-teacher-listing > a").addClass("active");
            $("#tab-detail").addClass("active");


            // Current location autocomplete
            var locations = JSON.parse($("#locationinfo").val());

            $("#location_kh").autocomplete({
                source: locations,
            });

            // CURRENT POSITION CHECKBOX
            $("#curpos").change(function() {
                var isChecked = $(this).is(":checked") ? true : false;
                //$("#end_date").prop("disabled", isChecked);
            });

            // Button save work history of modal
            $("#frmCreateWorkHistory").validate({
                rules: {
                    location_kh: "required",
                    position_id: "required",
                    start_date: "required",
                    end_date: {
                        required: true,
                        depends: function() {
                            return $("#curpos").is(":checked");
                        }
                    },
                },
                messages: {
                    location_kh: "{{ __('validation.required') }}",
                    position_id: "{{ __('validation.required') }}",
                    start_date: "{{ __('validation.required') }}",
                    end_date: "{{ __('validation.required') }}",
                },
                submitHandler: function(formCreateHist) {
                    $("#modalCreateWorkHistory").hide();
                    loadModalOverlay();

                    formCreateHist.submit();
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


            // Form submit
            $("#frmUpdateContTeacher").submit(function() {
                loadModalOverlay();
            });


            // Browse profile photo
            $("#profile_photo").change(function({target}) {
                readImageURL(this, "image-thumbnail");

                $("#profile-photo").removeClass("d-none");
                $(".upload-section").addClass("d-none");

                // Fixed issue for same image upload
                const files = target.files;
                target.value = '';
            });

            $("#btn-cancel-profile").click(function() {
                $("#profile-photo").addClass("d-none");
                $(".upload-section").removeClass("d-none");
            });

            // AUTO FILTER OF DISTRICT BY PROVINCE
            if( $("#pro_code").val() !== "" ) {

                $("#dis_code").empty();
                $("#dis_code").append('<option value="">ជ្រើសរើស ...</option>');

                var dis_code = "{{ $contract_teacher->adr_dis_code }}";

                $.ajax({
                    type: "GET",
                    url: "/api/provinces/" + $("#pro_code").val() + "/districts",
                    success: function (districts) {

                        for(var index in districts) {
                            $("#dis_code").append('<option value="'+districts[index].dis_code+'">'+ districts[index].name_kh +'</option>');

                            if( dis_code == districts[index].dis_code ) {
                                $("#select2-dis_code-container").text(districts[index].name_kh);
                                $("#dis_code option[value='"+dis_code+"']").prop("selected", true);
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });

                $("#dis_code").prop("disabled", false);
            }

            // AUTO FILTER OF COMMUNE BY DISTRICT
            if( dis_code !== "" ) {

                $("#com_code").empty();
                $("#com_code").append('<option value="">ជ្រើសរើស ...</option>');

                var com_code = "{{ $contract_teacher->adr_com_code }}";

                $.ajax({
                    type: "GET",
                    url: "/api/districts/" + dis_code + "/communes",
                    success: function (communes) {

                        for(var index in communes) {
                            $("#com_code").append('<option value="'+communes[index].com_code+'">'+ communes[index].name_kh +'</option>');

                            if( com_code == communes[index].com_code ) {
                                $("#select2-com_code-container").text(communes[index].name_kh);
                                $("#com_code option[value='"+com_code+"']").prop("selected", true);
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });

                $("#com_code").prop("disabled", false);
            }


            // AUTO FILTER OF VILLAGE BY COMMUNE
            if( com_code !== "" ) {

                $("#vil_code").empty();
                $("#vil_code").append('<option value="">ជ្រើសរើស ...</option>');

                var vil_code = "{{ $contract_teacher->adr_vil_code }}";

                $.ajax({
                    type: "GET",
                    url: "/api/communes/" + com_code + "/villages",
                    success: function (villages) {

                        for(var index in villages) {

                            $("#vil_code").append('<option value="'+villages[index].vil_code+'">'+ villages[index].name_kh +'</option>');

                            if( vil_code == villages[index].vil_code ) {
                                $("#select2-vil_code-container").text(villages[index].name_kh);
                                $("#vil_code option[value='"+vil_code+"']").prop("selected", true);
                            }
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });

                $("#vil_code").prop("disabled", false);
            }

            // ADD WORK HISTORY
            $("#btn-add-hist").click(function() {
                var addURL = $(this).data("add-url");

                $("#frmCreateWorkHistory").trigger("reset");
                $("#select2-position_id-container").text('ជ្រើសរើស ...');

                $("input[name='_method']").remove();
                $("#frmCreateWorkHistory").attr("action", addURL);
                $("#modalCreateWorkHistory").modal("show");
            });

            // Edit work history
            $(document).on("click", ".btn-edit", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (workhistory) {

                    $("#location_kh").val(workhistory.location_kh);

                    if( workhistory.position_id != null ) {
                        $("#position_id option[value='"+workhistory.position_id+"']").prop("selected", true);
                        $("#select2-position_id-container")
                            .text($("#position_id option[value='"+workhistory.position_id+"']").text());
                    } else {
                        $("#select2-position_id-container").text('ជ្រើសរើស ...');
                        $("#position_id").find("option").prop("selected", false);
                    }

                    $("#duty").val(workhistory.duty);
                    $("#annual_eval").val(workhistory.annual_eval);
                    $("#curpos").prop("checked", workhistory.curpos);
                    $("#start_date").val(workhistory.start_date);

                    $("input[name='_method']").remove();
                    $("#frmCreateWorkHistory").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateWorkHistory").prepend(putMethod);
                    $("#modalCreateWorkHistory").modal("show");
                });

            });

            // Remove work history
            $(document).on("click", ".btn-delete", function() {
                var deleteURL = $(this).data('delete-url');
                var deleted = confirm('Are you sure you want to remove this entry?');

                if( deleted ) {
                    var itemID = $(this).val();

                    $.ajax({
                        type: "DELETE",
                        url: deleteURL,
                        success: function (data) {
                            $("#record-" + itemID).remove();
                            
                            toastMessage("bg-success", "{{ __('validation.delete_success') }}");
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });

        });

    </script>

@endpush