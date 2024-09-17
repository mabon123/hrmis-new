@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 title="{{ auth()->user()->work_place->location_code }}">
                    {{ __('report.staff_transfer_in_workplace') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('report.staff_transfer_in_workplace') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    @include('admin.reports.partials.search_staff_transfer')
    <div class="card">
        {!! Form::open(['route' => ['staffs.acceptTransfer', [app()->getLocale()]], 'method' => 'PUT', 'id' => 'frmTransfer']) !!}
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
                            <th>{{ __('staff.old_location') }}</th>
                            <th>{{ __('staff.new_location') }}</th>
                            <th class="text-right">
                                <span>{{ __('common.total_amount') .':'. $staffs->total() }}</span>
                                <span style="margin-left:15px;">{{ __('common.female') .':'. $femaleStaffs }}</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($staffs as $index => $staff)
                            <tr>
                                <td>{{ $staffs->firstItem() + $index }}</td>
                                <td>
                                    <a href="{{ route('staffs.show', [app()->getLocale(), $staff->payroll_id]) }}" 
                                        target="_blank">{{ $staff->payroll_id }}</a>
                                </td>
                                <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                <td>{{ $staff->surname_en.' '.$staff->name_en }}</td>
                                <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                <td class="kh">{{ !empty($staff->oldLocation) ? $staff->oldLocation->location_kh : '---' }}</td>
                                <td class="kh">{{ !empty($staff->newLocation) ? $staff->newLocation->location_kh : '---' }}</td>

                                <td class="text-right">
                                    @if (auth()->user()->hasRole('administrator', 'poe-admin', 'central-admin'))
                                        @if ($staff->new_location_code == auth()->user()->work_place->location_code)
                                            <div class="icheck-primary d-inline">
                                                {{ Form::checkbox('payroll_ids[]', $staff->payroll_id, false, ['id' => 'payroll_id_'.$index]) }}
                                                <label for="payroll_id_{{ $index }}"></label>
                                            </div>
                                        @endif

                                        <a href="javascript:void(0);" class="btn btn-xs btn-info btn-change-location" 
                                            data-location-url="{{ route('staffTransfer.chooseNewWorkplace', [
                                                app()->getLocale(), $staff->payroll_id]) }}">
                                            <i class="far fa-edit"></i> {{ __('button.edit') }}
                                        </a>
                                    @else
                                        <div class="icheck-primary d-inline">
                                            {{ Form::checkbox('payroll_ids[]', $staff->payroll_id, false, ['id' => 'payroll_id_'.$index]) }}
                                            <label for="payroll_id_{{ $index }}"></label>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-center">
            <button type="submit" id="btn-transfer" class="btn btn-primary" style="width:180px;">
                <i class="far fa-save"></i> {{ __('button.process') }}
            </button>

            <div>
                @if($staffs->hasPages())
                    {!! $staffs->appends(Request::except('page'))->render() !!}
                @endif
            </div>
        </div>
        {{ Form::close() }}
    </div>
</section>

@include('admin.reports.modals.modal_new_location')

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            // Transfer staff event
            $('#btn-transfer').click(function(e) {
                e.preventDefault();
                loadModalOverlay();
                var payrolls = $('input[name="payroll_ids[]"]:checked').length;
                
                if (payrolls > 0) { $('#frmTransfer').trigger('submit'); }
                else {
                    toastMessage("bg-danger", "{{ __('validation.checkbox_required') }}");
                    $('#modal-overlay').hide();
                }
            });

            // Change workplace
            $('.btn-change-location').click(function() {
                var locationURL = $(this).data('location-url');
                var userRole = "{{ auth()->user()->hasRole('administrator') }}";

                $("#frmChooseNewLocation").trigger("reset");
                $("#select2-dis_code-container").text('ជ្រើសរើស ...');

                if (userRole == 1) {
                    $("#select2-pro_code-container").text('ជ្រើសរើស ...');
                    $("#dis_code").find('option:not(:first)').remove();
                    $("#dis_code").prop('disabled', true);
                }

                $("#select2-location_code-container").text('ជ្រើសរើស ...');
                $("#location_code").find('option:not(:first)').remove();
                $("#location_code").prop('disabled', true);
                $('#frmChooseNewLocation').attr("action", locationURL);
                $('#modal-new-location').modal('show');
            });

            // District change -> auto-fill data for location belong to that district
            $("#dis_code").change(function() {
                loadModalOverlay(true, 1000);
                $("#location_code").prop('disabled', false);
                
                if ($(this).val() > 0) {
                    $.ajax({
                        type: "GET",
                        url: "/districts/" + $(this).val() + "/locations",
                        success: function (locations) {
                            var locationCount = Object.keys(locations).length;
                            $("#location_code").find('option:not(:first)').remove();
                            
                            if ( locationCount > 0 ) {
                                for(var key in locations) {
                                    $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                                }
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });
                }
            });

            $('#frmChooseNewLocation').validate({
                submitHandler: function(frm) {
                    $("#modal-new-location").hide();
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
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });
        });
    </script>
@endpush