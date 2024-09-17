@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.staff_trainee_list') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('menu.staff_trainee_list') }}</li>
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
    <!-- Trainee listing -->
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
                            <th class="d-flex justify-content-center">
                                @if(auth()->user()->can('edit-trainee-teacher-list'))
                                {{ __('common.choose') }}
                                {{-- <div class="form-group mb-0 ml-1">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="selected-all-trainee" id="selected-all-trainee">
                                        <label for="selected-all-trainee"></label>
                                    </div>
                                </div> --}}
                                @endif
                            </th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($staffs as $index => $staff)
                            <tr data-payroll_id="{{ $staff->payroll_id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $staff->payroll_id }}</td>
                                <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                <td>{{ $staff->surname_en.' '.$staff->name_en }}</td>
                                <td class="kh">{{ $staff->sex === 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                <td class="kh">{{ $staff->status ? $staff->status->status_kh : '' }}</td>
                                <td class="kh">{{ $staff->currentWork && $staff->currentWork->location ? $staff->currentWork->location->location_kh : '' }}</td>
                                <td class="text-center">
                                    @if(auth()->user()->can('edit-trainee-teacher-list') && in_array($staff->payroll_id, $processablePayrollIds))
                                    <div class="form-group mb-0 clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="selected-trainee" id="selected-trainees-{{$staff->payroll_id}}" name="selected-trainees-{{$staff->payroll_id}}" value="{{ $staff->payroll_id }}">
                                            <label for="selected-trainees-{{$staff->payroll_id}}"></label>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if(!auth()->user()->hasRole('doe-admin', 'school-admin') && auth()->user()->can('edit-trainee-teacher-list'))
                                     <button
                                        type="button"
                                        class="btn btn-xs btn-info btn-edit"
                                        data-location_code="{{ $staff->currentWork && $staff->currentWork->location ? $staff->currentWork->location->location_code : null  }}"
                                        data-update-url="{{ route('staffs.trainees.future-location.update', [app()->getLocale(), $staff]) }}"
                                    >
                                        <i class="far fa-edit"></i> {{ __('button.edit') }}
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="10">{{ __('common.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if (!auth()->user()->hasRole('doe-admin') && auth()->user()->can('edit-trainee-teacher-list') && count($staffs))
        <div class="card-footer">
            <button
                class="btn btn-primary btn-accept btn-confirm"
                data-route="{{ route('staffs.accept-trainee-list', [app()->getLocale()]) }}"
                data-method="PUT"
                data-icon="warning"
                data-html="<span style='font-size: 16px'>
                    គ្រូដែលត្រូវជ្រើសរើសនឹងបញ្ចូលក្នុងអង្គភាពរបស់លោកអ្នក ។<br>
                    បន្ទាប់ពីចុច យល់ព្រម សូមជួយពិនិត្យនិងកែប្រែព័ត៌មានរបស់ពួកគាត់បន្ថែម ។<br>
                    <span class='text-danger'>ពិសេសត្រង់-ព័ត៌មានលំអិត(ឋានន្តរស័ក្តិ និងថ្នាក់)-កម្រិតវប្បធម៌-ការបង្រៀន</span>
                </span>"
                style="width:180px;"
                disabled
            >
                <i class="fas fa-trash-check"></i> {{ __('button.accept') }}
            </button>
        </div>
        @endif
    </div>
    @include('admin.staffs.modals.modal_future_location')

</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/confirm.handler.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#staff-trainee-list").addClass("menu-open");
        })
    </script>

    <script>
        $(document).ready(function () {

            const route = "{{ route('staffs.accept-trainee-list', [app()->getLocale()]) }}"

            // $('#selected-all-trainee').change(function () {
            //     const isSelectedAll = $('#selected-all-trainee').is(':checked')
            //     $('.selected-trainee').each(function () {
            //         $(this).prop('checked', isSelectedAll);
            //     })

            //     $('.btn-accept').prop('disabled', !isSelectedAll)
            //     const queryIds = isSelectedAll ? 'all' : ''
            //     $('.btn-accept').attr('data-route', route + "?payroll_ids=" + queryIds)
            // })


            $('.selected-trainee').change(function() {
                let ids = [];
                const selectedTrainees = $('.selected-trainee:checkbox:checked')

                // if (selectedTrainees.length < $('tbody tr').length) {
                //     $('#selected-all-trainee').prop('checked', false)
                // }
                $('.btn-accept').prop('disabled', !selectedTrainees.length)

                if (selectedTrainees.length) {
                    selectedTrainees.each(function() {
                        const id = $(this).parents('tr').attr('data-payroll_id')
                        ids.push(id)
                    })
                }
                const queryIds = ids.join(',')
                $('.btn-accept').attr('data-route', route + "?payroll_ids=" + queryIds)
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            const btnEdit = $('.btn-edit')
            const form = $('#frmEditFutureLocation')
            const futureLocationSelection = $("#frmEditFutureLocation select[name='future_location_code']")
            const modal = $('#modal-future-location')
            const btnSave = $('#frmEditFutureLocation #btnSave')
            const futureLocation = $("#frmEditFutureLocation select[name='future_location_code']")

            btnEdit.click(function() {
                const updateUrl = $(this).attr('data-update-url')
                const locationCode = $(this).attr('data-location_code')

                form.attr('action', updateUrl)
                futureLocationSelection.val(locationCode).change()
                modal.modal()
            })

            modal.on('hidden.bs.modal', function () {
                form.attr('action', '')
                futureLocation.val('').change()
            });

            futureLocation.change(function() {
                btnSave.attr('disabled', !this.value)
            })
        })
    </script>
@endpush
