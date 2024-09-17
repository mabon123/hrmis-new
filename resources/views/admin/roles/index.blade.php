@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('menu.manage_role') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fa fa-dashboard"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#"> {{ __('menu.manage_role') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('login.manage_role') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row row-box">
        <div class="col-sm-12">
            <a href="{{ route('roles.create', app()->getLocale()) }}" class="btn btn-info" 
                style="width:180px;" onclick="loadModalOverlay();">
                <i class="fas fa-plus"></i> {{ __('login.create_role') }}
            </a>
        </div>
    </div>
    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('login.role_kh') }}</th>
                                <th>{{ __('login.role_en') }}</th>
                                <th>{{ __('login.role_slug') }}</th>
                                <th>{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($roles as $index => $role)

                                <tr id="record-{{ $role->role_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="kh">{{ $role->role_kh }}</td>
                                    <td>{{ $role->role_en }}</td>
                                    <td>{{ $role->role_slug }}</td>

                                    <td>
                                        @if( $role->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <a href="{{ route('roles.edit', [app()->getLocale(), $role->role_id]) }}" class="btn btn-xs btn-info"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $role->role_id }}" data-delete-url="{{ route('roles.destroy', [app()->getLocale(), $role->role_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $roles->links() }}</div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
    
    <!-- Validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        
        $(function() {

            $("#user-role").addClass("menu-open");
            $("#manage-role > a").addClass("active");

            // Validation
            $("#frmCreateRole").validate({
                rules: {
                    role_kh: "required",
                    role_slug: "required",
                },
                messages: {
                    role_kh: "{{ __('validation.required_field') }}",
                    role_slug: "{{ __('validation.required_field') }}",
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

            // Delete role
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

                            toastMessage("bg-success", "{{ __('validation.delete_success') }}");
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }

            });

        });

    </script>

@endpush
