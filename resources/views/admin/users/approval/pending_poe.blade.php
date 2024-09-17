@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('menu.manage_user_registration') }}
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
                   <li class="breadcrumb-item active">{{ __('menu.manage_user_registration') }}</li>
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

    @include('admin.users.partials.search_approval_poe')

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('menu.manage_user') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.payroll_num') }}</th>
                                <th>{{ __('common.fullname_kh') }}</th>
                                <th>បុគ្គលិក</th>
                                <th>{{ __('login.username') }}</th>
                                <th>{{ __('login.level') }}</th>
                                <th>{{ __('login.role') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th>{{ __('button.approved') }}?</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($userApprovals as $index => $userApproval)

                            <tr id="record-{{ $userApproval->id }}">
                                <td>{{ $userApprovals->firstItem() + $index }}</td>

                                <td>{{ $userApproval->payroll_id }}</td>
                                <td>{{ $userApproval->staff->surname_kh.' '.$userApproval->staff->name_kh }}</td>
                                <td>{{ $userApproval->staff->is_cont_staff == 0 ? "ក្របខណ្ឌ" : "កិច្ចសន្យា" }}</td>
                                <td>{{ $userApproval->username }}</td>
                                <td>{{ $userApproval->level->level_en }}</td>
                                <td>
                                    @foreach($userApproval->roles as $role)
                                    {{ $role->role_en }}
                                    @endforeach
                                </td>

                                <td class="text-center">
                                    @if( $userApproval->active === 1 )
                                    <i class="fas fa-check-square success"></i>
                                    @else
                                    <i class="fas fa-times-circle danger"></i>
                                    @endif
                                </td>

                                <td>
                                    @if (strtolower($userApproval->status) == 'pending')
                                    <span class="alert alert-warning"
                                        style="padding:4px 12px;">{{ __('button.pending') }}</span>
                                    @else
                                    <span class="alert alert-success"
                                        style="padding:4px 12px;">{{ __('button.approved') }}</span>
                                    @endif
                                </td>

                                <td class="text-right">
                                    @if (strtolower($userApproval->status) == 'pending')
                                    <button type="button" class="btn btn-xs btn-info btn-approve"
                                        data-approval-url="{{ route('user.approval', [app()->getLocale(), $userApproval->id]) }}"><i
                                            class="fas fa-unlock-alt"></i> {{ __('button.approve') }}</button>
                                    @else
                                    <a href="{{ route('password.resetpoe', [app()->getLocale(), $userApproval->id]) }}"
                                        class="btn btn-xs btn-info btn-reset"><i class="fas fa-unlock-alt"></i>
                                        {{ __('button.reset_password') }}</a>
                                    @endif
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($userApprovals->hasPages())
                        {!! $userApprovals->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.users.approval.modal_approval')

@endsection

@push('scripts')

<script src="{{ asset('js/delete.handler.js') }}"></script>

<script>
$(function() {
    $(".btn-approve").click(function() {
        var approvalURL = $(this).data("approval-url");
        //console.log(approvalURL);
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