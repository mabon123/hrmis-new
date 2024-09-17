@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('menu.profile_veriffied_details') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{ __('menu.manage_profile_verification') }} </a></li>
                    <li class="breadcrumb-item active">{{ __('menu.profile_veriffied_details') }}</li>
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
        <div class="col-md-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button style="position: relative; top: -20px;" class="close" data-dismiss="alert" type="button">×</button>
            </div><br />
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if( count($data) > 0 )
            <form method="post" action="{{ route('profile.fieldapproval', [app()->getLocale(), $headerid]) }}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('common.payroll_num').': '.$headerid }}</h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('common.req_info') }}</th>
                                    <th>{{ __('common.new_value_desc') }}</th>
                                    <th>{{ __('button.approve').' ?' }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $index => $staff)
                                <tr>
                                    <td> {{ $index + 1 }}</td>
                                    <td>{{ $staff->field_title_kh.' ('.$staff->field_title_en.')' }}</td>
                                    <td>
                                        @if($staff->field_id=='010')
                                        {{ $staff->correct_value == 1 ? 'ប្រុស' : 'ស្រី' }}
                                        @elseif ($staff->field_id=='011' || $staff->field_id == '029')
                                        {{ date('d-m-Y', strtotime($staff->correct_value)) }}
                                        @elseif ($staff->field_id=='012')
                                        {{ $staff->ethnic->ethnic_kh }}
                                        @elseif ($staff->field_id=='013')
                                        {{ $staff->disability->disability_kh }}
                                        @elseif ($staff->field_id=='014')
                                        {{ $staff->birthProvince->name_kh }}
                                        @elseif ($staff->field_id=='027')
                                        {{ $staff->maritalStatus->maritalstatus_kh }}
                                        @elseif ($staff->field_id=='038')
                                        {{ $staff->addressProvince->name_kh }}
                                        @elseif ($staff->field_id=='039')
                                        {{ $staff->addressDistrict->name_kh }}
                                        @elseif ($staff->field_id=='040')
                                        {{ $staff->addressCommune->name_kh }}
                                        @elseif ($staff->field_id=='041')
                                        {{ $staff->addressVillage->name_kh }}
                                        @else
                                        {{ $staff->correct_value }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" field_id="{{ $staff->field_id }}" name="check_id[]" id="id_{{ $staff->id }}" class="check_id" value="{{ $staff->id }}">
                                            <label for="id_{{ $staff->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-danger btn-reject" value="{{ $staff->id }}" data-route="{{ route('profile.destroy', [app()->getLocale(), $staff->id]) }}"><i class="fas fa-times"></i> {{ __('button.reject') }}</button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('profile.need.approval', app()->getLocale()) }}" class="btn btn-danger btn-cancel" style="width:150px;">
                            <i class="fa fa-times"></i>&nbsp; {{__('button.cancel')}}
                        </a>

                        <button type="submit" class="btn btn-info" style="width:150px;">
                            <i class="far fa-save"></i>&nbsp;{{ __('button.approve') }}
                        </button>

                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/delete.handler.js') }}"></script>
<script>
    $(function() {
        $(".check_id").change(function() {
            var thisElement = $(this);
            if (thisElement.is(':checked')) {
                var baseUrl = window.location.origin;
                var payrollId = "{{ $headerid }}";
                var lang = "{{ app()->getLocale() }}";

                var field_id = thisElement.attr('field_id');
                if (field_id == '018' || field_id == '021' || field_id == '045') { // workInfo/history/Leave 
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/work-histories',
                        '_blank');
                } else if (field_id == '019' || field_id == '044') { // Official Rank & Degree/TCP professional
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/edit', '_blank');
                } else if (field_id == '020') { // Teaching Info
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/teaching', '_blank');
                } else if (field_id == '022') { // Admiration/Blame/Inspection
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/admirations', '_blank');
                } else if (field_id == '023') { // Qualifications
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/general-knowledge',
                        '_blank');
                } else if (field_id == '024') { // Professtional Skills
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/qualifications',
                        '_blank');
                } else if (field_id == '025' || field_id == '026') { // Short Courses & Foriegn Langues
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/shortcourses', '_blank');
                } else if (field_id == '034') { // Children Info
                    window.open(baseUrl + '/' + lang + '/staffs/' + payrollId + '/families', '_blank');
                } else {
                    //nothing   
                }
            }
        });
    });
</script>

@endpush