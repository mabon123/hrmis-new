@extends('layouts.admin')

@push('styles')
    <style>
        .form-group.has-error .select2 .select2-selection {
            border-color: #dc3545;
        }
    </style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.trainee_teacher_info') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fa fa-dashboard"></i>{{ __('menu.home') }}</a>
                    </li>
                    @if (isset($trainee))
                        <li class="breadcrumb-item active">{{ $trainee->{'location_'.app()->getLocale()} }}</li>
                    @endif
                    <li class="breadcrumb-item active">{{ isset($trainee) ? __('button.edit') : __('button.create_new') }}</li>
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

    @if (isset($trainee))
    {!! Form::model($trainee, ['route' => ['trainees.update', [app()->getLocale(), $trainee->trainee_payroll_id]], 'method' => 'PUT', 'id' => 'trainee-teacher-form', 'enctype' => 'multipart/form-data']) !!}
    @else
    {!! Form::open(['route' => ['trainees.store', app()->getLocale()], 'method' => 'POST', 'id' => 'trainee-teacher-form', 'enctype' => 'multipart/form-data']) !!}
    @endif

    <div class="card card-info card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-trainee_teacher_info-tab" data-toggle="pill"
                        href="#custom-tabs-trainee_teacher_info" role="tab"
                        aria-controls="custom-tabs-trainee_teacher_info"
                        aria-selected="true">{{ __('menu.trainee_teacher_info') }}</a>
                </li>
            </ul>
        </div>
        <div class="card-body custom-card">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-trainee_teacher_info" role="tabpanel"
                    aria-labelledby="custom-tabs-trainee_teacher_info-tab">
                    @include('admin.trainee_teachers.partials.trainee_teacher_info')
                </div>
            </div>
        </div>

        @php
            $editable = auth()->user()->can('edit-trainee-teacher') && auth()->user()->is_ttc
                        && isset($trainee) && ($trainee->stu_generation != $currentGeneration || $trainee->trainee_status_id == \App\Models\TraineeStatus::Completed)
                            ? false
                            : true
        @endphp
        @if ($editable)
        <div class="card-footer">
            <div class="col-md-12">
                <table style="margin: auto;">
                    <tr>
                        <td style="padding: 5px">
                            <button type="submit" class="btn btn-info btn-save" style="width:150px;">
                                <i class="fa fa-save"></i>&nbsp;{{__('button.save')}}
                            </button>
                        </td>
                        @if (isset($trainee))
                        <td style="padding: 5px">
                            <a href="{{ route('trainees.index', app()->getLocale()) }}" class="btn btn-danger btn-cancel" style="width:150px;">
                                <i class="fa fa-times"></i>&nbsp; {{__('button.cancel')}}
                            </a>
                        </td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>
        @endif
    </div>

    {{ Form::close() }}

