<div class="row-box">
    <div class="row">
        <div class="col-sm-10">
            <div class="row">
                <!-- Payroll number -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="nid_card">
                            <span class="section-num">{{ __('number.num1') }}.</span>
                            {{ __('common.nid') }}
                            <span class="required">*</span>
                        </label>

                        {{ Form::text('nid_card', null, ["class" => "form-control ". ($errors->has('nid_card') ? ' is-invalid' : null), "autocomplete" => "off", "data-inputmask" => "'mask':'999999999'", "data-mask"]) }}
                    </div>
                </div>

                <!-- Bank account number -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="bank_account">
                            {{ __('common.bankacc_num') }}
                            <span class="required">*</span>
                        </label>
                        
                        {{ Form::text('bank_account', null, ['class' => 'form-control '.($errors->has('bank_account') ? ' is-invalid' : null), 'data-inputmask' => '"mask": "9999 99 999999 99"', 'data-mask']) }}
                    </div>
                </div>

                <!-- Name in Khmer -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="surname_kh">
                            <span class="section-num">{{ __('number.num2') }}.</span>
                            {{ __('common.surname_kh') }}
                            <span class="required">*</span>
                        </label>
                        
                        {{ Form::text('surname_kh', null, ['class' => 'form-control kh '.($errors->has('surname_kh') ? ' is-invalid' : null), 'maxlength' => '150']) }}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="name_kh">
                            {{ __('common.name_kh') }} <span class="required">*</span>
                        </label>
                        
                        {{ Form::text('name_kh', null, ['class' => 'form-control kh '.($errors->has('name_kh') ? ' is-invalid' : null), 'maxlength' => '150']) }}
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Name in Latin -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="surname_en">
                            {{ __('common.surname_latin') }}
                            <span class="required">*</span>
                        </label>
                        
                        {{ Form::text('surname_en', null, ['class' => 'form-control text-uppercase '.($errors->has('surname_en') ? ' is-invalid' : null), 'maxlength' => '50']) }}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="name_en">
                            {{ __('common.name_latin') }}
                            <span class="required">*</span>
                        </label>
                        
                        {{ Form::text('name_en', null, ['class' => 'form-control text-uppercase '.($errors->has('name_en') ? ' is-invalid' : null), 'maxlength' => '50']) }}
                    </div>
                </div>

                <!-- Gender -->
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('sex') ? 'has-error' : '' }}">
                        <label for="sex">
                            <span class="section-num">{{ __('number.num3') }}.</span>
                            {{ __('common.sex') }} <span class="required">*</span>
                        </label>

                        {{ Form::select('sex', ['' => __('common.choose'), '1' => 'ប្រុស', '2' => 'ស្រី'], null, ['class' => 'form-control select2', 'style' => 'width:100%;', 'id' => 'sex']) }}
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
                            {{ Form::text('dob', null, ['class' => 'form-control datepicker '.($errors->has('dob') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask']) }}
                            <div class="input-group-addon">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Ethnic -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="ethnic_id">{{ __('common.ethnic') }}</label>

                        {{ Form::select('ethnic_id', ['' =>  __('common.choose').' ...'] + $ethnics, 21, ['id' => 'ethnic_id', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                    </div>
                </div>

                <!-- Former staff -->
                <div class="col-sm-2" style="margin-top:37px;">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            {{ Form::checkbox('former_staff', '1', (isset($contract_teacher) ? $contract_teacher->former_staff : ''), ['id' => 'former_staff']) }}
                            <label for="former_staff">{{__('common.former_staff')}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff photo -->
        <div class="col-sm-2">
            @if (isset($contract_teacher))
                <div id="profile-photo" class="text-center">
                    <img id="image-thumbnail" class="img-thumbnail" src="{{ asset('storage/images/cont_staffs/'.$contract_teacher->photo) }}">
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
                <div id="profile-photo" class="text-center d-none">
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
                    <!-- <input id="profile_photo" name="profile_photo" type="file"> -->
                    {{ Form::file('profile_photo', ['id' => 'profile_photo']) }}
                </div>
            @endif
        </div>
    </div>
</div>