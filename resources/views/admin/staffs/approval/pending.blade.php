@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('menu.manage_profile_verification') }}
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
                    <li class="breadcrumb-item active">{{ __('menu.manage_profile_verification') }}</li>
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

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('menu.staff_info') }}</h3>
                </div>
                @if( count($staffs) > 0 )

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.payroll_num') }}</th>
                                <th>{{ __('common.name') }}</th>
                                <th>{{ __('common.fullname_en') }}</th>
                                <th>{{ __('common.sex') }}</th>
                                <th>{{ __('common.dob') }}</th>
                                <th>{{ __('button.approved') }}?</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($staffs as $index => $staff)
                            <tr>
                                <td>{{ $staffs->firstItem() + $index }}</td>
                                <td>{{ $staff->payroll_id }}</td>
                                <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                <td>{{ $staff->surname_en.' '.$staff->name_en }}</td>
                                <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                <td>{{ $staff->dob }}</td>
                                <td>
                                    @if ($staff->check_status == 4)
                                    <span class="alert alert-warning"
                                        style="padding:4px 12px;">{{ __('button.pending') }}</span>
                                    @else
                                    <span class="alert alert-success"
                                        style="padding:4px 12px;">{{ __('button.approved') }}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <!-- View -->
                                    <a href="{{ route('profile.details', [app()->getLocale(), $staff->payroll_id]) }}"
                                        class="btn btn-xs btn-success"><i class="far fa-eye"></i>
                                        {{ __('button.view') }}
                                    </a>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $staffs->links() }}</div>

                @else
                <p style="padding: 20px">{{ __('common.no_data') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script src="{{ asset('js/delete.handler.js') }}"></script>

<script>
$(function() {
    $(".btn-approve").click(function() {
        var approvalURL = $(this).data("approval-url");
        console.log(approvalURL);
        $("#form-user-approval").prop("action", approvalURL);
        $("#modal-user-approval").modal({
            show: true,
            backdrop: 'static',
        });
    });

    // Form submit
    $("#form-user-approval").submit(function() {
        $("#modal-user-approval").modal('hide');
        loadModalOverlay();
    });
});
</script>

@endpush