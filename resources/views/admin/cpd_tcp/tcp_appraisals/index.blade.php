@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="far fa-list-alt"></i> {{ __('menu.tcp_appraisals_list') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i> {{ __('menu.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('menu.tcp_appraisals_list') }}</li>
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
                    <h3 class="card-title">{{ __('menu.tcp_appraisals_list') }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('tcp.profession_category') }}</th>
                                <th>{{ __('tcp.staff_name') }}</th>
                                <th>{{ __('tcp.appraisal_date') }}</th>
                                <th>{{ __('tcp.appraisal_score') }}</th>
                                <th>{{ __('tcp.profession_rank') }}</th>
                                <th>{{ __('tcp.tcp_status') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($appraisals as $index => $appraisal)
                            @php
                            $total_score = ($appraisal->cat1_score+$appraisal->cat2_score+$appraisal->cat3_score+$appraisal->cat4_score+$appraisal->cat5_score);

                            @endphp

                            <tr id="record-{{ $appraisal->tcp_appraisal_id }}">
                                <td>{{ $appraisals->firstItem() + $index }}</td>
                                <td class="kh"> {{ $appraisal->professionCategory->tcp_prof_cat_kh }}</td>
                                <td class="kh">{{ $appraisal->staffInfo->surname_kh.' '.$appraisal->staffInfo->name_kh }}</td>
                                <td>{{ date('d-m-Y', strtotime($appraisal->tcp_appraisal_date)) }}</td>
                                <td>{{ $total_score}}</td>
                                <td class="kh"> {{ $appraisal->professionRank->tcp_prof_rank_kh }}</td>
                                <td class="kh">
                                    @php
                                    $status_name = app()->getLocale() == 'kh' ? $appraisal->tcpStatus->status_kh : $appraisal->tcpStatus->status_en;
                                    $span_class = null;
                                    $feedback = null;
                                    if($appraisal->tcp_status_id == 2) {
                                    $span_class = "alert alert-warning";
                                    }
                                    elseif($appraisal->tcp_status_id == 3 || $appraisal->tcp_status_id == 4) {
                                    $span_class = "alert alert-danger";
                                    if($appraisal->doe_check_status == 6) {
                                    $status_name = __('tcp.status_r_doe');
                                    $feedback = $appraisal->doe_note;
                                    }
                                    elseif($appraisal->poe_check_status == 6) {
                                    $status_name = __('tcp.status_r_poe');
                                    $feedback = $appraisal->poe_note;
                                    }else {
                                    $feedback = $appraisal->admin_note;
                                    }
                                    }
                                    else {
                                    $span_class = "alert alert-success";
                                    }
                                    @endphp
                                    <span class="{{ $span_class }}" style="padding:4px 12px;cursor: pointer;">
                                        {{ $status_name }}
                                    </span>
                                </td>
                                @if($appraisal->tcp_status_id == 2)
                                <td>
                                    <a href="{{ route('tcp-appraisals.edit', [app()->getLocale(), $appraisal->tcp_appraisal_id]) }}" class="btn btn-xs btn-info" title="Edit"><i class="far fa-eye"></i> {{ __('button.view') }}</a>
                                    <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $appraisal->tcp_appraisal_id }}" data-route="{{ route('tcp-appraisals.destroy', [app()->getLocale(), $appraisal->tcp_appraisal_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                </td>
                                <td></td>
                                @else
                                <td>
                                    <a target="_blank" href="{{ route('tcp-appraisals.details', [app()->getLocale(), $appraisal->tcp_appraisal_id]) }}" class="btn btn-xs btn-info" title="View"><i class="far fa-eye"></i> {{ __('button.view') }}</a>
                                </td>
                                    @if(!empty($feedback))
                                    <td class="kh">{{ __('tcp.note_reasons').': ' . $feedback }}</td>
                                    @endif
                                @endif
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="card-footer">{{ $appraisals->links() }}</div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script src="{{ asset('js/delete.handler.js') }}"></script>

<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
        });
        $("#tcp-appraisals-list > a").addClass("active");
        $('.swalPending').click(function() {
            if ($(this).attr('span-data').length > 0) {
                Toast.fire({
                    icon: 'warning',
                    title: $(this).attr('span-data')
                })
            }
        });
        $('.swalVerified').click(function() {
            if ($(this).attr('span-data').length > 0) {
                Toast.fire({
                    icon: 'success',
                    title: $(this).attr('span-data')
                })
            }
        });
    });
</script>

@endpush