@extends('layouts.admin')

@push('styles')
    <style>
        .form-group.has-error .select2 .select2-selection {
            border-color: #dc3545;
        }

        .table-student_number_info table th,
        .table-student_number_info table td {
            vertical-align: middle;
            padding: 5px;
        }
        .table-student_number_info table tbody tr:first-child td {
            color: #0a7698;
            font-weight: bold;
            font-size: 15px;
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
                    <i class="fa fa-file"></i> {{ __('menu.school_info') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fa fa-dashboard"></i>{{ __('menu.home') }}</a>
                    </li>
                    @if (isset($location))
                        <li class="breadcrumb-item active">{{ $location->{'location_'.app()->getLocale()} }}</li>
                    @endif
                    <li class="breadcrumb-item active">{{ isset($location) ? __('button.edit') : __('button.create_new') }}</li>
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

    @if (isset($location))
    {!! Form::model($location, ['route' => ['schools.update', [app()->getLocale(), $location->location_code]], 'method' => 'PUT', 'id' => 'location-form', 'enctype' => 'multipart/form-data']) !!}
    @else
    {!! Form::open(['route' => ['schools.store', app()->getLocale()], 'method' => 'POST', 'id' => 'location-form', 'enctype' => 'multipart/form-data']) !!}
    @endif

    <div class="card card-info card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ request()->has('year_id') ? '' : 'active' }}" id="custom-tabs-general_info-tab" data-toggle="pill"
                        href="#custom-tabs-general_info" role="tab"
                        aria-controls="custom-tabs-general_info"
                        aria-selected="true">{{ __('school.general_info') }}</a>
                </li>

                @if (isset($location) && $location->locationType && $location->locationType->is_school && $location->locationType->location_type_id != \App\Models\LocationType::University)
                <li class="nav-item school-block student-info-block">
                    <a class="nav-link {{ request()->has('year_id') ? 'active' : '' }}" id="custom-tabs-student_info-tab" data-toggle="pill"
                        href="#custom-tabs-student_info" role="tab" aria-controls="custom-tabs-student_info"
                        aria-selected="false">{{ __('school.student_info') }}</a>
                </li>
                @endif
            </ul>
        </div>
        <div class="card-body custom-card">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade {{ request()->has('year_id') ? '' : 'show active' }}" id="custom-tabs-general_info" role="tabpanel"
                    aria-labelledby="custom-tabs-general_info-tab">
                    @include('admin.schools.partials.general_info')
                </div>
                @if (isset($location) && $location->locationType && $location->locationType->is_school)
                <div class="school-block tab-pane fade {{ request()->has('year_id') ? 'show active' : '' }}" id="custom-tabs-student_info" role="tabpanel"
                    aria-labelledby="custom-tabs-student_info-tab">
                    @include('admin.schools.partials.student_info')
                </div>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <div class="col-md-12">
                <table style="margin: auto;">
                    <tr>
                       <td style="padding: 5px">
                            @if (isset($location))
                                <a href="{{ route('schools.edit', [app()->getLocale(), $location]) }}" class="btn btn-danger btn-cancel" style="width:150px;">
                                    <i class="fa fa-times"></i>&nbsp; {{__('button.cancel')}}
                                </a>
                            @else
                                <a href="{{ route('schools.create', app()->getLocale()) }}" class="btn btn-danger btn-cancel" style="width:150px;">
                                    <i class="fa fa-times"></i>&nbsp; {{__('button.cancel')}}
                                </a>
                            @endif
                        </td>
                        <td style="padding: 5px">
                            @if (!auth()->user()->hasRole('leader'))
                            <button type="submit" class="btn btn-info btn-save" style="width:150px;">
                                <i class="fa fa-save"></i>&nbsp;{{__('button.save')}}
                            </button>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    {{-- HIDDEN INPUT --}}
    <input type="hidden" id="editting" name="editting" value="{{isset($location)}}">
    <input type="hidden" id="model" name="model" value="{{ json_encode(isset($location) ? $location : '') }}">
    <input type="hidden" name="location_code" value="{{ isset($location) ? $location->location_code : null }}">
    <input type="hidden" id="under_moey_ids" name="under_moey_ids" value="{{ json_encode($underMoeyIds) }}">
    <input type="hidden" id="school_ids" name="school_ids" value="{{ json_encode($schoolIds) }}">
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/location.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(function() {
            $("#location-info").addClass("menu-open");
            $("#create-location > a").addClass("active");

            $('[data-mask]').inputmask();
            bsCustomFileInput.init();
        });
    </script>

    <script>
        var model = JSON.parse($("input:hidden[name='model']").val())
        var under_moey_location_type_ids = JSON.parse($("input:hidden[name='under_moey_ids']").val())
        var school_location_type_ids = JSON.parse($("input:hidden[name='school_ids']").val())

        var location_type = $("#custom-tabs-general_info select[name='location_type_id']")
        var school_in = $("#custom-tabs-general_info input[name='multi_level_edu']")
        var technical_school = $("#custom-tabs-general_info input[name='technical_school']")
        var school_annex = $("#custom-tabs-general_info input[name='school_annex']")
        var main_school = $("#custom-tabs-general_info select[name='main_school']")
        var claster_school = $("#custom-tabs-general_info select[name='claster_school']")
        var temporary_code = $("#custom-tabs-general_info input[name='temporary_code']")
        var resource_center = $("#custom-tabs-general_info input[name='resource_center']")
        var prokah = $("#custom-tabs-general_info input[name='prokah']")
        var prokah_num = $("#custom-tabs-general_info input[name='prokah_num']")
        var prokah_attachment = $("#custom-tabs-general_info input[name='prokah_attachment']")
        var pro_code = $('#custom-tabs-general_info select[name="pro_code"]');
        var dis_code = $('#custom-tabs-general_info select[name="dis_code"]');
        var com_code = $('#custom-tabs-general_info select[name="com_code"]');
        var vil_code = $('#custom-tabs-general_info select[name="vil_code"]');
        var location_pro_code = $('input[name="location_codes[pro_code]"]');
        var location_dis_code = $('input[name="location_codes[dis_code]"]');
        var location_com_code = $('input[name="location_codes[com_code]"]');
        var location_vil_code = $('input[name="location_codes[vil_code]"]');
        var location_emis_code = $('input[name="location_codes[emis_code]"]');
        var sub_location = $("#custom-tabs-general_info input[name='sub_location']")
        var gd_location_code = $("#custom-tabs-general_info select[name='gd_location_code']")
        var rttc_location_code = $("#custom-tabs-general_info select[name='rttc_location_code']")
        var pttc_location_code = $("#custom-tabs-general_info select[name='pttc_location_code']")
        var institute_location_code = $("#custom-tabs-general_info select[name='institute_location_code']")
        var location_province = $("#custom-tabs-general_info select[name='location_province']")
        var institute_equal_gd = $("#custom-tabs-general_info input[name='equal_gd']")

        var lang = $('html').attr('lang')
        var defaultOption = lang === 'en' ? '<option value="">Choose</option>' : '<option value="">ជ្រើសរើស</option>'

        const locationId = {
            gd: "{{ \App\Models\LocationType::GD }}",
            university: "{{ \App\Models\LocationType::University }}",
            department: "{{ \App\Models\LocationType::Department }}",
            institute: "{{ \App\Models\LocationType::Institute }}",
            rttc: "{{ \App\Models\LocationType::RTTC }}",
            pttc: "{{ \App\Models\LocationType::PTTC }}",
            pre_ttc: "{{ \App\Models\LocationType::PreTTC }}",
            practical_high_school: "{{ \App\Models\LocationType::PracticalHighSchool }}",
            practical_secondary_school: "{{ \App\Models\LocationType::PracticalSecondarySchool }}",
            practical_primary_school: "{{ \App\Models\LocationType::PracticalPrimarySchool }}",
            poe: "{{ \App\Models\LocationType::POE }}",
            doe: "{{ \App\Models\LocationType::DOE }}",
            high_school: "{{ \App\Models\LocationType::HighSchool }}",
            secondary_school: "{{ \App\Models\LocationType::SecondarySchool }}",
            ces: "{{ \App\Models\LocationType::CES }}",
            primary_school: "{{ \App\Models\LocationType::PrimarySchool }}",
            pre_school: "{{ \App\Models\LocationType::PreSchool }}",
            islam_school: "{{ \App\Models\LocationType::IslamSchool }}"
        }

        var locationType = {
            id: null,
            isUnderMoeys: false,
            isSchool: false,
            onChange: function () {
                locationType.init();
                locationType.resetCheckbox();
                locationType.toggleVisibleFields();
                locationType.toggleVisibleProvinceOptions();

                if (model) {
                    locationType.toggleVisibleStudentInfo();
                }

                if (locationType.id) {
                    locationType.toggleSchoolType()
                } else {
                    locationType.reset()
                }
            },
            init: function() {
                locationType.id = location_type.val();
                locationType.isUnderMoeys = under_moey_location_type_ids.includes(parseInt(location_type.val()));
                locationType.isSchool = school_location_type_ids.includes(parseInt(location_type.val()));
            },
            toggleVisibleFields: function () {
                $(".gd-field").addClass('d-none')
                $(".rttc-field").addClass('d-none')
                $(".pttc-field").addClass('d-none')
                $(".institute-field").addClass('d-none')
                $('.location-province-field').addClass('d-none')
                $('.equal-gd-field').addClass('d-none')

                // School
                if(locationType.isSchool) {
                    $(".school-block").removeClass('d-none')
                    if ([locationId.university, locationId.islam_school].includes(locationType.id)) {
                        $('.student-info-block').addClass('d-none')
                    }
                } else {
                    $(".school-block").addClass('d-none')
                    if (!prokah.is(':checked')) {
                        prokah.prop('checked', true).change()
                    }
                }

                // Under Moeys
                if(locationType.isUnderMoeys) {
                    $(".none-moey-block").addClass('d-none')
                    switch (locationType.id) {
                        case locationId.department:
                        case locationId.rttc:
                        case locationId.pttc:
                        case locationId.pre_ttc:
                            $('.gd-field').removeClass('d-none')
                            break;
                        case locationId.institute:
                            if (institute_equal_gd.is(':checked')) {
                                sub_location.prop('checked', false);
                                $(".gd-field").addClass('d-none')
                            } else {
                                $(".gd-field").removeClass('d-none')
                            }
                            break;
                        case locationId.practical_primary_school:
                            $('.pttc-field').removeClass('d-none')
                            break;
                        case locationId.practical_secondary_school:
                            $('.rttc-field').removeClass('d-none')
                            break;
                        case locationId.practical_high_school:
                            $('.institute-field').removeClass('d-none')
                            break;
                        default:

                            break;
                    }
                } else {
                    $('.province-field').removeClass('d-none')
                    $('.district-field').removeClass('d-none')
                    $('.commune-field').removeClass('d-none')
                    $('.village-field').removeClass('d-none')
                    switch (locationType.id) {
                        case locationId.poe:
                            $('.district-field').addClass('d-none')
                            $('.commune-field').addClass('d-none')
                            $('.village-field').addClass('d-none')
                            break;

                        case locationId.doe:
                            $('.commune-field').addClass('d-none')
                            $('.village-field').addClass('d-none')
                            break;
                        default:
                            $(".none-moey-block").removeClass('d-none')
                            break;
                    }
                }

                // Location Province
                if ([
                        locationId.university,
                        locationId.institute,
                        locationId.rttc,
                        locationId.pttc,
                        locationId.practical_high_school,
                        locationId.practical_secondary_school,
                        locationId.practical_primary_school
                    ].includes(locationType.id)
                ) {
                    $('.location-province-field').removeClass('d-none')
                }

                // Institute as university
                if (locationType.id == locationId.institute) {
                    $('.equal-gd-field').removeClass('d-none')
                }

            },
            toggleSchoolType: function () {
                if (locationType.id == locationId.high_school || locationType.id == locationId.primary_school) {
                    school_in.attr('disabled', false)

                    if (locationType.id == locationId.high_school) {
                        technical_school.attr('disabled', false)
                        school_annex.attr('disabled', true)

                        if (technical_school.attr('data-old-value')) {
                            technical_school.prop('checked', !!parseInt(technical_school.attr('data-old-value'))).trigger('change');
                            technical_school.attr('data-old-value', '')
                        }
                    }
                    else if (locationType.id == locationId.primary_school) {
                        school_annex.attr('disabled', false)
                        technical_school.attr('disabled', true)
                        if (school_annex.attr('data-old-value')) {
                            school_annex.prop('checked', !!parseInt(school_annex.attr('data-old-value'))).trigger('change');
                            school_annex.attr('data-old-value', '')
                        }
                    }

                    if (school_in.attr('data-old-value')) {
                        school_in.prop('checked', !!parseInt(school_in.attr('data-old-value'))).trigger('change');
                        school_in.attr('data-old-value', '')
                    }
                }
                else {
                    school_in.attr('disabled', true).trigger('change')
                    school_annex.attr('disabled', true).trigger('change')
                    technical_school.attr('disabled', true).trigger('change')
                }

                resource_center.attr('disabled', false).trigger('change')
                if([
                    locationId.university,
                    locationId.institute,
                    locationId.rttc,
                    locationId.pttc,
                    locationId.ces,
                    locationId.pre_school,
                    locationId.primary_school,
                    locationId.practical_primary_school,
                    locationId.islam_school,
                    ].includes(locationType.id)
                )
                {
                    resource_center.attr('disabled', true).trigger('change')
                }

                if ([]) {
                    $('.location-province-field')
                }
            },
            toggleVisibleProvinceOptions: function () {
                const provinces = pro_code.data('provinces')
                const keys = Object.keys(provinces)
                pro_code.prop("disabled", !location_type.val() || pro_code.data('disabled'));
                if (locationType.isUnderMoeys) {
                    pro_code.html(defaultOption)
                    keys.sort().forEach(function(key) {
                        if (key == '99') {
                            pro_code.append('<option value="'+key+'">'+ provinces[key] +'</option>');
                        }
                    })
                    pro_code.val(99).change()

                } else {
                    const selected = pro_code.val()
                    pro_code.html(defaultOption)
                    keys.sort().forEach(function(key) {
                        if (key != '99') {
                            pro_code.append('<option value="'+key+'">'+ provinces[key] +'</option>');
                        }
                    })
                    pro_code.val('').change();
                    if (selected != '99') {
                        pro_code.val(selected).change();
                    }
                }

            },
            setUpLocationCode: function () {
                var disabledEmisCode = locationType.isUnderMoeys || [locationId.poe, locationId.doe].includes(locationType.id)
                location_emis_code.prop('readonly', disabledEmisCode)

                if (locationType.isUnderMoeys) {
                    $('input[name="location_codes[dis_code]"]').val('16')
                    $('input[name="location_codes[com_code]"]').val('00')
                    $('input[name="location_codes[vil_code]"]').val('00')
                    $('input[name="location_codes[emis_code]"]').val('000')
                    if (!pro_code.val()) return

                    if (locationType.id == locationId.gd) {
                        locationType.setGeneralDepartmentCode()
                    }
                    else if (locationType.id == locationId.university) {
                        locationType.setGeneralDepartmentCode()
                    }
                    else if (locationType.id == locationId.institute) {
                        if (institute_equal_gd.is(':checked')) {
                            locationType.setGeneralDepartmentCode()
                        } else {
                            locationType.setDepartmentCode()
                        }
                    }
                    else if (locationType.id == locationId.department) {
                        locationType.setDepartmentCode()
                    }
                    else if (locationType.id == locationId.rttc) {
                        locationType.setDepartmentCode()
                    }
                    else if (locationType.id == locationId.pttc) {
                        locationType.setDepartmentCode()
                    }
                    else if (locationType.id == locationId.pre_ttc) {
                        locationType.setDepartmentCode()
                    }
                    else if (locationType.id == locationId.practical_primary_school)
                    {
                        locationType.setAnowatSchoolCode(pttc_location_code.val())
                    }
                    else if (locationType.id == locationId.practical_secondary_school)
                    {
                        locationType.setAnowatSchoolCode(rttc_location_code.val())
                    }
                    else if (locationType.id == locationId.practical_high_school)
                    {
                        locationType.setAnowatSchoolCode(institute_location_code.val())
                    }
                } else {
                    if (locationType.id == locationId.islam_school) {
                        location_emis_code.prop('readonly', true)
                        $('input[name="location_codes[emis_code]"]').val('499')
                    }
                }
            },
            setGeneralDepartmentCode() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: `/ajax/get-next-gd-increment`,
                    data: { location_code: model.location_code },
                    success: function (nextCount) {
                        $('input[name="location_codes[com_code]"]').val(nextCount)
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            },
            setDepartmentCode() {
                var cCode = '00'
                const gd_code = gd_location_code.val()
                if (gd_code) {
                    cCode = gd_code.substring(4, 6)
                }
                $('input[name="location_codes[com_code]"]').val(cCode)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: `/ajax/get-next-dep-increment`,
                    data: { gd_code, location_code: model.location_code },
                    success: function (nextCount) {
                        $('input[name="location_codes[vil_code]"]').val(nextCount)
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            },
            setAnowatSchoolCode(parentCode = '') {
                var cCode = '00'
                var vCode = '00'
                var eCode = '000'
                if(!parentCode) {
                    $('input[name="location_codes[com_code]"]').val(cCode)
                    $('input[name="location_codes[vil_code]"]').val(vCode)
                    $('input[name="location_codes[emis_code]"]').val(eCode)
                    return
                }
                cCode = parentCode.substring(4, 6)
                vCode = parentCode.substring(6, 8)
                // if ([locationId.practical_secondary_school, locationId.practical_primary_school].includes(locationType.id)) {
                //     vCode = cCode
                //     cCode = '00'
                // }
                $('input[name="location_codes[com_code]"]').val(cCode)
                $('input[name="location_codes[vil_code]"]').val(vCode)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: `/ajax/get-anowat-school-next-increment`,
                    data: { parent_code: parentCode, location_code: model.location_code },
                    success: function (nextCount) {
                        $('input[name="location_codes[emis_code]"]').val(nextCount)
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            },
            resetCheckbox: function() {
                sub_location.prop('checked', false).trigger('change');
                if (sub_location.attr('data-old-value')) {
                    sub_location.prop('checked', !!parseInt(sub_location.attr('data-old-value'))).trigger('change');
                    sub_location.attr('data-old-value', '')
                }

                prokah.prop('checked', false).trigger('change');
                school_in.prop('checked', false).trigger('change');
                school_annex.prop('checked', false).trigger('change')
                technical_school.prop('checked', false).trigger('change')
            },
            toggleVisibleStudentInfo() {
                let key = locationType.id
                if (locationType.id == locationId.practical_primary_school) {
                    key = locationId.primary_school
                } else if (locationType.id == locationId.practical_secondary_school) {
                    key = locationId.secondary_school
                } else if (locationType.id == locationId.practical_high_school) {
                    key = locationId.high_school
                }
                $(`.table-student_number_info tbody`).hide()
                $(`.table-student_number_info tbody.id_${key}`).show()
                locationType.sumStudentInfo();
            },
            sumStudentInfo() {
                const groups = $(`.table-student_number_info .group`);
                groups.each(function(index, group) {

                    let countStudent = 0
                    let countFemale = 0
                    let countClass = 0
                    const types = $(`.group.group-${index} tbody:not([style*="display: none"])`)
                    $(`.group.group-${index}`).toggle(!!types.length)
                    types.each(function(i, type) {
                        $(type).find('tr').each(function(j, tr) {
                            let inputStudent = $(tr).find("td:eq(1) input")
                            let inputFemale = $(tr).find("td:eq(2) input")
                            let inputClass = $(tr).find("td:eq(3) input")

                            if (inputStudent.length && Number.isInteger(parseInt(inputStudent.val()))) {
                                countStudent += parseInt(inputStudent.val())
                            }
                            if (inputFemale.length && Number.isInteger(parseInt(inputFemale.val()))) {
                                countFemale += parseInt(inputFemale.val())
                            }
                            if (inputClass.length && Number.isInteger(parseInt(inputClass.val()))) {
                                countClass += parseInt(inputClass.val())
                            }
                        })
                    })

                    $(`.group.group-${index} .total-table input[name='student_info[tstud_num]']`).val(countStudent)
                    $(`.group.group-${index} .total-table input[name='student_info[fstud_num]']`).val(countFemale)
                    $(`.group.group-${index} .total-table input[name='student_info[class_num]']`).val(countClass)
                })
            },
            reset: function() {
                $(".school-block").removeClass('d-none')
                $(".gd-field").addClass('d-none')

                pro_code.prop("disabled", true);
                school_annex.attr('disabled', true)
                school_in.attr('disabled', true)
                technical_school.attr('disabled', true)
                sub_location.prop('checked', false).trigger('change');
            },

        }

        $(document).ready(function() {

            // === On Change Events ===
            location_type.change(function(){
                locationType.onChange()
            });

            pro_code.change(function() {
                var value = this.value !== '' ? this.value : '00'
                $('input[name="location_codes[pro_code]"]').val(value)
                locationType.setUpLocationCode()
            })
            dis_code.change(function() {
                if ($('input[name="location_codes[pro_code]"]').val() == 99) return;

                var value = this.value !== '' ? this.value.slice(-2) : '00'
                $('input[name="location_codes[dis_code]"]').val(value)

                if (school_annex.is(':checked') && this.value) {
                    school_annex.trigger('change')
                }
            })
            com_code.change(function() {
                if ($('input[name="location_codes[dis_code]"]').val() == 16) {

                } else {
                    var value = this.value !== '' ? this.value.slice(-2) : '00'
                    $('input[name="location_codes[com_code]"]').val(value)
                }
            })
            vil_code.change(function() {
                var value = this.value !== '' ? this.value.slice(-2) : '00'
                $('input[name="location_codes[vil_code]"]').val(value)
            })

            temporary_code.change(function() {
                prokah.prop('checked', false).change()
                prokah.attr('disabled', this.checked)
            })

            prokah.change(function(){
                prokah_num.val('')
                prokah_num.attr('readonly', !this.checked)
                prokah_attachment.attr('disabled', !this.checked)
            })

            school_annex.change(function(){
                main_school.attr('disabled', !this.checked)
                main_school.prop("selectedIndex", 0).change()

                if (this.checked && dis_code.val()) {
                    fetchPrimarySchoolsByDisCode()
                }
            })

            school_in.change(function(){
                if (locationType.id === locationId.primary_school) { // Primary School
                    $(`.table-student_number_info tbody.id_${locationId.pre_school}`).toggle(this.checked)
                } else if (locationType.id === locationId.high_school) {  // High School
                    $(`.table-student_number_info tbody.id_${locationId.secondary_school}`).toggle(this.checked)
                }
                locationType.sumStudentInfo();
            })

            technical_school.change(function(){
                if (locationType.id === locationId.high_school) {  // High School
                    $(`.table-student_number_info tbody#technical_school`).toggle(this.checked)
                }
                locationType.sumStudentInfo();
            })

            sub_location.change(function(){
                gd_location_code.prop("selectedIndex", 0).change()
                gd_location_code.attr('disabled', !this.checked)
            })

            gd_location_code.change(function() {
                locationType.setUpLocationCode()
            })

            rttc_location_code.change(function() {
                locationType.setAnowatSchoolCode(rttc_location_code.val())
            })

            pttc_location_code.change(function() {
                locationType.setAnowatSchoolCode(pttc_location_code.val())
            })

            institute_location_code.change(function() {
                locationType.setAnowatSchoolCode(institute_location_code.val())
            })

            institute_equal_gd.change(function() {
                locationType.setUpLocationCode()
                locationType.toggleVisibleFields()
            })

            $(`.table-student_number_info tbody`).each(function(i, type) {
                $(type).find('input[type="number"]').change(function() {
                    locationType.sumStudentInfo();
                })
            })


            // === Methods ====
            function fetchPrimarySchoolsByDisCode() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var district = $('select[name="dis_code"]');
                var code = district.val() ? district.val() : district.attr('data-old-value')
                main_school.empty();
                main_school.html(defaultOption);
                $.ajax({
                    type: "GET",
                    url: `/schools/districts/${code}/primary`,
                    data: { location_code: $('input[name="location_code"]').val() },
                    success: function (locations) {
                        for(var index in locations) {
                            main_school.append('<option value="'+locations[index]['location_code']+'">'+ locations[index]['location_kh'] +'</option>');
                        }

                        if (main_school.attr('data-old-value')) {
                            main_school.val(main_school.attr('data-old-value'))
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
            // ===============
        })

        $(document).ready(function() {

            // === On Initialize === //
            prokah_num.attr('readonly', !prokah.is(':checked'))
            prokah_attachment.attr('disabled', !prokah.is(':checked'))
            main_school.attr('disabled', !school_annex.is(':checked'))
            gd_location_code.attr('disabled', !sub_location.is(':checked'))

            var eduLevel = $("#multilevel :selected").val();            

            locationType.init()
            locationType.toggleVisibleProvinceOptions()

            if (locationType.id) {
                locationType.toggleVisibleFields();
                if (model) {
                    locationType.toggleVisibleStudentInfo();
                }

                if (locationType.id == locationId.high_school || locationType.id === locationId.secondary_school || locationType.id == locationId.primary_school) {
                    //school_in.attr('disabled', false).trigger('change')

                    if (eduLevel == 1) {
                        if (locationType.id === locationId.primary_school) { // Primary School
                            $(`.table-student_number_info tbody.id_${locationId.pre_school}`).toggle(this.checked)
                        } else if (locationType.id === locationId.secondary_school) {  // High School
                            $(`.table-student_number_info tbody.id_${locationId.primary_school}`).toggle(this.checked)
                        
                        } else if (locationType.id === locationId.high_school) {  // High School
                            $(`.table-student_number_info tbody.id_${locationId.secondary_school}`).toggle(this.checked)
                        }
                        locationType.sumStudentInfo();
                    }
                    else if (eduLevel == 2) {
                        if (locationType.id === locationId.secondary_school) { // Primary School
                            $(`.table-student_number_info tbody.id_${locationId.pre_school}`).toggle(this.checked);
                            $(`.table-student_number_info tbody.id_${locationId.primary_school}`).toggle(this.checked);
                        } else if (locationType.id === locationId.high_school) {  // High School
                            $(`.table-student_number_info tbody.id_${locationId.primary_school}`).toggle(this.checked);
                            $(`.table-student_number_info tbody.id_${locationId.secondary_school}`).toggle(this.checked);
                        }
                        locationType.sumStudentInfo();
                    }
                    else if (eduLevel == 3) {
                            $(`.table-student_number_info tbody.id_${locationId.pre_school}`).toggle(this.checked);
                            $(`.table-student_number_info tbody.id_${locationId.primary_school}`).toggle(this.checked);                       
                            $(`.table-student_number_info tbody.id_${locationId.secondary_school}`).toggle(this.checked);
                    }
                        locationType.sumStudentInfo();
                    if (locationType.id == locationId.high_school) {
                        technical_school.attr('disabled', false).trigger('change')

                        school_annex.attr('disabled', true).change();
                    }
                    else if (locationType.id == locationId.primary_school) {
                        school_annex.attr('disabled', false).change()

                        technical_school.attr('disabled', true).trigger('change')
                    }
                }
                else {
                    school_in.attr('disabled', true).trigger('change')
                    technical_school.attr('disabled', true).trigger('change')
                    school_annex.attr('disabled', true).trigger('change')
                  
                }
            } else {
                school_annex.attr('disabled', true)
                school_in.attr('disabled', true)
                technical_school.attr('disabled', true)
            }

            // ===================== //
        })
    </script>

@endpush
