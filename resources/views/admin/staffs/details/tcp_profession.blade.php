<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <strong>
                            {{ __('number.num4').'. '.__('tcp.profession') }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>{{ __('tcp.profession_category') }}</th>
                    <th>{{ __('common.description') }}</th>
                    <th>{{ __('common.prokah_num_only') }}</th>
                    <th>{{ __('common.date_obtained') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($staffTCPProfessions as $staffTCPProfession)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ !empty($staffTCPProfession->professionRank) ? 
                            $staffTCPProfession->professionRank->tcp_prof_rank_kh : '---' }}</td>
                        <td>{{ $staffTCPProfession->description }}</td>
                        <td>{{ $staffTCPProfession->prokah_num }}</td>
                        <td>{{ $staffTCPProfession->date_received > 0 ? 
                            date('d-m-Y', strtotime($staffTCPProfession->date_received)) : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
