<div class="modal fade" id="modal-qualification">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post" id="frmCreateQualification" action="{{ route('qualifications.store', [app()->getLocale(), $staff->payroll_id]) }}">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('qualification.teaching_qual') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="prof_category_id">
                                        {{ __('qualification.prof_skill_desc') }}
                                        <span class="required">*</span>
                                    </label>

                                    <select class="form-control select2" name="prof_category_id" id="prof_category_id" style="width: 100%;" required>
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($professionalCats as $professionalCat)
                                            <option value="{{ $professionalCat->prof_category_id }}">
                                                {{ $professionalCat->prof_category_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="prof_date">
                                        {{ __('qualification.date_obtained') }}
                                        <span class="required">*</span>
                                    </label>

                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="prof_date" id="prof_date" class="datepicker form-control" placeholder="dd-mm-yyyy" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div id="subject-group" class="form-group">
                                    <label for="subject_id1">
                                        {{ __('qualification.first_subject') }}
                                        <span id="subject_req" class="required d-none">*</span>
                                    </label>

                                    <select class="form-control select2" name="subject_id1" id="subject_id1" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->subject_id }}">
                                                {{ $subject->subject_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="subject_id2">{{ __('qualification.second_subject') }}</label>

                                    <select class="form-control select2" name="subject_id2" id="subject_id2" style="width:100%;">
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
                                    <label for="prof_type_id">{{ __('qualification.training_sys') }} <span 
                                        class="required">*</span></label>

                                    <select class="form-control select2" name="prof_type_id" id="prof_type_id" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($professionalTypes as $professionalType)
                                            <option value="{{ $professionalType->prof_type_id }}">
                                                {{ $professionalType->prof_type_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="location_code">{{ __('common.development_school') }}</label>

                                    {{ Form::select('location_code', ['' => __('common.choose').' ...'] + $locations, null, ['id' => 'location_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
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
