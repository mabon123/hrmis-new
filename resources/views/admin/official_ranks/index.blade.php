@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.manange_official_rank') }}
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
                    <li class="breadcrumb-item"><a href="#"> {{ __('common.manange_official_rank') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('common.create_official_rank') }}</li>
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

    <form method="post" id="frmCreateOfficialRank" action="{{ route('official-ranks.store', app()->getLocale()) }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ __('common.create_official_rank') }}</h3>

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
                            <label for="official_rank_kh">
                                {{ __('common.official_rank_kh') }} <span class="required">*</span>
                            </label>

                            <input type="text" name="official_rank_kh" id="official_rank_kh" value="{{ old('official_rank_kh') }}" maxlength="150" autocomplete="off" class="form-control kh">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="official_rank_en">{{ __('common.official_rank_en') }}</label>

                            <input type="text" name="official_rank_en" id="official_rank_en" value="{{ old('official_rank_en') }}" maxlength="50" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="salary_level_id">
                                {{ __('common.salary_type') }} <span class="required">*</span>
                            </label>

                            <select name="salary_level_id" id="salary_level_id" class="form-control select2 kh">
                                <option value="">{{ __('common.choose') }}</option>

                                @foreach($salaryLevels as $key => $salaryLevel)
                                    <option value="{{ $key }}">
                                        {{ $salaryLevel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-reset" class="btn btn-danger" data-add-url="{{ route('official-ranks.store', app()->getLocale()) }}" style="width:150px;">
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('common.manange_official_rank') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.official_rank_kh') }}</th>
                                <th>{{ __('common.official_rank_en') }}</th>
                                <th>{{ __('common.salary_type') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($officialRanks as $index => $officialRank)

                                <tr id="record-{{ $officialRank->official_rank_id }}">
                                    <td>{{ $officialRanks->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $officialRank->official_rank_kh }}</td>
                                    <td>{{ $officialRank->official_rank_en }}</td>
                                    <td>{{ $officialRank->salaryLevel->salary_level_kh }}</td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('official-ranks.edit', [app()->getLocale(), $officialRank->official_rank_id]) }}" data-update-url="{{ route('official-ranks.update', [app()->getLocale(), $officialRank->official_rank_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('official-ranks.destroy', [app()->getLocale(), $officialRank->official_rank_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $officialRanks->links() }}</div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#gen-management").addClass("menu-open");
            $("#official-rank > a").addClass("active");

            // Validation
            $("#frmCreateOfficialRank").validate({
                rules: {
                    official_rank_kh: "required",
                    salary_level_id: "required",
                },
                messages: {
                    official_rank_kh: "{{ __('validation.required_field') }}",
                    salary_level_id: "{{ __('validation.required_field') }}",
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

            // Edit official rank
            $(document).on("click", ".btn-edit", function() {

                loadModalOverlay(true, 500);

                var editURL = $(this).data("edit-url");
                var updateURL = $(this).data("update-url");

                $.get(editURL, function (data) {
                    $("#official_rank_kh").val(data.official_rank_kh);
                    $("#official_rank_en").val(data.official_rank_en);

                    $("#salary_level_id option[value='"+data.salary_level_id+"']").prop("selected", true);
                    $("#select2-salary_level_id-container")
                        .text($("#salary_level_id option[value='"+data.salary_level_id+"']").text());

                    $("#frmCreateOfficialRank").attr("action", updateURL);
                    var putMethod = '<input name="_method" type="hidden" value="PUT">';
                    $("#frmCreateOfficialRank").prepend(putMethod);

                    $("#modal-overlay").modal("hide");
                });

            });

            // Reset form info
            $("#btn-reset").click(function() {

                $("#frmCreateOfficialRank").trigger("reset");

                var addURL = $(this).data("add-url");
                $("input[name='_method']").remove();
                $("#frmCreateOfficialRank").attr("action", addURL);

            });

        });

    </script>

@endpush
