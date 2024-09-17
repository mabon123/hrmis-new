@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.subject_of_study') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.subject_of_study') }}</li>
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

    <!-- Permission listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('menu.subject_of_study') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cpd.subject_code') }}</th>
                                <th>{{ __('cpd.subject_kh') }}</th>
                                <th>{{ __('cpd.subject_en') }}</th>
                                <th>{{ __('cpd.field_of_study') }}</th>
                                <th class="text-center">{{ __('login.active') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($subjectOfStudies as $index => $subjectOfStudy)

                                <tr id="record-{{ $subjectOfStudy->cpd_subject_id }}">
                                    <td>{{ $subjectOfStudies->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $subjectOfStudy->cpd_subject_code }}</td>
                                    <td class="kh">{{ $subjectOfStudy->cpd_subject_kh }}</td>
                                    <td>{{ $subjectOfStudy->cpd_subject_en }}</td>
                                    <td class="kh">
                                    	{{ $subjectOfStudy->fieldOfStudy->cpd_field_code .' - '. 
                                    	$subjectOfStudy->fieldOfStudy->cpd_field_kh }}
                                    </td>

                                    <td class="text-center">
                                        @if( $subjectOfStudy->active === 1 )
                                            <i class="fas fa-check-square success"></i>
                                        @else
                                            <i class="fas fa-times-circle danger"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                    	<a href="{{ route('subject-of-study.edit', [app()->getLocale(), $subjectOfStudy->cpd_subject_id]) }}" class="btn btn-xs btn-info" title="Edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>

                                        <?php /* ?><button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $subjectOfStudy->cpd_subject_id }}" data-route="{{ route('subject-of-study.destroy', [app()->getLocale(), $subjectOfStudy->cpd_subject_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button><?php */ ?>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $subjectOfStudies->links() }}</div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#subject-study").addClass("menu-open");
            $("#subject-study-list > a").addClass("active");

        });

    </script>

@endpush
