<div class="modal fade" id="modalCreateTCPProfession">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="{{ route('tcp-professions.store', [app()->getLocale()]) }}" 
                id="frmCreateTCPProfession" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('tcp.create_profession') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="payroll_id" value="{{ $staff->payroll_id }}">

                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <!-- TCP Profession Category -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tcp_prof_cat_id">{{ __('tcp.profession_category') }} 
                                        <span class="required">*</span></label>

                                    {{ Form::select('tcp_prof_cat_id', 
                                        ['' => __('common.choose').' ...'] + $profCategories, null, 
                                        ['id' => 'tcp_prof_cat_id', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;', 'required' => true]) 
                                    }}
                                </div>
                            </div>

                            <!-- TCP Profession Rank -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tcp_prof_rank_id">{{ __('tcp.profession_rank') }} 
                                        <span class="required">*</span></label>

                                    {{ Form::select('tcp_prof_rank_id', 
                                        ['' => __('common.choose').' ...'] + $profRanks, null, 
                                        ['id' => 'tcp_prof_rank_id', 'class' => 'form-control kh select2', 
                                            'style' => 'width:100%;', 'required' => true]) 
                                    }}
                                </div>
                            </div>

                            <!-- Received Date -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="date_received">{{ __('common.date_obtained') }} 
                                        <span class="required">*</span></label>

                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                        {{ Form::text('date_received', null, 
                                            ['id' => 'date_received', 'class' => 'form-control datepicker', 
                                                'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 
                                                'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 
                                                'required' => true]) 
                                        }}
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Official rank -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="prokah_num">{{ __('common.prokah_num') }} 
                                        <span class="required">*</span></label>

                                    {{ Form::text('prokah_num', null, 
                                        ['id' => 'tcp_prof_prokah_num', 'class' => 'form-control kh', 'maxlength' => '50', 
                                            'required' => true]) 
                                    }}
                                </div>
                            </div>

                            <!-- Referrence Document -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ref_document">
                                        {{ __('common.prokah_attachment').'( PDF or JPG / PNG)' }}
                                        <strong><span id="ref-name"></span></strong>
                                        <span class="required">*</span>
                                    </label>
                                    {{ Form::file('ref_document', 
                                        ['id' => 'ref_document', 'class' => 'form-control', 'required' => true]) 
                                    }}
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description">{{ __('common.description') }} 
                                        <span class="required">*</span></label>
                                    
                                    {{ Form::textarea('description', null, 
                                        ['id' => 'description', 'class' => 'form-control', 'rows' => 5, 
                                            'maxlength' => '250', 'required' => true]) 
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-info" style="width:150px;">
                        <i class="far fa-save"></i> {{ __('button.save') }}
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