</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/location.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

    <script>
        $(function() {
            $("#trainee-teacher").addClass("menu-open");
            $("#create-trainee-teacher-menu > a").addClass("active");

            $('[data-mask]').inputmask();
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const isEditting = $('#action').val() == 'edit'
            const editable = !!parseInt($('#editable').val())

            var trainee_payroll_id = $("#custom-tabs-trainee_teacher_info input[name='trainee_payroll_id']")
            var nid_card = $("#custom-tabs-trainee_teacher_info input[name='nid_card']")
            var surname_kh = $("#custom-tabs-trainee_teacher_info input[name='surname_kh']")
            var name_kh = $("#custom-tabs-trainee_teacher_info input[name='name_kh']")
            var surname_en = $("#custom-tabs-trainee_teacher_info input[name='surname_en']")
            var name_en = $("#custom-tabs-trainee_teacher_info input[name='name_en']")
            var sex = $("#custom-tabs-trainee_teacher_info select[name='sex']")
            var dob = $("#custom-tabs-trainee_teacher_info input[name='dob']")
            var start_date = $("#custom-tabs-trainee_teacher_info input[name='start_date']")
            var end_date = $("#custom-tabs-trainee_teacher_info input[name='end_date']")

            var birth_pro_code = $("#custom-tabs-trainee_teacher_info select[name='birth_pro_code']")
            var birth_district = $("#custom-tabs-trainee_teacher_info input[name='birth_district']")
            var birth_commune = $("#custom-tabs-trainee_teacher_info input[name='birth_commune']")
            var birth_village = $("#custom-tabs-trainee_teacher_info input[name='birth_village']")

            var house_num = $("#custom-tabs-trainee_teacher_info input[name='house_num']")
            var group_num = $("#custom-tabs-trainee_teacher_info input[name='group_num']")
            var street_num = $("#custom-tabs-trainee_teacher_info input[name='street_num']")
            var adr_pro_code = $("#custom-tabs-trainee_teacher_info select[name='adr_pro_code']")
            var adr_dis_code = $("#custom-tabs-trainee_teacher_info select[name='adr_dis_code']")
            var adr_com_code = $("#custom-tabs-trainee_teacher_info select[name='adr_com_code']")
            var adr_vil_code = $("#custom-tabs-trainee_teacher_info select[name='adr_vil_code']")
            var phone = $("#custom-tabs-trainee_teacher_info input[name='phone']")

            var marital_status = $("#custom-tabs-trainee_teacher_info select[name='maritalstatus_id']")
            var fullname_kh = $("#custom-tabs-trainee_teacher_info input[name='fullname_kh']")
            var spouse_dob = $("#custom-tabs-trainee_teacher_info input[name='spouse_dob']")
            var spouse_occupation = $("#custom-tabs-trainee_teacher_info select[name='occupation']")
            var spouse_workplace = $("#custom-tabs-trainee_teacher_info input[name='spouse_workplace']")
            var spouse_phone = $("#custom-tabs-trainee_teacher_info input[name='spouse_phone']")

            var future_location_code = $("#custom-tabs-trainee_teacher_info select[name='future_location_code']")
            var future_pro_code = $("#custom-tabs-trainee_teacher_info select[name='future_pro_code']")
            var trainee_status = $("#custom-tabs-trainee_teacher_info select[name='trainee_status_id']")
            var former_staff = $("#custom-tabs-trainee_teacher_info input[name='former_staff']")
            var result = $("#custom-tabs-trainee_teacher_info input[name='result']")
            var year_id = $("#custom-tabs-trainee_teacher_info select[name='year_id']")
            var stu_generation = $("#custom-tabs-trainee_teacher_info select[name='stu_generation']")
            var trainee_status = $("#custom-tabs-trainee_teacher_info select[name='trainee_status_id']")
            var location_code = $("#custom-tabs-trainee_teacher_info select[name='location_code']")
            var prof_type_id = $("#custom-tabs-trainee_teacher_info select[name='prof_type_id']")
            var subject_id1 = $("#custom-tabs-trainee_teacher_info select[name='subject_id1']")
            var subject_id2 = $("#custom-tabs-trainee_teacher_info select[name='subject_id2']")
            const traineeStatus = {
                trainee: "{{ \App\Models\TraineeStatus::Trainee }}",
                deleted: "{{ \App\Models\TraineeStatus::Deleted }}",
                quit: "{{ \App\Models\TraineeStatus::Quit }}",
                postpone: "{{ \App\Models\TraineeStatus::Postpone }}",
                completed: "{{ \App\Models\TraineeStatus::Completed }}"
            }
            const locationType = {
                institute: "{{ \App\Models\LocationType::Institute }}",
                rttc: "{{ \App\Models\LocationType::RTTC }}",
                pttc: "{{ \App\Models\LocationType::PTTC }}",
                pre_ttc: "{{ \App\Models\LocationType::PreTTC }}",
            }
            const professionalType = {
                nie: "{{ \App\Models\ProfessionalType::NIE }}",
                nie2: "{{ \App\Models\ProfessionalType::NIE2 }}",
                rttc12_4: "{{ \App\Models\ProfessionalType::RTTC12_4 }}",
                rttc12_2: "{{ \App\Models\ProfessionalType::RTTC12_2 }}",
                pttc12_4: "{{ \App\Models\ProfessionalType::PTTC12_4 }}",
                pttc12_2: "{{ \App\Models\ProfessionalType::PTTC12_2 }}",
                rttc_pttc: "{{ \App\Models\ProfessionalType::PTTC_RTTC }}",
                central_kindergarten: "{{ \App\Models\ProfessionalType::CentralKindergarten }}",
            }

            // === On Change Events ===
            if (marital_status.val() === '') {
                setFamilyInput(true)
            }
            marital_status.change(function(){
                const disabled = parseInt(this.value) != 2
                setFamilyInput(disabled)
            })
            trainee_status.change(function(){
                onTraineeStatusChange()
            })
            result.change(function () {
                onResultChange()
            })
            former_staff.change(function () {

                if (this.checked) {
                    const staff = JSON.parse($('#staff').val())
                    if (staff) {
                        nid_card.val(staff.nid_card)
                        surname_kh.val(staff.surname_kh)
                        name_kh.val(staff.name_kh)
                        surname_en.val(staff.surname_en)
                        name_en.val(staff.name_en)
                        sex.val(staff.sex).change()
                        dob.val(moment(staff.dob, "YYYY-MM-DD").format('DD-MM-YYYY'))

                        birth_pro_code.val(staff.birth_pro_code).change()
                        birth_district.val(staff.birth_district)
                        birth_commune.val(staff.birth_commune)
                        birth_village.val(staff.birth_village)

                        house_num.val(staff.house_num)
                        group_num.val(staff.group_num)
                        street_num.val(staff.street_num)
                        adr_pro_code.val(staff.adr_pro_code).change()
                        adr_dis_code.attr('data-old-value', staff.adr_dis_code)
                        adr_com_code.attr('data-old-value', staff.adr_com_code)
                        adr_vil_code.attr('data-old-value', staff.adr_vil_code)
                        phone.val(staff.phone)

                        marital_status.val(staff.maritalstatus_id).change()
                        if (staff.spouse) {
                            fullname_kh.val(staff.spouse.fullname_kh)
                            spouse_phone.val(staff.spouse.phone_number)
                            spouse_dob.val(moment(staff.spouse.dob, "YYYY-MM-DD").format('DD-MM-YYYY'))
                            spouse_occupation.val(staff.spouse.occupation).change()
                            spouse_workplace.val(staff.spouse.spouse_workplace)
                        }
                    }
                }

            })

            trainee_payroll_id.change(function() {
                ajaxFindStaff()
            });

            year_id.change(function() {
                location_code.change()
            })
            location_code.change(function() {
                if (!$(this).val()) {
                    prof_type_id.prop('disabled', true)
                    prof_type_id.prop("selectedIndex", 0).change();
                    return
                }
                setTrainingInstitution()
            }).change()
            prof_type_id.change(function() {
                if (!$(this).val()) {
                    stu_generation.prop('disabled', true)
                    stu_generation.prop("selectedIndex", 0).change();
                    return
                }
                onInitializeGenerations()
            }).change()

            future_pro_code.change(function() {
                future_location_code.prop('disabled', !$(this).val())
                if (!$(this).val()) {
                    future_location_code.prop("selectedIndex", 0).change();
                    return
                }
                onLoadFutureLocations()
            }).change()

            // var timer = ''
            // trainee_payroll_id.bind("change keyup input",function() {
            //     clearTimeout(timer);
            //     timer = setTimeout(function() {
            //         ajaxFindStaff()
            //     }, 500);
            // });

            // If there is data value in the province dropdown of birth place, then auto
            // generate autocomplete data for commune & village
            if( $("#pro_code_autocomplete").attr("data-old-value") ) {
                $("#pro_code_autocomplete").trigger("change");
            }

            function setFamilyInput(disable = false) {
                fullname_kh.prop('disabled', disable)
                spouse_dob.prop('disabled', disable)
                spouse_occupation.prop('disabled', disable)
                spouse_workplace.prop('disabled', disable)
                spouse_phone.prop('disabled', disable)

                if (disable) {
                    fullname_kh.val('')
                    spouse_dob.val('')
                    spouse_occupation.val('')
                    spouse_workplace.val('')
                    spouse_phone.val('')
                }
            }

            function autoCompleteLocation() {
                var districts = JSON.parse($("#districtinfo").val());

                $("#birth_district").autocomplete({
                    source: districts
                });
            }

            function onTraineeStatusChange() {
                var value = trainee_status.val()
                if (value == traineeStatus.trainee ) {
                    if (isEditting) {
                        var checked = $('#result').attr('data-current-value')
                        checked = typeof checked == 'undefined' ? true : !!parseInt(checked)
                        result.prop('checked', checked).change()
                        $('#result').val(1)
                        $('#result').attr('disabled', false)
                    } else {
                        result.prop('checked', true).change()
                        result.val(1)
                        $('#result').attr('disabled', true)
                    }
                } else if (value == traineeStatus.completed) {
                    result.prop('checked', true).change()
                    result.val(1)
                    $('#result').attr('disabled', true)
                } else {
                    result.prop('checked', false).change()
                    result.val(0)
                    $('#result').attr('disabled', true)
                }
                $('#result').removeAttr('data-current-value')
            }

            function onResultChange() {
                if (result.is(':checked')) {
                    result.parent().find('.result-label').removeClass('text-danger');
                } else {
                    result.parent().find('.result-label').addClass('text-danger');
                }
            }

            function onInitializeGenerations() {
                $.ajax({
                    type: "GET",
                    url: `/ajax/get-trainee-academic-generations`,
                    data: { year_id: year_id.val(), prof_type_id: prof_type_id.val() },
                    success: function (data) {
                        const generations = Object.values(data)
                        var lang = $('html').attr('lang')
                        var defaultOption = lang === 'en' ? '<option value="">Choose</option>' : '<option value="">ជ្រើសរើស</option>'
                        stu_generation.prop('disabled', !editable)
                        stu_generation.html(defaultOption)
                        generations.sort().reverse().forEach(function(value) {
                            stu_generation.append('<option value="'+value+'">'+ value +'</option>');
                        })
                        stu_generation.val(generations[0]).change();
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }

            function onTrainingInstituteChange() {
                var location_type_id = location_code.attr('data-location_type_id')
                var enableSubjectSelection = [locationType.institute, locationType.rttc].includes(location_type_id)

                subject_id1.prop("disabled", !enableSubjectSelection || !editable);
                subject_id2.prop("disabled", !enableSubjectSelection || !editable);

                var profTypes = []
                if (location_type_id == locationType.institute) {
                    // profTypes = [professionalType.nie, professionalType.nie2, professionalType.rttc12_2, professionalType.rttc12_4]
                    profTypes = Object.values(professionalType)
                } else if (location_type_id == locationType.rttc) {
                    profTypes = [professionalType.rttc12_2, professionalType.rttc12_4, professionalType.rttc_pttc]
                } else if (location_type_id == locationType.pttc) {
                    profTypes = [professionalType.pttc12_2, professionalType.pttc12_4]
                } else if (location_type_id == locationType.pre_ttc) {
                    profTypes = [professionalType.central_kindergarten]
                }

                const professionalTypes = prof_type_id.data('professional_types')
                const keys = Object.keys(professionalTypes)
                var lang = $('html').attr('lang')
                var defaultOption = lang === 'en' ? '<option value="">Choose</option>' : '<option value="">ជ្រើសរើស</option>'
                var selected = prof_type_id.val()
                prof_type_id.prop('disabled', !location_code.val() || !location_type_id || !editable)
                prof_type_id.html(defaultOption)
                keys.sort().forEach(function(key) {
                    if (profTypes.includes(key)) {
                        prof_type_id.append('<option value="'+key+'">'+ professionalTypes[key] +'</option>');
                    }
                })
                if (prof_type_id.find(`option[value="${selected}"]`).val() === undefined) {
                    prof_type_id.prop("selectedIndex", 0).change();
                } else {
                    prof_type_id.val(selected).change();
                }
            }

            function ajaxFindStaff() {
                staff = null;
                $.ajax({
                    type: "GET",
                    url: `/ajax/find-staff-by-payroll`,
                    data: { payroll: trainee_payroll_id.val() },
                    success: function (staff) {
                        if (staff) {
                            $('#staff').val(JSON.stringify(staff))
                            trainee_payroll_id.addClass('is-invalid').attr('aria-describedby', 'trainee_payroll_id-error')
                            if (trainee_payroll_id.parent('.form-group').find('#trainee_payroll_id-error').length) {
                                trainee_payroll_id
                                    .parent('.form-group')
                                    .find('#trainee_payroll_id-error')
                                    .html('{{ __("trainee.is_staff_msg") }}')
                                    .css('display', 'block')
                            } else {
                                trainee_payroll_id
                                    .parent('.form-group')
                                    .append(
                                        '<span id="trainee_payroll_id-error" class="error invalid-feedback">{{ __("trainee.is_staff_msg") }}</span>'
                                    )
                            }
                            former_staff.prop('checked', false).prop('disabled', false).change()
                        } else {
                            former_staff.prop('checked', false).prop('disabled', true).change()
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }

            function setTrainingInstitution() {
                $.ajax({
                    type: "GET",
                    url: `/ajax/get-location`,
                    data: { location_code: location_code.val() },
                    success: function (location) {
                        location_code.attr('data-location_code', '')
                        location_code.attr('data-location_type_id', '')
                        if (location) {
                            location_code.attr('data-location_code', location.location_code)
                            location_code.attr('data-location_type_id', location.location_type_id)

                            onTrainingInstituteChange()
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }

            function onLoadFutureLocations() {
                $.ajax({
                    type: "GET",
                    url: `/ajax/get-future-locations`,
                    data: { pro_code: future_pro_code.val() },
                    success: function (locations) {
                        var lang = $('html').attr('lang')
                        var defaultOption = lang === 'en' ? '<option value="">Choose</option>' : '<option value="">ជ្រើសរើស</option>'
                        future_location_code.html(defaultOption)
                        locations.forEach(function(location) {
                            future_location_code.append('<option value="'+location.location_code+'">'+ location.location_province +'</option>');
                        })

                        console.warn(future_location_code.data('old-value'))
                        if (future_location_code.data('old-value')) {
                            future_location_code.val(future_location_code.data('old-value')).change()
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }

            // Validation
            $("#trainee-teacher-form").validate({
                rules: {
                    trainee_payroll_id: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    surname_kh: "required",
                    name_kh: "required",
                    surname_en: "required",
                    name_en: "required",
                    trainee_status_id: "required",
                    sex: "required",
                    dob: "required",
                    birth_pro_code: "required",
                    birth_district: "required",
                    maritalstatus_id: "required",
                    year_id: 'required',
                    stu_generation: 'required',
                    fullname_kh: {
                        required: function () { return $('#maritalstatus_id').val() == 2 }
                    },
                    future_pro_code: 'required',
                    future_location_code: 'required',
                    location_code: 'required',
                    prof_type_id: 'required',
                    subject_id1: 'required',
                    start_date: 'required',
                    end_date: {
                        required: true,
                    }
                },
                messages: {
                    trainee_payroll_id: {
                        required: "{{ __('validation.required_field', ['attribute' => __('common.payroll_num')]) }}",
                        minlength: "{{ __('validation.min.string', ['attribute' => __('common.payroll_num'), 'min' => 10]) }}",
                        maxlength: "{{ __('validation.max.string', ['attribute' => __('common.payroll_num'), 'max' => 10]) }}",
                    },
                    surname_kh: "{{ __('validation.required_field', ['attribute' => __('common.surname_kh')]) }}",
                    name_kh: "{{ __('validation.required_field', ['attribute' => __('common.name_kh')]) }}",
                    surname_en: "{{ __('validation.required_field', ['attribute' => __('common.surname_latin')]) }}",
                    name_en: "{{ __('validation.required_field', ['attribute' => __('common.name_latin')]) }}",
                    trainee_status_id: "{{ __('validation.required_field', ['attribute' => __('common.current_status')]) }}",
                    sex: "{{ __('validation.required_field', ['attribute' => __('common.sex')]) }}",
                    dob: "{{ __('validation.required_field', ['attribute' => __('common.dob')]) }}",
                    birth_pro_code: "{{ __('validation.required_field', ['attribute' => __('common.province')]) }}",
                    birth_district: "{{ __('validation.required_field', ['attribute' => __('common.district')]) }}",
                    maritalstatus_id: "{{ __('validation.required_field', ['attribute' => __('family_info.family_status')]) }}",
                    fullname_kh: "{{ __('validation.required_field', ['attribute' => __('family_info.spouse_name')]) }}",
                    year_id: "{{ __('validation.required_field', ['attribute' => __('common.year')]) }}",
                    stu_generation: "{{ __('validation.required_field', ['attribute' => __('trainee.stu_generation')]) }}",
                    future_pro_code: "{{ __('validation.required_field', ['attribute' => __('common.province')]) }}",
                    future_location_code: "{{ __('validation.required_field', ['attribute' => __('trainee.future_location')]) }}",
                    location_code: "{{ __('validation.required_field', ['attribute' => __('qualification.training_institution')]) }}",
                    prof_type_id: "{{ __('validation.required_field', ['attribute' => __('qualification.training_sys')]) }}",
                    subject_id1: "{{ __('validation.required_field', ['attribute' => __('qualification.first_subject')]) }}",
                    start_date: "{{ __('validation.required_field', ['attribute' => __('common.start_date')]) }}",
                    end_date: "{{ __('validation.required_field', ['attribute' => __('common.end_date')]) }}",
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

            // On Init
            onTraineeStatusChange()
            onResultChange()
            autoCompleteLocation()
            setFamilyInput(parseInt(marital_status.val()) != 2)
            if (!editable) {
                $('input').prop('disabled', true)
                $('select').prop('disabled', true)
            }

            // Browse profile photo
            $("#profile_photo").on("change", function({target}) {
                readImageURL(this, "image-thumbnail");

                $("#profile-photo-sec").removeClass("d-none");
                $(".upload-section").addClass("d-none");
            });

            $("#btn-cancel-profile").click(function() {
                $("#profile-photo-sec").addClass("d-none");
                $(".upload-section").removeClass("d-none");
                $("#profile_photo_asset").val("");
            });
        })
    </script>

@endpush
