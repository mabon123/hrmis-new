@extends('layouts.admin')

@push('styles')
    <style>
        .pagination {
            justify-content: center;
            margin-bottom: 0px
        }
    </style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-building"></i> {{ __('menu.school_info') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('index', app()->getLocale()) }}"><i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('menu.school_info') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    @if(!auth()->user()->hasRole('dept-admin', 'school-admin'))
    <div class="row">
        <div class="col-md-12">
            <form method="get" action="{{ route('schools.index', app()->getLocale()) }}">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-filter"></i> {{ __('school.search_schools') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="pro_code">{{__('school.province')}} </label>
                                                    {{ Form::select(
                                                        'pro_code',
                                                        ['' => __('common.choose').' ...'] + $provinces,
                                                        request()->pro_code ?? (auth()->user()->hasRole('poe-admin', 'doe-admin', 'school-admin', 'leader') ? auth()->user()->work_place->pro_code : null),
                                                        [
                                                            'id' => 'p_code', "class" => "form-control select2",
                                                            'style' => 'width:100%;',
                                                            'disabled' => auth()->user()->hasRole('poe-admin', 'doe-admin', 'school-admin', 'leader')
                                                        ])
                                                    }}
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="dis_code">{{__('common.district')}}</label>
                                                    {{ Form::select(
                                                        'dis_code',
                                                        ['' => __('common.choose').' ...'] + $districts,
                                                        request()->dis_code ?? (count($districts) == 1 ? auth()->user()->work_place->dis_code : null),
                                                        [
                                                            'id' => 'd_code', "class" => "form-control select2",
                                                            'style' => 'width:100%;',
                                                            'disabled' => (!request()->pro_code && auth()->user()->level_id != 3 && auth()->user()->level_id != 2) || auth()->user()->hasRole('doe-admin', 'school-admin')
                                                        ])
                                                    }}
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="com_code">{{__('common.commune')}}</label>
                                                    {{ Form::select(
                                                        'com_code',
                                                        ['' => __('common.choose').' ...'] + $communes,
                                                        request()->com_code,
                                                        [
                                                            'id' => 'c_code',
                                                            "class" => "form-control select2",
                                                            'style' => 'width:100%;',
                                                            'disabled' => !request()->dis_code && !auth()->user()->hasRole('doe-admin')
                                                        ])
                                                    }}
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="vil_code">{{__('common.village')}}</label>
                                                    {{ Form::select(
                                                        'vil_code',
                                                        ['' => __('common.choose').' ...'] + $villages,
                                                        request()->vil_code,
                                                        [
                                                            'id' => 'v_code',
                                                            "class" => "form-control select2",
                                                            'style' => 'width:100%;',
                                                            'disabled' => !request()->com_code
                                                        ])
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="location_type_id">{{__('school.location_type')}}</label>
                                                    {{ Form::select(
                                                        'location_type_id',
                                                        ['' => __('common.choose') ] + $locationTypes,
                                                        request()->location_type_id,
                                                        ["class" => "form-control select2", 'style' => 'width:100%;'])
                                                    }}
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="name">{{__('school.name')}}</label>
                                                    {{ Form::text('name', request()->name, ["class" => "form-control"]) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="search" value="true">
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info" style="width:220px;">
                            <i class="fa fa-search"></i>&nbsp;{{__('school.search_schools')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            @include('admin.validations.validate')
        </div>
    </div>

    @if (request()->search || auth()->user()->hasRole('dept-admin', 'school-admin'))
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th scope="col">@lang('school.id')</th>
                            <th scope="col">@lang('school.location_type')</th>
                            <th scope="col">@lang('school.name_kh')</th>
                            <th style="width: 120px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $index => $location)
                        <tr>
                            <td>{{ $locations->firstItem() + $index }}</td>
                            <td>{{ $location->location_code }}</td>
                            <td>{{ $location->locationType ? $location->locationType->location_type_kh : '' }}</td>
                            <td>{{ $location->location_kh }}</td>
                            <td>
                                @if (auth()->user()->can('edit-schools'))
                                <a href="{{ route('schools.edit', [app()->getLocale(), $location->location_code]) }}" class="btn btn-xs btn-info" target="_blank">
                                    <i class="far fa-edit"></i> {{ __('button.edit') }}
                                </a>
                                @endif

                                @if (auth()->user()->can('delete-schools'))
                                    <a
                                        href="javascript:void(0);"
                                        class="btn btn-xs btn-danger btn-delete"
                                        data-route="{{ route('schools.destroy', [app()->getLocale(), $location]) }}"
                                        data-icon="warning"
                                        data-title="តើអ្នកប្រាកដទេ?"
                                        data-text="ទិន្នន័យនេះនឹងត្រូវលុបចេញពីប្រព័ន្ធ"
                                    >
                                       <i class="fas fa-trash-alt"></i> {{ __('button.delete') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($locations->count() && request()->search)
                <div id="pagination" class="mt-3">
                    @if($locations->hasPages())
                        {!! $locations->appends(Request::except('page'))->render() !!}
                    @endif
                </div>
            @endif
        </div>
    </div>
    @endif
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/location.js') }}"></script>
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#location-info").addClass("menu-open");
            $("#location-list > a").addClass("active");
        })
    </script>
@endpush
