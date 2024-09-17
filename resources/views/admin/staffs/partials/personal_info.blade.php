<div class="row row-box">
	<div class="col-md-12">
        <h4><span class="section-num">@lang('number.num1').</span> {{ __('common.basic_info') }}</h4>

        <div class="row">
            <div class="col-sm-10">
                <div class="row">
                    <!-- Payroll number -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="payroll_id">
                                {{ __('common.payroll_num') }}
                                <span class="required">*</span>
                            </label>

                            {{ Form::number('payroll_id', null, 
                                ['id' => 'payroll_id', 'class' => 'form-control ' . ($errors->has('payroll_id') ? 'is-invalid' : null), 
                                    'disabled' => ((auth()->user()->hasRole('administrator') or !isset($staff)) ? false : true)]) 
                            }}
                        </div>
                    </div>

                    <!-- National id number -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="nid_card">{{ __('common.nid') }}</label>

                            {{ Form::text('nid_card', null, ['id' => 'nid_card', 'class' => 'form-control', 'autocomplete' => 'off', 'data-inputmask' => '"mask": "999999999"', 'data-mask' => true]) }}
                        </div>
                    </div>

                    <!-- Bank account number -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="bank_account">{{__('common.bankacc_num')}}</label>

                            {{ Form::text('bank_account', null, ['id' => 'bank_account', 'class' => 'form-control', 'autocomplete' => 'off', 'data-inputmask' => '"mask": "9999 99 999999 99"', 'data-mask' => true]) }}
                        </div>
                    </div>

                    <!-- Staff staus -->
                    <div class="col-sm-3">
                        <div class="form-group @error('staff_status_id') has-error @enderror">
                            <label for="staff_status_id"> {{__('common.current_status')}} <span class="required">*</span></label>

                            @if (isset($staff))
                                <?php /* ?>
                                @if ($staff->staff_status_id == 2 or $staff->staff_status_id == 10 or $staff->staff_status_id == 8 or $staff->staff_status_id == 11)

                                    {{ Form::select('staff_status_id', [$staff->staff_status_id => $staff->status->status_kh, '1' => 'សកម្ម'], $staff->staff_status_id, ['id' => 'staff_status_id', 'class' => 'form-control kh select2', 'style' => 'width:100%']) }}

                                @else
                                    {{ Form::text('staff_status_id', $staff->status->status_kh, ['class' => 'form-control kh', 'disabled' => true]) }}
                                @endif
                                <?php */ ?>
                                {{ Form::text('staff_status_id', $staff->status->status_kh, ['class' => 'form-control kh', 'disabled' => true]) }}
                            @else
                                {{ Form::select('staff_status_id', ['1' => 'សកម្ម'], null, ['id' => 'staff_status_id', 'class' => 'form-control kh select2', 'style' => 'width:100%']) }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Name in Khmer -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="surname_kh">
                                {{ __('common.surname_kh') }}
                                <span class="required">*</span>
                            </label>

                            {{ Form::text('surname_kh', null, ['id' => 'surname_kh', 'class' => 'form-control kh '.($errors->has('surname_kh') ? 'is-invalid' : null), 'maxlength' => 150, 'autocomplete' => 'off']) }}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name_kh">
                                {{ __('common.name_kh') }} <span class="required">*</span>
                            </label>

                            {{ Form::text('name_kh', null, ['id' => 'name_kh', 'class' => 'form-control kh '.($errors->has('name_kh') ? 'is-invalid' : null), 'maxlength' => 150, 'autocomplete' => 'off']) }}
                        </div>
                    </div>

                    <!-- Name in Latin -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="surname_en">
                                {{ __('common.surname_latin') }}
                                <span class="required">*</span>
                            </label>

                            {{ Form::text('surname_en', null, ['id' => 'surname_en', 'class' => 'form-control text-uppercase '.($errors->has('surname_en') ? 'is-invalid' : null), 'maxlength' => 50, 'autocomplete' => 'off']) }}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name_en">
                                {{ __('common.name_latin') }}
                                <span class="required">*</span>
                            </label>

                            {{ Form::text('name_en', null, ['id' => 'name_en', 'class' => 'form-control text-uppercase '.($errors->has('name_en') ? 'is-invalid' : null), 'maxlength' => 50, 'autocomplete' => 'off']) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Gender -->
                    <div class="col-sm-3">
                        <div class="form-group @error('sex') has-error @enderror">
                            <label for="sex">
                                {{ __('common.sex') }} <span class="required">*</span>
                            </label>

                            {{ Form::select('sex', ['' => __('common.choose').' ...', '1' => 'ប្រុស', '2' => 'ស្រី'], null, ['class' => 'form-control kh select2', 'style' => 'width:100%;', 'id' => 'sex']) }}
                        </div>
                    </div>

                    <!-- Date of birth -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="dob">
                                {{ __('common.dob') }}
                                <span class="required">*</span>(dd-mm-yyyy)
                            </label>

                            <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                {{ Form::text('dob', null, 
                                    ['class' => 'form-control datepicker '.($errors->has('dob') ? ' is-invalid' : null), 
                                    'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 
                                    'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 
                                    'disabled' => ((auth()->user()->hasRole('administrator') or !isset($staff)) ? false : true)]) 
                                }}
                                <div class="input-group-addon">
                                    <span class="far fa-calendar-alt"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ethnic -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="ethnic_id">{{ __('common.ethnic') }}</label>

                            {{ Form::select('ethnic_id', ['' =>  __('common.choose').' ...'] + $ethnics, 
                                (isset($staff) ? $staff->ethnic_id : 21), 
                                ['id' => 'ethnic_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                        </div>
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>
            </div>

            <!-- Staff photo -->
            <div class="col-sm-2">
            	@if (isset($staff) and !empty($staff->photo))
                    <input type="hidden" name="profile_photo_asset" id="profile_photo_asset" value="{{ $staff->photo }}">

            		<div id="profile-photo-sec" class="text-center">
                        <img id="image-thumbnail" class="img-thumbnail" src="{{ asset('storage/images/staffs/'.$staff->photo) }}">
                        <button type="button" id="btn-cancel-profile" class="btn btn-danger btn-xs" style="width:90px;margin-top:15px;">
                            <i class="far fa-times-circle"></i> Remove
                        </button>
                    </div>

                    <div class="form-group upload-section d-none">
                        <div class="profile-icon">
                            <p><i class="fas fa-cloud-upload-alt" style="margin:0;font-size:32px;color:#0a7698;"></i></p>
                            {{ __('common.choose_photo') }}</label><br>
                        </div>
                        <input id="profile_photo" name="profile_photo" type="file">
                    </div>
            	@else
	                <div id="profile-photo-sec" class="text-center d-none">
	                    <img id="image-thumbnail" class="img-thumbnail">
	                    <button type="button" id="btn-cancel-profile" class="btn btn-danger btn-xs" style="width:90px;margin-top:15px;">
	                        <i class="far fa-times-circle"></i> Cancel
	                    </button>
	                </div>

	                <div class="form-group upload-section">
	                    <div class="profile-icon">
	                        <p><i class="fas fa-cloud-upload-alt" style="margin:0;font-size:32px;color:#0a7698;"></i></p>
	                        {{ __('common.choose_photo') }}</label><br>
	                    </div>
	                    <input id="profile_photo" name="profile_photo" type="file">
	                </div>
                @endif
            </div>
        </div>
    </div>
</div>
