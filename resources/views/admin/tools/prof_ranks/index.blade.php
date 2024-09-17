@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row mb-2">
        <div class="col-sm-6"><h1>{{ __('tcp.manage_profession_rank') }}</h1></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i> {{ __('menu.home') }}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('profession-ranks.index', app()->getLocale()) }}"> 
                    {{ __('tcp.manage_profession_rank') }} </a></li>
                <li class="breadcrumb-item active">{{ __('tcp.create_profession_rank') }}</li>
            </ol>

        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row row-box">
        <div class="col-md-6">
            <button type="button" id="btn-add" class="btn btn-info" 
                data-add-url="{{ route('profession-ranks.store', app()->getLocale()) }}">
                <i class="fas fa-plus"></i> {{ __('tcp.create_profession_rank') }}</button>
        </div>
    </div>

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
                    <h3 class="card-title">{{ __('tcp.manage_profession_rank').' ('.$profRanks->total().')' }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('tcp.profession_category') }}</th>
                                <th>{{ __('tcp.profession_rank_kh') }}</th>
                                <th>{{ __('tcp.profession_rank_en') }}</th>
                                <th class="text-center">{{ __('tcp.profession_rank_hierachy') }}</th>
                                <th>{{ __('tcp.profession_rank_low') }}</th>
                                <th>{{ __('tcp.profession_rank_high') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($profRanks as $index => $profRank)

                                <tr id="record-{{ $profRank->tcp_prof_rank_id }}">
                                    <td>{{ $profRanks->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $profRank->professionCategory->tcp_prof_cat_kh }}</td>
                                    <td class="kh">{{ $profRank->tcp_prof_rank_kh }}</td>
                                    <td>{{ $profRank->tcp_prof_rank_en }}</td>
                                    <td class="text-center">{{ $profRank->rank_hierarchy }}</td>
                                    <td>{{ $profRank->rank_low }}</td>
                                    <td>{{ $profRank->rank_high }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" 
                                            data-edit-url="{{ route('profession-ranks.edit', [app()->getLocale(), $profRank->tcp_prof_rank_id]) }}" 
                                            data-update-url="{{ route('profession-ranks.update', [app()->getLocale(), $profRank->tcp_prof_rank_id]) }}">
                                            <i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" 
                                            data-route="{{ route('profession-ranks.destroy', [app()->getLocale(), $profRank->tcp_prof_rank_id]) }}">
                                            <i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    @if ($profRanks->hasPages())
                        {!! $profRanks->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.tools.prof_ranks.modal_form')

@endsection

@push('scripts')
    <script src="{{ asset('js/delete.handler.js') }}"></script>
    <script src="{{ asset('js/custom_validation.js') }}"></script>

    <script>
        $(function() {
            $("#gen-management").addClass("menu-open");
            $("#others > a").addClass("active");

            // Validation
            $("#frmNewRecord").validate({
                submitHandler: function(frm) {
                    $('#modal-form').modal('hide');
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
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });

            // Add
            $('#btn-add').click(function() {
                var addURL = $(this).data("add-url");
                $("#frmNewRecord").trigger("reset");
                $("#tcp_prof_cat_id").val('').change();
                $("input[name='_method']").remove();
                $("#frmNewRecord").attr("action", addURL);
                $("#modal-form").modal("show");
            });

            // Edit official rank
            $(document).on("click", ".btn-edit", function() {
                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#tcp_prof_cat_id").val(data.tcp_prof_cat_id).change();
                    $("#tcp_prof_rank_kh").val(data.tcp_prof_rank_kh);
                    $("#tcp_prof_rank_en").val(data.tcp_prof_rank_en);
                    $("#rank_hierarchy").val(data.rank_hierarchy);
                    $("#rank_low").val(data.rank_low);
                    $("#rank_high").val(data.rank_high);

                    $("input[name='_method']").remove();
                    $("#frmNewRecord").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmNewRecord").prepend(putMethod);
                    $("#modal-form").modal("show");
                });
            });
        });

    </script>

@endpush
