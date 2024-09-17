@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.cpd_provider') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.cpd_provider') }}</li>
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
                    <h3 class="card-title">{{ __('menu.cpd_provider') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cpd.provider_kh') }}</th>
                                <th>{{ __('cpd.provider_en') }}</th>
                                <th>{{ __('cpd.provider_type') }}</th>
                                <th>{{ __('cpd.provider_cat') }}</th>
                                <th>{{ __('common.telephone') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @foreach($providers as $index => $provider)

                                <tr id="record-{{ $provider->provider_id }}">
                                    <td>{{ $providers->firstItem() + $index }}</td>
                                    
                                    <td class="kh">{{ $provider->provider_kh }}</td>
                                    <td>{{ $provider->provider_en }}</td>
                                    <td class="kh">{{ $provider->providerType->provider_type_kh }}</td>
                                    <td class="kh">{{ $provider->providerCategory->provider_cat_kh }}</td>
                                    <td>{{ $provider->provider_phone }}</td>

                                    <td class="text-right">
                                    	<a href="{{ route('cpd-providers.edit', [app()->getLocale(), $provider->provider_id]) }}" class="btn btn-xs btn-info" title="Edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $provider->provider_id }}" data-route="{{ route('cpd-providers.destroy', [app()->getLocale(), $provider->provider_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $providers->links() }}</div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    
    <script src="{{ asset('js/delete.handler.js') }}"></script>

    <script>
        
        $(function() {

            $("#cpd-provider").addClass("menu-open");
            $("#provider-list > a").addClass("active");

        });

    </script>

@endpush
