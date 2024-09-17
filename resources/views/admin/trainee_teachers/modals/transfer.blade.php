<div class="modal fade" id="modalTransferTrainee">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form method="post" id="frmTransferTrainee" action="{{ route('trainees.transfer', [app()->getLocale()]) }}">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('trainee.failed_trainee_list') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label><h6>{{__('trainee.transfer_verified_msg')}}</h6></label>
                    <div class="row-box">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('common.payroll_num') }}</th>
                                        <th>{{ __('common.name') }}</th>
                                        <th>{{ __('common.fullname_en') }}</th>
                                        <th>{{ __('common.sex') }}</th>
                                        <th>{{ __('common.dob') }}</th>
                                        <th>{{ __('common.current_status') }}</th>
                                        <th>{{ __('qualification.subject') }}</th>
                                        <th>{{ __('common.pass_fail') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (isset($failTrainees))
                                        @foreach($failTrainees as $index => $trainee)

                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $trainee->trainee_payroll_id }}</td>
                                                <td class="kh">{{ $trainee->surname_kh.' '.$trainee->name_kh }}</td>
                                                <td>{{ $trainee->surname_en.' '.$trainee->name_en }}</td>
                                                <td class="kh">{{ $trainee->sex === 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                                <td>{{ date('d-m-Y', strtotime($trainee->dob)) }}</td>
                                                <td class="kh">{{ $trainee->status ? $trainee->status->trainee_status_kh : '' }}</td>
                                                <td class="kh">{{ $trainee->subject1 ? $trainee->subject1->subject_kh : '' }}</td>
                                                <td class="kh">{{ $trainee->result ? __('common.pass') : __('common.fail') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="9">{{ __('trainee.no_failed_trainees') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix">
                        <input type="hidden" value="0" name="verified">
                        <div class="icheck-primary d-inline">
                            {{ Form::checkbox('verified', 1, false, ['id' => 'verified']) }}
                            <label for="verified"><h6>{{__('common.agree')}}</h6></label>
                        </div>
                    </div>

                    <input type="hidden" name="location_code" value="{{ request()->location_code }}">
                    <input type="hidden" name="prof_type_id" value="{{ request()->prof_type_id }}">
                    <input type="hidden" name="stu_generation" value="{{ request()->stu_generation }}">
                    <input type="hidden" name="pro_code" value="{{ request()->pro_code }}">
                    <input type="hidden" name="dis_code" value="{{ request()->dis_code }}">
                    <input type="hidden" name="filter_by" value="{{ request()->filter_by }}">
                    <input type="hidden" name="keyword" value="{{ request()->keyword }}">
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        {{ __('button.close') }}
                    </button>

                    <button type="submit" id="btnTransfer" class="btn btn-primary" style="width:150px;" disabled>
                        {{-- <i class="far fa-paper-plane"></i>  --}}
                        {{ __('button.process') }}
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
