<div class="row row-box">
    @if (isset($staff))
        <div class="col-sm-12" style="margin-bottom:15px;">
            <div class="card card-default">
                <div class="card-header">
                    <h4 style="border-bottom:none;margin-bottom:0px;">
                        <span class="section-num">@lang('number.num4').</span>
                        {{ __('tcp.profession') }}
                    </h4>
                </div>

                <div class="card-body" style="padding-bottom:0;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('tcp.profession_category') }}</th>
                                    <th>{{ __('common.description') }}</th>
                                    <th>{{ __('common.date_obtained') }}</th>
                                    <th>{{ __('common.prokah_num_only') }}</th>
                                    <th>{{ __('common.prokah_attachment') }}</th>
                                    <th></th>
                                </tr>
                            </thead>

                            @foreach ($profRecordings as $index => $profRecording)

                                <tr id="salary-{{$profRecording->tcp_prof_rec_id}}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="kh">
                                        {{ !empty($profRecording->professionRank) ? 
                                            $profRecording->professionRank->tcp_prof_rank_kh : '---' }}
                                    </td>
                                    <td class="kh">{{ $profRecording->description }}</td>
                                    <td>
                                        {{ $profRecording->date_received > 0 ? 
                                            date('d-m-Y', strtotime($profRecording->date_received)) : '---' }}
                                    </td>
                                    <td class="kh">{{ $profRecording->prokah_num }}</td>
                                    <td class="kh">
                                        @if (!empty($profRecording->ref_document))
                                            <a href="{{ asset('storage/images/ref_documents/'.$profRecording->ref_document) }}" target="_blank"><u>@lang('common.view_file')</u></a>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-info btn-edit-tcp-prof" 
                                            data-edit-url="{{ route('tcp-professions.edit', [app()->getLocale(), $profRecording->tcp_prof_rec_id]) }}" 
                                            data-update-url="{{ route('tcp-professions.update', [app()->getLocale(), $profRecording->tcp_prof_rec_id]) }}">
                                            <i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                                        <button type="button" class="btn btn-xs btn-danger btn-delete" 
                                            data-route="{{ route('tcp-professions.destroy', [app()->getLocale(), $profRecording->tcp_prof_rec_id]) }}">
                                            <i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                                    </td>
                                </tr>

                            @endforeach
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="button" id="btn-add-tcp-profession" class="btn btn-sm btn-primary" 
                        data-add-url="{{ route('tcp-professions.store', app()->getLocale()) }}" 
                        style="width:120px;">
                        <i class="fa fa-plus"></i> @lang('button.add')
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
