@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('menu.manage_permission') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="#"> {{ __('menu.manage_permission') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('login.create_permission') }}</li>
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

    <form method="post" id="frmCreatePermission" action="{{ route('permissions.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('login.create_permission') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="permission_kh">{{ __('login.permission_kh') }}</label>

                            <input type="text" name="permission_kh" id="permission_kh" value="{{ old('permission_kh') }}" maxlength="250" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="permission_en">{{ __('login.permission_en') }}</label>

                            <input type="text" name="permission_en" id="permission_en" value="{{ old('permission_en') }}" maxlength="180" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="permission_slug">{{ __('login.permission_slug') }} <span class="required">*</span></label>

                            <input type="text" name="permission_slug" id="permission_slug" value="{{ old('permission_slug') }}" maxlength="50" autocomplete="off" class="form-control @error('permission_slug') is-invalid @enderror">

                            <p class="text-sm text-muted">ex: create-staff</p>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group clearfix" style="margin-top:40px;">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="active" name="active" value="1" checked>
                                <label for="active">{{__('login.active')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('permissions.store', app()->getLocale()) }}" style="width:150px;">
                    <i class="far fa-times-circle"></i>&nbsp;{{ __('button.reset') }}
                </button>

                <button type="submit" class="btn btn-info" style="width:150px;">
                    <i class="far fa-save"></i>&nbsp;{{ __('button.save') }}
                </button>
            </div>
        </div>
    </form>

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('login.permission_kh') }}</th>
                                <th>{{ __('login.permission_en') }}</th>
                                <th>{{ __('login.permission_slug') }}</th>
                                <th>{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($permissions as $index => $permission)

                                <tr id="record-{{ $permission->permission_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="kh">{{ $permission->permission_kh }}</td>
                                    <td>{{ $permission->permission_en }}</td>
                                    <td>{{ $permission->permission_slug }}</td>

                                    <td>
                                        @if( $permission->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('permissions.edit', [app()->getLocale(), $permission->permission_id]) }}" data-update-url="{{ route('permissions.update', [app()->getLocale(), $permission->permission_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $permission->permission_id }}" data-delete-url="{{ route('permissions.destroy', [app()->getLocale(), $permission->permission_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">{{ $permissions->links() }}</div>
    </div>

</section>

@endsection

@push('scripts')

    <script>
        
        $(function() {

            $("#user-role").addClass("menu-open");
            $("#manage-permission > a").addClass("active");

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
            $(document).on("click", ".btn-delete", function() {

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

            });

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
