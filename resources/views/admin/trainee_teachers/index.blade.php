@extends('layouts.admin')
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
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('menu.trainee_teacher_info') }}</li>
                    <li class="breadcrumb-item active">{{ __('menu.trainee_teacher_list') }}</li>
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

    <form id="frmSearchStaff" action="{{ route('trainees.index', app()->getLocale()) }}">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('trainee.search_trainee_teachers') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <input type="hidden" name="search" value="true">

                        <div class="row">

                            <!-- Training Institute -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="location_code">{{ __('qualification.training_institution') }}</label>
                                    {{ Form::select(
                                        'location_code',
                                        ['' => __('common.choose')] + $locations,
                                        request()->location_code ?? (auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttc ? auth()->user()->work_place->location_code : null),
                                        [
                                            "class" => "form-control kh select2",
                                            'id' => 'location_code',
                                            'style' => 'width:100%;',

                                        ])
                                    }}
                                </div>
                            </div>

                            <!-- Training System -->
                            <div class="col-sm">
                                <div class="form-group">
                                   <label for="prof_type_id">{{ __('qualification.training_sys') }}</label>
                                    {{ Form::select(
                                        'prof_type_id',
                                        ['' => __('common.choose')] + $professionalTypes,
                                        request()->prof_type_id,
                                        [
                                            'id' => 'prof_type_id',
                                            "class" => "form-control select2",
                                            'style' => 'width:100%;',
                                            'data-professional_types' => json_encode($professionalTypes),
                                            'disabled' => !request()->location_code,
                                        ])
                                    }}
                                </div>
                            </div>

                            <!-- Student Generation -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="stu_generation">{{ __('trainee.stu_generation') }}</label>
                                    {{ Form::select(
                                        'stu_generation',
                                        ['' => __('common.choose').' ...'],
                                        request()->get('stu_generation'),
                                        [
                                            'id' => 'stu_generation',
                                            'class' => 'form-control kh select2',
                                            'style' => 'width:100%;',
                                            'disabled' => !request()->prof_type_id,
                                        ])
                                    }}
                                </div>
                            </div>


                            <!-- Staff status -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="trainee_status_id">{{ __('common.current_status') }}</label>

                                    {{ Form::select('trainee_status_id', ['' => __('common.choose').' ...'] + $statuses, request()->get('trainee_status_id'), ['id' => 'trainee_status_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Filter by -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_by">{{ __('common.filter_by') }}</label>
                                    {{ Form::select('filter_by', $filters, request()->filter_by, ['class' => 'form-control kh select2', 'style' => 'width:100%;', 'id' => 'filter_dropdown']) }}
                                </div>
                            </div>

                            <!-- Search keyword -->
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="keyword">{{__('common.filter_value')}}</label>

                                    {{ Form::text('keyword', request()->keyword, ['id' => 'keyword', 'class' => 'form-control kh', 'autocomplete' => 'off']) }}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('trainees.index', [app()->getLocale()]) }}" class="btn btn-danger" style="width:160px;">
                            <i class="fa fa-undo"></i>&nbsp;{{ __('button.reset') }}
                        </a>

                        <button type="submit" class="btn btn-info" style="width:180px;">
                            <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                        </button>
                        @if(auth()->user()->can('edit-trainee-teacher') && auth()->user()->is_ttc)
                            <button
                                id="btnOpenTransferModal"
                                type="button"
                                class="btn btn-primary"
                                style="width:250px;"
                                {{ !count($trainees) || !request()->stu_generation || !(request()->trainee_status_id == 1 || request()->trainee_status_id == '') ? 'disabled' : '' }}
                            >
                                {{ __('button.transfer_future') }}
                            </button>
                        @endif
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </form>


    <!-- Trainee listing -->
    @if( count($trainees) > 0)

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.payroll_num') }}</th>
                                <th>{{ __('common.name') }}</th>
                                <th>{{ __('common.fullname_en') }}</th>
                                <th>{{ __('common.sex') }}</th>
                                <th>{{ __('common.dob') }}</th>
                                <th>{{ __('common.current_status') }}</th>
                                <th>{{ __('trainee.future_location') }}</th>
                                <th>{{ __('common.pass_fail') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($trainees as $index => $trainee)

                                <tr>
                                    <td>{{ $trainees->firstItem() + $index }}</td>
                                    <td>{{ $trainee->trainee_payroll_id }}</td>
                                    <td class="kh">{{ $trainee->surname_kh.' '.$trainee->name_kh }}</td>
                                    <td>{{ $trainee->surname_en.' '.$trainee->name_en }}</td>
                                    <td class="kh">{{ $trainee->sex === 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($trainee->dob)) }}</td>
                                    <td class="kh">{{ $trainee->status ? $trainee->status->trainee_status_kh : '' }}</td>
                                    <td class="kh">{{ $trainee->futureLocation ? $trainee->futureLocation->location_kh : '' }}</td>
                                    <td class="kh">{{ $trainee->result ? 'ជាប់' : 'ធ្លាក់' }}</td>

                                    <td class="text-right">
                                        @php $editableTrainee = in_array($trainee->trainee_status_id, [\App\Models\TraineeStatus::Trainee, \App\Models\TraineeStatus::Postpone]); @endphp
                                        <!-- Edit -->
                                        @if (auth()->user()->can('edit-trainee-teacher') && auth()->user()->is_ttc)
                                            @if ($editableTrainee)
                                                <a href="{{ route('trainees.edit', [app()->getLocale(), $trainee->trainee_payroll_id]) }}" class="btn btn-xs btn-info"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>
                                            @else
                                                <a href="{{ route('trainees.show', [app()->getLocale(), $trainee->trainee_payroll_id]) }}" class="btn btn-xs btn-success"><i class="far fa-eye"></i> {{ __('button.view') }}</a>
                                            @endif
                                        @elseif (auth()->user()->can('view-trainee-teacher') && auth()->user()->is_ttd_or_doper)
                                            <a href="{{ route('trainees.show', [app()->getLocale(), $trainee->trainee_payroll_id]) }}" class="btn btn-xs btn-success"><i class="far fa-eye"></i> {{ __('button.view') }}</a>
                                        @endif
                                        <!-- Delete -->
                                        @if (auth()->user()->can('delete-trainee-teacher') && auth()->user()->is_ttc)
                                            @if ($editableTrainee)
                                            <a
                                                href="javascript:void(0);"
                                                class="btn btn-xs btn-danger btn-delete"
                                                data-route="{{ route('trainees.destroy', [app()->getLocale(), $trainee]) }}"
                                                data-icon="warning"
                                                data-title="តើអ្នកប្រាកដទេ?"
                                                data-text="ទិន្នន័យនេះនឹងត្រូវលុបចេញពីប្រព័ន្ធ"
                                            >
                                                <i class="fas fa-trash-alt"></i> {{ __('button.delete') }}
                                            </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-center">
                <div>
                    @if($trainees->hasPages())
                        {!! $trainees->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>

        @if(auth()->user()->can('edit-trainee-teacher') && auth()->user()->is_ttc)
            @if ((request()->trainee_status_id == '' || request()->trainee_status_id == 1) && count($trainees) && request()->stu_generation)
            @include('admin.trainee_teachers.modals.transfer')
            @endif
        @endif
    @endif


</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#trainee-teacher").addClass("menu-open");
            $("#trainee-teacher-list > a").addClass("active");

            $('[data-mask]').inputmask();

            var btnOpenModal = $('#btnOpenTransferModal')
            var modal = $('#modalTransferTrainee')
            var btnTransfer = $("#modalTransferTrainee #btnTransfer")
            var verified = $("#modalTransferTrainee input[name='verified']")

            btnOpenModal.click(function () {
                if (modal.length) {
                    modal.modal('show')
                }
            })

            verified.change(function () {
                btnTransfer.attr('disabled', !this.checked)
            })

            // On Init
            // autoCompleteLocation()

            function autoCompleteLocation() {
                var locations = JSON.parse($("#locationInfo").val());

                $("#location_code").autocomplete({
                    source: locations
                });
            }
        })
    </script>

    <script>
        $(document).ready(function () {
            var location_code = $("select[name='location_code']")
            var prof_type_id = $("select[name='prof_type_id']")
            var stu_generation = $("select[name='stu_generation']")
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

            location_code.change(function() {
                if (!$(this).val()) {
                    prof_type_id.prop('disabled', true)
                    prof_type_id.prop("selectedIndex", 0).change();
                    return
                }
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
            }).change()

            prof_type_id.change(function() {
                if (!$(this).val()) {
                    stu_generation.prop('disabled', true)
                    stu_generation.prop("selectedIndex", 0).change();
                    return
                }
                onInitializeGenerations()
            }).change()

            function onTrainingInstituteChange() {
                var location_type_id = location_code.attr('data-location_type_id')
                var enableSubjectSelection = [locationType.institute, locationType.rttc].includes(location_type_id)

                var profTypes = []
                if (location_type_id == locationType.institute) {
                    profTypes = [professionalType.nie, professionalType.nie2, professionalType.rttc12_2, professionalType.rttc12_4]
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
                prof_type_id.prop('disabled', !location_code.val() || !location_type_id)
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

            function onInitializeGenerations() {
                $.ajax({
                    type: "GET",
                    url: `/ajax/get-trainee-academic-generations`,
                    data: { prof_type_id: prof_type_id.val(), all: true },
                    success: function (data) {
                        const generations = Object.values(data)
                        var lang = $('html').attr('lang')
                        var defaultOption = lang === 'en' ? '<option value="">Choose</option>' : '<option value="">ជ្រើសរើស</option>'
                        stu_generation.prop('disabled', !prof_type_id.val())
                        stu_generation.html(defaultOption)
                        generations.sort().reverse().forEach(function(value) {
                            stu_generation.append('<option value="'+value+'">'+ value +'</option>');
                        })
                        stu_generation.val(generations[0]).change();
                        const params = new URLSearchParams(window.location.search)
                        if (params.has('prof_type_id') && params.get('prof_type_id') === prof_type_id.val()) {
                            stu_generation.val(params.get('stu_generation')).change();
                        }
                    },
                    error: function (err) {
                        console.log('Error:', err);
                    }
                });
            }
        })
    </script>
@endpush
