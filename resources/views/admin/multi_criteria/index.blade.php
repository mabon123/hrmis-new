@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.manage_multi_criteria_search') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.manage_multi_criteria_search') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form id="frmMultiCriteriaSearch" action="{{ route('multi-criteria-search.index', app()->getLocale()) }}" 
        target="_blank">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info {{ request()->search ? 'collapsed-card' : '' }}">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('menu.manage_multi_criteria_search') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" 
                            	data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body custom-card" {{ request()->search ? 'style="display: none;"' : '' }}>
                        <input type="hidden" name="search" value="true">
                        <!-- #1st -->
                        @include('admin.multi_criteria.filters.filter1')

                        <!-- #2nd -->
                        @include('admin.multi_criteria.filters.filter2')

                        <!-- #3 -->
                        @include('admin.multi_criteria.filters.filter3')

                        <!-- #4th -->
                        @include('admin.multi_criteria.filters.filter4')

                        <!-- #5th -->
                        @include('admin.multi_criteria.filters.filter5')
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer" {{ request()->search ? 'style="display: none;"' : '' }}>
                        <button type="button" id="btn-reset" class="btn btn-danger" style="width:160px;">
                            <i class="fa fa-undo"></i>&nbsp;{{ __('button.reset') }}
                        </button>

                        <button type="submit" name="btn-action" value="search" class="btn btn-info" style="width:180px;">
                            <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                        </button>

                        <button type="submit" name="btn-action" value="export" class="btn btn-success" style="width:180px;">
                            <i class="far fa-file-excel"></i> {{ __('button.export_to_excel') }}
                        </button>
                    </div>
                </div>
                <!-- /.card .card-info -->
            </div>
        </div>
    </form>

    @include('admin.multi_criteria.partials.modal_fields')

    <!-- Staff listing -->
    @if( count($staffs) > 0 )

        @include('admin.multi_criteria.partials.listing')

    @endif
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>
    <script src="{{ asset('js/multi_criteria_search.js') }}"></script>
    
    <script type="text/javascript">
        $(function() {
            $("#multi-criteria-search-menu > a").addClass("active");

            // Reset form
            $("#btn-reset").click(function() {
                $("#frmSearchStaff").trigger("reset");
                $("#select2-pro_code-container").text('ជ្រើសរើស ...');
                $("#select2-dis_code-container").text('ជ្រើសរើស ...');
                $("#select2-filter_by-container").text('ជ្រើសរើស ...');
                $("#select2-position_id-container").text('ជ្រើសរើស ...');
                $("#select2-status_id-container").text('ជ្រើសរើស ...');
            });

            // Validation
            $("#frmMultiCriteriaSearch").validate({
                submitHandler: function(frm) {
                    //loadModalOverlay();
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
