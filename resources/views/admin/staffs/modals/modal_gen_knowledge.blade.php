<div class="modal fade" id="modal-gen-knowledge">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post" id="frmCreateGenKnowledge" action="{{ route('general-knowledge.store', [app()->getLocale(), $staff->payroll_id]) }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.general_knowledge') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="qualification_code">
                                        {{ __('common.qualification') }}
                                        <span class="required">*</span>
                                    </label>

                                    <select class="form-control select2" name="qualification_code" id="qualification_code" style="width: 100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($qualificationCodes as $qualificationCode)
                                            <option value="{{ $qualificationCode->qualification_code }}">
                                                {{ $qualificationCode->qualification_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div id="subject-group" class="form-group">
                                    <label for="subject_id">
                                        {{ __('common.skill') }} <span id="skill_req" class="required d-none">*</span>
                                    </label>

                                    <select class="form-control select2" name="subject_id" id="subject_id" style="width: 100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->subject_id }}">
                                                {{ $subject->subject_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="qual_date">
                                        {{ __('common.date_obtained') }}
                                        <span class="required">*</span>
                                    </label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="qual_date" id="qual_date" class="datepicker form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="country_id">{{ __('common.country') }}</label>

                                    <select class="form-control select2" name="country_id" id="country_id" style="width: 100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>

                                        @foreach($countries as $country)
                                            <option value="{{ $country->country_id }}">
                                                {{ $country->country_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="location_kh">{{ __('common.development_school') }}</label>

                                    {{ Form::text('location_kh', null, ['id' => 'location_kh', 'class' => 'form-control kh', 'maxlength' => 150]) }}
                                </div>
                            </div>

                            <!-- Prokah attach document -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="qual_doc">
                                        @lang('common.prokah_attachment')
                                        <strong><span id="ref-name"></span></strong>
                                    </label>
                                    <input type="file" class="form-control" name="qual_doc" id="qual_doc" accept="application/pdf,application/vnd.ms-excel">
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
