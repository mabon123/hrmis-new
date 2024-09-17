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
                                <form method="post" action="{{ route('families.store', [app()->getLocale(), $payroll_id]) }}" 
                                    id="frmCreateFamilyInfo">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row-box">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="maritalstatus_id" style="color:#0a7698;">
                                                                <strong>
                                                                   <span class="section-num"> {{ __('number.num12').'.' }}</span>
                                                                    {{ __('family_info.family_status') }}
                                                                </strong>
                                                            </label>

                                                            <select name="maritalstatus_id" id="maritalstatus_id" class="form-control select2" style="width:100%;">
                                                                <option value="">@lang('common.choose') ...</option>
                                                                
                                                                @foreach($maritalStatusInfo as $maritalStatus)
                                                                    <option value="{{ $maritalStatus->maritalstatus_id }}" {{ $staff->maritalstatus_id == $maritalStatus->maritalstatus_id ? 'selected' : '' }}>
                                                                        {{ $maritalStatus->maritalstatus_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">{{ __('family_info.spouse_name') }}</label>
                                                            <input type="text" name="spouse_name" id="spouse_name" value="{{ !empty($staffFamily) ? $staffFamily->fullname_kh : '' }}" class="form-control kh {{ $errors->has('spouse_name') ? 'is-invalid' : null }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="spouse_dob">{{ __('family_info.spouse_dob') }}</label>

                                                            <div class="input-group date" data-provide="datepicker"
                                                                data-date-format="dd/mm/yyyy">
                                                                <input type="text" autocomplete="off" name="spouse_dob" id="spouse_dob" value="{{ (!empty($staffFamily) and $staffFamily->dob > 0) ? date('d-m-Y', strtotime($staffFamily->dob)) : '' }}" class="datepicker form-control {{ $errors->has('spouse_dob') ? 'is-invalid' : null }}" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                                                <div class="input-group-addon">
                                                                    <span class="far fa-calendar-alt"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="hidden" name="staff_gender" value="{{ $staff->sex }}">
                                                        <div class="form-group @error('spouse_occupation') has-error @enderror">
                                                            <label for="spouse_occupation">@lang('family_info.spouse_occupation')</label>

                                                            <?php
                                                                $occupations = [
                                                                    'មន្រ្តីរាជការ' => 'មន្រ្តីរាជការ',
                                                                    'ក្រុមហ៊ុនឯកជន' => 'ក្រុមហ៊ុនឯកជន',
                                                                    'មេផ្ទះ' => 'មេផ្ទះ',
                                                                    'អាជីវករ' => 'អាជីវករ',
                                                                    'កសិករ' => 'កសិករ'
                                                                ];
                                                            ?>

                                                            {{ Form::select('spouse_occupation', ['' => __('common.choose').' ...'] + $occupations, (!empty($staffFamily) ? $staffFamily->occupation : null), ['id' => 'spouse_occupation', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div style="padding-top:38px" class="form-group clearfix">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" id="spouse_amount" name="spouse_amount" value="1" {{ (!empty($staffFamily) and $staffFamily->allowance == 1) ? 'checked' : '' }}>
                                                                <label for="spouse_amount">{{ __('family_info.spouse_amount') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="spouse_workplace">{{ __('family_info.spouse_unit') }}</label>

                                                            <input type="text" name="spouse_workplace" id="spouse_workplace" value="{{ !empty($staffFamily) ? $staffFamily->spouse_workplace : '' }}" class="form-control kh">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="spouse_phone">@lang('family_info.spouse_phone')</label>

                                                            <input type="text" name="spouse_phone" id="spouse_phone" value="{{ !empty($staffFamily) ? $staffFamily->phone_number : '' }}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-md-12">
                                                        <h6>{{ __('family_info.child_info') }}</h6>

                                                        <!-- Success message -->
                                                        <div id="child-success" class="alert alert-success d-none">
                                                            <span>Children information has been saved successfully.</span>
                                                            <button class="close" data-dismiss="alert" type="button">×</button>
                                                        </div>

                                                        <table class="table table-bordered table-head-fixed text-nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10px">#</th>
                                                                    <th>{{__('family_info.child_name')}}</th>
                                                                    <th>{{__('common.sex')}}</th>
                                                                    <th>{{__('common.dob')}}</th>
                                                                    <th>{{__('common.occupation')}}</th>
                                                                    <th class="text-center">{{__('family_info.amount')}}</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="child-body">

                                                                @foreach($childrens as $index => $children)

                                                                    <tr id="record-{{ $children->family_id }}">
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td class="kh">{{ $children->fullname_kh }}</td>
                                                                        <td class="kh">{{ $children->gender == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                                                        
                                                                        <td>{{ $children->dob > 0 ? date('d-m-Y', strtotime($children->dob)) : '' }}</td>
                                                                        
                                                                        <td class="kh">{{ $children->occupation }}</td>

                                                                        <td class="text-center">
                                                                            @if($children->allowance == 1)
                                                                                <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                                                            @else
                                                                                <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                                                            @endif
                                                                        </td>

                                                                        <td class="text-right">
                                                                            <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('childrens.edit', [app()->getLocale(), $staff->payroll_id, $children->family_id]) }}" data-update-url="{{ route('childrens.update', [app()->getLocale(), $staff->payroll_id, $children->family_id]) }}"><i class="far fa-edit"></i> @lang('button.edit')</button>

                                                                            <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $children->family_id }}" data-route="{{ route('childrens.destroy', [app()->getLocale(), $staff->payroll_id, $children->family_id]) }}"><i class="fas fa-trash-alt"></i> @lang('button.delete')</button>
                                                                        </td>
                                                                    </tr>

                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-md-12 text-right">
                                                        <button type="button" id="btn-add" class="btn btn-sm btn-primary" data-add-url="{{ route('childrens.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:180px;"><i class="fas fa-plus"></i> {{ __('button.addtolist') }}</button>
                                                    </div>
                                                </div>

                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 style="border-bottom:none;margin-bottom:15px;">
                                                            <span class="section-num">
                                                                {{ __('number.num13').'.' }}
                                                            </span>
                                                            {{ __('common.current_address') }}
                                                        </h4>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- House number -->
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label for="house_number">{{ __('common.house_number') }}</label>
                                                            <input type="text" name="house_number" id="house_number" value="{{ $staff->house_num }}" class="form-control" maxlength="8">
                                                        </div>
                                                    </div>

                                                    <!-- Group number -->
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label for="group_number">{{ __('common.group_number') }}</label>
                                                            <input type="text" name="group_number" id="group_number" value="{{ $staff->group_num }}" class="form-control" maxlength="10">
                                                        </div>
                                                    </div>

                                                    <!-- Street name or number -->
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="street">{{ __('common.street') }}</label>
                                                            <input type="text" name="street" id="street" value="{{ $staff->street_num }}" class="form-control kh" maxlength="50">
                                                        </div>
                                                    </div>

                                                    <!-- Province -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="adr_pro_code">{{ __('common.province') }}</label>

                                                            <select name="adr_pro_code" id="pro_code" class="form-control select2 kh" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>

                                                                @foreach($provinces as $province)
                                                                    <option value="{{ $province->pro_code }}" {{ $staff->adr_pro_code == $province->pro_code ? 'selected' : '' }}>
                                                                        {{ $province->name_kh }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="adr_dis_code">{{ __('common.district') }}</label>

                                                            <select name="adr_dis_code" id="dis_code" class="form-control select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="adr_com_code">{{ __('common.commune') }}</label>

                                                            <select name="adr_com_code" id="com_code" class="form-control select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="adr_vil_code">{{ __('common.village') }}</label>

                                                            <select name="adr_vil_code" id="vil_code" class="form-control select2" style="width:100%;">
                                                                <option value="">{{ __('common.choose') }} ...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Phone number -->
                                                    <div class="col-md-6">
                                                        <label for="phone_number">{{ __('common.telephone') }}</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                            </div>
                                                            <input type="text" name="phone_number" id="phone_number" value="{{ (isset($staff) and !empty($staff->phone)) ? $staff->phone : old('phone_number') }}" class="form-control" data-inputmask="'mask': ['999-999-9999', '+855 99 999 9999']" data-mask>
                                                        </div>
                                                    </div>

                                                    <!-- Email address -->
                                                    <div class="col-md-6">
                                                        <label for="email_address">{{ __('common.email') }}</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                            </div>
                                                            <input type="email" name="email_address" id="email_address" value="{{ $staff->email }}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <table style="margin: auto;">
                                                <tr>
                                                    <!-- <td style="padding:5px">
                                                        <button type="button" class="btn btn-danger btn-cancel" style="width:150px;">
                                                            <i class="far fa-times-circle"></i> {{__('button.cancel')}}
                                                        </button>
                                                    </td> -->

                                                    <td style="padding:5px">
                                                        <button type="submit" class="btn btn-info btn-save" style="width:150px;">
                                                            <i class="far fa-save"></i> {{ __('button.save') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </form>

                                <!-- Modal child info -->
                                @include('admin.staffs.modals.modal_child_info')
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

        function disableFamily() {
            //$("#relation_type_id").prop("disabled", true);
            $("#spouse_name").prop("disabled", true);
            $("#spouse_dob").prop("disabled", true);
            $("#spouse_occupation").prop("disabled", true);
            $("#spouse_workplace").prop("disabled", true);
            $("#spouse_unit").prop("disabled", true);
            $("#spouse_amount").prop("disabled", true);
            $("#spouse_phone").prop("disabled", true);
            $("#btn-add").prop("disabled", true);
        }

        function enableFamily() {
            //$("#relation_type_id").prop("disabled", false);
            $("#spouse_name").prop("disabled", false);
            $("#spouse_dob").prop("disabled", false);
            $("#spouse_occupation").prop("disabled", false);
            $("#spouse_workplace").prop("disabled", false);
            $("#spouse_unit").prop("disabled", false);
            $("#spouse_amount").prop("disabled", false);
            $("#spouse_phone").prop("disabled", false);
            $("#btn-add").prop("disabled", false);
        }
        
        $(function() {

            $('[data-mask]').inputmask();

            $("#staff-info").addClass("menu-open");
            $("#create-staff > a").addClass("active");
            $("#tab-family").addClass("active");

            // Form create family info event
            $('#frmCreateFamilyInfo').submit(function() {
                loadModalOverlay();
            });

            if( $("#maritalstatus_id").val() != 2 ) { disableFamily(); }
            else if( $("#maritalstatus_id").val() == 1 ) { $("#btn-add").prop("disabled", true); }

            
            // MARITAL STATUS EVENT
            $("#maritalstatus_id").change(function() {
                if( $(this).val() == 2 ) { enableFamily(); }
                else {
                    if ($(this).val() == 3 || $(this).val() == 4) {
                        $("#spouse_name").prop("disabled", true);
                        $("#spouse_dob").prop("disabled", true);
                        $("#spouse_occupation").prop("disabled", true);
                        $("#spouse_workplace").prop("disabled", true);
                        $("#spouse_unit").prop("disabled", true);
                        $("#spouse_amount").prop("disabled", true);
                        $("#spouse_phone").prop("disabled", true);
                        $("#btn-add").prop("disabled", false);
                    }
                    else { disableFamily(); }
                }
            });

            // EVENT ON SPOUSE OCCUPATION
            var spouseOccupation = $("#spouse_occupation").val();
            var staffGender = $('input[name="staff_gender"]').val();

            if (spouseOccupation == 'មន្រ្តីរាជការ' || staffGender == 2) {
                $("#spouse_amount").prop("checked", false);
                $("#spouse_amount").prop("disabled", true);
            }

            $("#spouse_occupation").change(function() {
                if ($(this).val() == "មន្រ្តីរាជការ" || staffGender == 2) {
                    $("#spouse_amount").prop("checked", false);
                    $("#spouse_amount").prop("disabled", true);
                }
                else {
                    $("#spouse_amount").prop("checked", true);
                    $("#spouse_amount").prop("disabled", false);
                }
            });


            // AUTO FILTER OF DISTRICT BY PROVINCE
            if( $("#pro_code").val() !== "" ) {

                $("#dis_code").empty();
                $("#dis_code").append('<option value="">ជ្រើសរើស ...</option>');

                var dis_code = "{{ $staff->adr_dis_code }}";

                $.ajax({
                    type: "GET",
                    url: "/provinces/" + $("#pro_code").val() + "/districts",
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

                var com_code = "{{ $staff->adr_com_code }}";

                $.ajax({
                    type: "GET",
                    url: "/districts/" + dis_code + "/communes",
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

                var vil_code = "{{ $staff->adr_vil_code }}";

                $.ajax({
                    type: "GET",
                    url: "/communes/" + com_code + "/villages",
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


            // SAVE CHILDREN INFO
            $("#btn-save-child").click(function(e) {
                //e.preventDefault();

                var ajaxURL = $("#frmCreateChild").attr("action");
                var childAmount = $("#allowance").is(":checked") ? 1 : 0;
                
                var custom_valid = false;

                if ($("#fullname_kh").val() == "") {
                    $("#fullname_kh").addClass("is-invalid");
                    $("#fullname_kh").closest('.form-group').append('<span id="fullname_kh-error" class="error invalid-feedback">សូមបំពេញពត៌មាននេះ</span>');

                    custom_valid = true;
                }

                if ($("#gender").val() == "") {
                    $("#gender").closest('.form-group').addClass("has-error");
                    $("#gender").closest('.form-group').append('<span id="gender-error" class="error invalid-feedback" style="display:block;">សូមបំពេញពត៌មាននេះ</span>');

                    custom_valid = true;
                }

                if ($("#dob").val() == "") {
                    $("#dob").addClass("is-invalid");
                    $("#dob").closest('.form-group').append('<span id="dob-error" class="error invalid-feedback" style="display:block;">សូមបំពេញពត៌មាននេះ</span>');

                    custom_valid = true;
                }

                if (!custom_valid) {
                    loadModalOverlay();
                    $('#modal-child-info').modal('hide');
                    $.ajax({
                        type: "POST",
                        url: ajaxURL,
                        data: {
                            fullname_kh: $("#fullname_kh").val(),
                            gender: $("#gender").val(),
                            dob: $("#dob").val(),
                            occupation: $("#occupation").val(),
                            allowance: childAmount,
                        },
                        success: function (familyInfo) {

                            if( familyInfo.allowance == 1 ) {
                                var allowance = '<i class="far fa-check-square" style="color:green;font-size:16px;"></i>';
                            } else {
                                var allowance = '<i class="far fa-window-close" style="color:red;font-size:16px;"></i>';
                            }

                            var editButton = '<button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="http://hrmis.moeys.gov.kh/kh/staffs/'+familyInfo.payroll_id+'/childrens/'+familyInfo.family_id+'/edit" data-update-url="http://hrmis.moeys.gov.kh/kh/staffs/'+familyInfo.payroll_id+'/childrens/'+familyInfo.family_id+'"><i class="far fa-edit"></i> កែប្រែ</button>';

                            var delButton = '<button type="button" class="btn btn-xs btn-danger btn-delete" value="'+familyInfo.family_id+'" data-route="http://hrmis.moeys.gov.kh/kh/staffs/'+familyInfo.payroll_id+'/childrens/'+familyInfo.family_id+'"><i class="fas fa-trash-alt"></i> លុបចេញ</button>';

                            $("#child-body").append("<tr id='record-"+familyInfo.family_id+"'>"+
                                                        "<td>"+(familyInfo.total_child + 1)+"</td>" +
                                                        "<td>"+familyInfo.fullname_kh+"</td>" +
                                                        "<td>"+(familyInfo.gender == 1 ? 'ប្រុស' : 'ស្រី')+"</td>" +
                                                        "<td>"+familyInfo.dob+"</td>" +
                                                        "<td>"+familyInfo.occupation+"</td>" +
                                                        "<td class='text-center'>"+allowance+"</td>" +
                                                        "<td class='text-right'>"+editButton + delButton+"</td>" +
                                                    "</tr>");

                            $("#modal-child-info").modal("hide");
                            $("#modal-overlay").modal("hide");

                            // Toast
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                autohide: true,
                                delay: 3000,
                                title: 'Success',
                                body: "{{ __('validation.add_success') }}",
                            });
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }

            });


            // CREATE NEW CHILDREN INFO
            $("#btn-add").click(function() {
                var addURL = $(this).data("add-url");

                $("#frmCreateChild").trigger("reset");
                $("#select2-gender-container").text('ជ្រើសរើស ...');

                $("input[name='_method']").remove();
                $("#frmCreateChild").attr("action", addURL);
                $("#modal-child-info").modal("show");
            });


            // EDIT CHILDREN INFO
            $(document).on("click", ".btn-edit", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function(familyInfo) {

                    // GENDER
                    $("#gender option[value='"+familyInfo.gender+"']").prop("selected", true);
                    $("#select2-gender-container").text($("#gender option[value='"+familyInfo.gender+"']").text());

                    $("#fullname_kh").val(familyInfo.fullname_kh);
                    $("#occupation").val(familyInfo.occupation);
                    $("#allowance").prop("checked", familyInfo.allowance);

                    if (familyInfo.dob != '') { $("#dob").val(familyInfo.dob); }

                    $("input[name='_method']").remove();
                    $("#frmCreateChild").attr("action", updateURL);
                    $("#btn-save-child").prop("type", "submit");
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateChild").prepend(putMethod);
                    $("#modal-child-info").modal("show");
                });

            });

        });

    </script>

@endpush
