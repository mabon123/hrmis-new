@extends('layouts.admin')

@section('content')

<style>.m-bottom-15{margin-bottom:15px;}</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-user"></i> {{ __('common.others_manangement') }}
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
                    <li class="breadcrumb-item active">{{ __('common.others_manangement') }}</li>
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

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{ __('common.others_manangement') }}</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Province -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('provinces.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('common.province')
                    </a>
                </div>

                <!-- District -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('districts.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('common.district')
                    </a>
                </div>

                <!-- Commune -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('communes.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('common.commune')
                    </a>
                </div>

                <!-- Village -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('villages.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('common.village')
                    </a>
                </div>

                <!-- Country -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('countries.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.country')
                    </a>
                </div>

                <!-- Salary Level -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('salary-levels.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.salary_type')
                    </a>
                </div>

                <!-- Cardretype -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('cardretypes.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.cardretype')
                    </a>
                </div>

                <!-- Foriegn language -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('foriegn-languages.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.foriegn_language')
                    </a>
                </div>

                <!-- Ethnic/Nationality -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('ethnics.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.nationality')
                    </a>
                </div>

                <!-- Staff status -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('staff-status.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.staff_status')
                    </a>
                </div>

                <!-- Short course category -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('shortcourse-categories.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.shortcourse_category')
                    </a>
                </div>

                <!-- Training partner type -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('training-partner-types.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.training_partner_type')
                    </a>
                </div>

                <!-- Duration type -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('duration-types.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('common.duration_type')
                    </a>
                </div>

                <!-- Academic year -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('academic-years.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.academic_year')
                    </a>
                </div>

                <!-- Contract type -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('contract-types.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.contract_type')
                    </a>
                </div>

                <!-- Contract position -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('contstaff-positions.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.contract_position')
                    </a>
                </div>

                <!-- Trainee status -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('trainee-status.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i>
                        @lang('menu.trainee_status')
                    </a>
                </div>

                <!-- Position location -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('position-locations.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.position_location')
                    </a>
                </div>

                 <!-- Admiration source -->
                 <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('admiration-sources.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.admiration_source')
                    </a>
                </div>

                <!-- Admiration type -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('admiration-types.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.admiration_type')
                    </a>
                </div>

                <!-- Disability -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('disabilities.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.disability')
                    </a>
                </div>

                <!-- Document type -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('document-types.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.document_type')
                    </a>
                </div>

                <!-- Education Level -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('education-levels.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.education_level')
                    </a>
                </div>

                <!-- Grade -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('grades.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.grade')
                    </a>
                </div>

                <!-- History type -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('history-types.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.history_type')
                    </a>
                </div>

                <!-- Leave type -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('leave-types.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.leave_type')
                    </a>
                </div>

                <!-- Region -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('regions.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.region')
                    </a>
                </div>

                <!-- Report Fiedl -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('report-fields.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('menu.report_field')
                    </a>
                </div>

                <!-- Profession Category -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('profession-categories.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('tcp.menu_profession_category')
                    </a>
                </div>

                <!-- Profession Rank -->
                <div class="{{ $col }} m-bottom-15">
                    <a href="{{ route('profession-ranks.index', app()->getLocale()) }}">
                        <i class="{{ $icon }}"></i> @lang('tcp.menu_profession_rank')
                    </a>
                </div>
            </div>
        </div>

        <div class="card-footer"></div>
    </div>
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#gen-management").addClass("menu-open");
            $("#others > a").addClass("active");

        });

    </script>

@endpush
