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
                                            <span class="section-num">{{ __('number.num8').'. ' }}</span>
                                            {{ __('common.general_knowledge') }}
                                        </h4>

                                        <h6 style="margin-top:20px;margin-bottom:20px;">
                                            {{ __('common.highest_knowledge') }}: 
                                            <strong class="kh">{{ !empty($highestKnowledge) ? $highestKnowledge->qualification_kh : '' }}</strong>
                                        </h6>

                                        <table class="table table-bordered table-head-fixed text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>{{__('common.qualification')}}</th>
                                                    <th>{{__('common.skill')}}</th>
                                                    <th>{{__('common.date_obtained')}}</th>
                                                    <th>{{__('common.country')}}</th>
                                                    <th>{{ __('common.development_school') }}</th>
                                                    <th>@lang('common.prokah_attachment')</th>
                                                    <th>សំណើដំឡើងថ្នាក់</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                    @php
                                                        $request_cardre = isset($staff->lastCardre) ? $staff->lastCardre->salary_level_id.'.'.$staff->lastCardre->salary_degree : 0; 
                                                        $professional_12 = [9,12,13,14,16,17,19,30];
                                                        $professional_14 = [10,11,15];
                                                        $qualificaition_12 = [9,11,12,13];
                                                        $qualificaition_14 = [11,12,13];
                                                        $request_cardre_check_status = 0;
                                                        $higher_salary_type_shift_date = (isset($staff->lastCardre) and $staff->lastCardre->salary_type_shift_date > 0) ? ((int) \Carbon\Carbon::createFromFormat('Y-m-d', $staff->lastCardre->salary_type_shift_date)->format('Y')) : (int)date('Y');
                                                        $highest_none_request_cardre = ($request_cardre == "1.១" ||$request_cardre == "4.១" || $request_cardre == "7.១" || $request_cardre == "8.១" || $request_cardre == "9.១" || $request_cardre_status) ? 0 : 1;
                                                    @endphp

                                                @foreach($knowledges as $index => $knowledge)

                                                    <tr id="record-{{$knowledge->qual_id}}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="kh">{{ $knowledge->qualificationCode->qualification_kh }}</td>
                                                        <td class="kh">{{ !empty($knowledge->subject) ? $knowledge->subject->subject_kh : '---' }}</td>

                                                        <td>{{ $knowledge->qual_date > 0 ? date('d-m-Y', strtotime($knowledge->qual_date)) : '' }}</td>
                                                        
                                                        <td class="kh">{{ !empty($knowledge->country) ? $knowledge->country->country_kh : '---' }}</td>

                                                        <td class="kh">{{ !empty($knowledge->location_kh) ? $knowledge->location_kh : '---' }}</td>
                                                        
                                                        <td>
                                                            @php
                                                                if(isset($staff->highestPrefession[0])){
                                                                    if(in_array($staff->highestPrefession[0]->prof_category_id, $professional_12) && in_array($knowledge->qualification_code, $qualificaition_12) && $knowledge->request_cardre_check_status == NULL && (int)date('Y') > $higher_salary_type_shift_date && $highest_none_request_cardre == 1){
                                                                        $request_cardre_check_status = 1;
                                                                    }else if(in_array($staff->highestPrefession[0]->prof_category_id, $professional_14) && in_array($knowledge->qualification_code, $qualificaition_14) && $knowledge->request_cardre_check_status == NULL && (int)date('Y') > $higher_salary_type_shift_date && $highest_none_request_cardre == 1){
                                                                        $request_cardre_check_status = 1;
                                                                    }else{
                                                                        $request_cardre_check_status = 0;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if (!empty($knowledge->qual_doc))
                                                                @if (File::exists('storage/pdfs/ref_documents/'.'qual_'.$staff->payroll_id.'_'.$knowledge->qual_id.'.pdf'))
                                                                    <a href="{{ asset('storage/pdfs/ref_documents/'.$knowledge->qual_doc) }}" target="_blank"><u>@lang('common.view_file')</u></a>
                                                                @endif
                                                            @endif
                                                        </td>

                                                        <td>                

                                                            @if ($request_cardre_check_status == 1 && (Auth::user()->hasRole('school-admin', 'dept-admin') || Auth::user()->work_place->location_code == request()->location_code || Auth::user()->hasRole('poe-admin') || Auth::user()->hasRole('central-admin') || Auth::user()->payroll_id == 1851200246))
                                                                <a href="{{ route('requestCardre.ByCertification', [app()->getLocale(), $staff->payroll_id, $knowledge->qual_id]) }}" class="btn btn-xs btn-info"><i class="far fa-edit"></i> បញ្ជូន</a>
                                                            @endif     
                                                            @if ($knowledge->request_cardre_check_status == 1 && (Auth::user()->hasRole('poe-admin') || Auth::user()->hasRole('central-admin') || Auth::user()->payroll_id == 1851200246))        
                                                                <a href="{{ route('requestCardre.ByCertificationUndo', [app()->getLocale(), $staff->payroll_id, $knowledge->qual_id]) }}" class="btn btn-xs btn-success"><i class="fa fa-undo"></i> បានបញ្ជូន</a>
                                                            @elseif($knowledge->request_cardre_check_status == 1)
                                                                <span class="btn-xxs btn-info" style="padding: 2px 6px; border-radius: 2px; font-size: 12px;">បានបញ្ជូន</span>
                                                            @elseif($knowledge->request_cardre_check_status == 5)
                                                                <span class="btn-xxs btn-success" style="padding: 2px 6px; border-radius: 2px; font-size: 12px;">បានឯកភាព</span>
                                                            @endif 
                                                                                                            
                                                        </td>

                                                        <td class="text-right">
                                                            <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('general-knowledge.edit', [app()->getLocale(), $staff->payroll_id, $knowledge->qual_id]) }}" data-update-url="{{ route('general-knowledge.update', [app()->getLocale(), $staff->payroll_id, $knowledge->qual_id]) }}"><i class="far fa-edit"></i> @lang('button.edit')</button>

                                                            <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('general-knowledge.destroy', [app()->getLocale(), $staff->payroll_id, $knowledge->qual_id]) }}"><i class="fas fa-trash-alt"></i> @lang('button.delete')</button>
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-add" data-add-url="{{ route('general-knowledge.store', [app()->getLocale(), $staff->payroll_id]) }}" style="width:220px;"><i class="fas fa-plus"></i> {{ __('button.addtolist') }}</button>
                                    </div>

                                    <!-- Modal create new short course -->
                                    @include('admin.staffs.modals.modal_gen_knowledge')
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
            $("#tab-knowledge").addClass("active");

            // Validation
            $("#frmCreateGenKnowledge").validate({
                rules: {
                    qualification_code: "required",
                    qual_date: "required",
                },
                messages: {
                    qualification_code: "{{ __('validation.required_field') }}",
                    qual_date: "{{ __('validation.required_field') }}",
                },
                submitHandler: function(frm) {
                    $("#modal-gen-knowledge").hide();
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

            // Qualification event
            $("#qualification_code").change(function() {
                $("#skill_req").addClass("d-none");
                $("#subject-group").removeClass("has-error");

                if ($(this).val() != "") {
                    $.ajax({
                        type: "GET",
                        url: "/gen-knowledge/" + $(this).val() + "/ranks",
                        success: function (qual_hierachy) {
                            if (qual_hierachy > 7) {
                                $("#skill_req").removeClass("d-none");
                                $("#subject_id").prop("required", true);
                                $("#subject-group").addClass("has-error");
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });
                }
            });

            $("#subject_id").change(function() {
                if ($(this).val() != "") { $("#subject-group").removeClass("has-error"); }
            });

            // CREATE NEW GENERAL KNOWLEDGE
            $("#btn-add").click(function() {
                var addURL = $(this).data("add-url");

                $("#frmCreateGenKnowledge").trigger("reset");
                $("#select2-qualification_code-container").text('ជ្រើសរើស ...');
                $("#select2-subject_id-container").text('ជ្រើសរើស ...');
                $("#select2-country_id-container").text('ជ្រើសរើស ...');

                $("input[name='_method']").remove();
                $("#frmCreateGenKnowledge").attr("action", addURL);
                $("#modal-gen-knowledge").modal("show");
            });


            // EDIT GEN KNOWLEDGE
            $(document).on("click", ".btn-edit", function() {

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function(knowledge) {

                    $("#qualification_code option[value='"+knowledge.qualification_code+"']").prop("selected", true);
                    $("#select2-qualification_code-container")
                        .text($("#qualification_code option[value='"+knowledge.qualification_code+"']").text());

                    // SUBJECT
                    if( knowledge.subject_id != null ) {
                        $("#subject_id option[value='"+knowledge.subject_id+"']").prop("selected", true);
                        $("#select2-subject_id-container")
                            .text($("#subject_id option[value='"+knowledge.subject_id+"']").text());
                    } else {
                        $("#select2-subject_id-container").text('ជ្រើសរើស ...');
                        $("#subject_id").find("option").prop("selected", false);
                    }

                    // COUNTRY
                    if( knowledge.country_id != null ) {
                        $("#country_id option[value='"+knowledge.country_id+"']").prop("selected", true);
                        $("#select2-country_id-container")
                            .text($("#country_id option[value='"+knowledge.country_id+"']").text());
                    } else {
                        $("#select2-country_id-container").text('ជ្រើសរើស ...');
                        $("#country_id").find("option").prop("selected", false);
                    }

                    if (knowledge.qual_date != '') { $("#qual_date").val(knowledge.qual_date); }
                    $("#location_kh").val(knowledge.location_kh);

                    $("input[name='_method']").remove();
                    $("#frmCreateGenKnowledge").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateGenKnowledge").prepend(putMethod);
                    $("#modal-gen-knowledge").modal("show");
                });

            });

        });

    </script>

@endpush
