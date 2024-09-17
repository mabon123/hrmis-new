@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('menu.manage_user') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index', app()->getLocale()) }}"> {{ __('menu.manage_user') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('login.create_user') }}</li>
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
        <div class="col-sm-12">
            <a href="{{ route('users.create', app()->getLocale()) }}" class="btn btn-info" 
                style="width:180px;" onclick="loadModalOverlay();">
                <i class="fas fa-plus"></i> {{ __('login.create_user') }}
            </a>
        </div>
    </div>

    @include('admin.users.partials.search')
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('menu.manage_user') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <!-- User listing -->
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.payroll_num') }}</th>
                                <th>{{ __('login.username') }}</th>
                                <th>{{ __('login.level') }}</th>
                                <th>{{ __('login.role') }}</th>
                                <th>{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($users as $index => $user)

                                <tr id="record-{{ $user->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="kh">{{ $user->payroll_id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->level->level_en }}</td>

                                    <td>
                                        @foreach($user->roles as $role)
                                            {{ $role->role_en }}
                                        @endforeach
                                    </td>

                                    <td>
                                        @if( $user->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <a href="{{ route('users.edit', [app()->getLocale(), $user->id]) }}" class="btn btn-xs btn-info btn-edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>

                                        <a href="{{ route('password.reset', [app()->getLocale(), $user->id]) }}" 
                                            class="btn btn-xs btn-secondary">
                                            <i class="fas fa-key"></i> @lang('button.reset_password')</a>

                                        @if ($user->active == 1)
                                            <button type="button" class="btn btn-xs btn-danger btn-disable" 
                                                data-route="{{ route('users.disable', [app()->getLocale(), $user->id]) }}">
                                                <i class="fa fa-ban" aria-hidden="true"></i> @lang('button.disable')</button>
                                        @else
                                            <button type="button" class="btn btn-xs btn-success btn-disable" 
                                                data-route="{{ route('users.disable', [app()->getLocale(), $user->id]) }}">
                                                <i class="fa fa-ban" aria-hidden="true"></i> @lang('button.active')</button>
                                        @endif

                                        <?php /* ?><button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $user->id }}" data-delete-url="{{ route('users.destroy', [app()->getLocale(), $user->id]) }}"><i class="fas fa-trash-alt"></i> DELETE</button><?php */ ?>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div>
                        @if($users->hasPages())
                            {!! $users->appends(Request::except('page'))->render() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/disable.handler.js') }}"></script>
    <script>
        
        $(function() {

            $("#user").addClass("menu-open");
            $("#manage-user > a").addClass("active");

            // Edit permission
            $(document).on("click", ".btn-edit", function() {
                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (permission) {
                    $("#permission_kh").val(permission.permission_kh);
                    $("#permission_en").val(permission.permission_en);
                    $("#permission_slug").val(permission.permission_slug);

                    if ( permission.active === 1 ) {
                        $("#active").prop("checked", true);
                    } else {
                        $("#active").prop("checked", false);
                    }

                    $("#frmCreatePermission").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreatePermission").prepend(putMethod);
                });
            });

            // Delete permission
            /*$(document).on("click", ".btn-delete", function() {

                var deleted = confirm('Are you sure you want to remove this entry?');

                if( deleted ) {

                    var deleteURL = $(this).data("delete-url");
                    var itemID = $(this).val();

                    $.ajax({
                        type: "DELETE",
                        url: deleteURL,
                        success: function (data) {
                            $("#record-" + itemID).remove();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }

            });*/

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreatePermission").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreatePermission").attr("action", addURL);

            });

            // Form submit
            $("#frmCreatePermission").submit(function(e) {

                $("#modal-overlay").modal({
                    show: true,
                    backdrop: 'static',
                });

            });

        });

    </script>

@endpush
