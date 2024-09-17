<div class="modal fade" id="modal_details">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('menu.view_tcp_appraisals') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{ __('tcp.staff_name') }}
                                <span>:&nbsp;</span>
                                <span id="staff_name_position"> ffddf</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tcp_prof_rank_id">{{ __('tcp.appraisers') }}
                                <span>:</span>
                            </label>

                        </div>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th>{{ __('tcp.appraisal_score') }}</th>
                                <th>{{ __('tcp.ref_doc') }}</th>
                                <th>{{ __('tcp.additional_clarification') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="kh">{{ __('tcp.credits_qualification') }}</td>
                                <td id="td_cat1_score"></td>
                                <td id="td_cat1_ref_doc"></td>
                                <td id="td_cat1_note"></td>
                            </tr>
                            <tr>
                                <td class="kh">{{ __('tcp.credits_experience') }}</td>
                                <td id="td_cat2_score"></td>
                                <td id="td_cat2_ref_doc"></td>
                                <td id="td_cat2_note"></td>
                            </tr>
                            <tr>
                                <td class="kh">{{ __('tcp.credits_achievement') }}</td>
                                <td id="td_cat3_score"></td>
                                <td id="td_cat3_ref_doc"></td>
                                <td id="td_cat3_note"></td>
                            </tr>
                            <tr>
                                <td class="kh">{{ __('tcp.credits_job_outcome') }}</td>
                                <td id="td_cat4_score"></td>
                                <td id="td_cat4_ref_doc"></td>
                                <td id="td_cat4_note"></td>
                            </tr>
                            <tr>
                                <td class="kh">{{ __('tcp.credits_prof_competence') }}</td>
                                <td id="td_cat5_score"></td>
                                <td id="td_cat5_ref_doc"></td>
                                <td id="td_cat5_note"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span>{{ __('tcp.appraisal_ref_doc') }}</span>
                        <span id="span_appraisal_ref_doc" colspan="3"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>