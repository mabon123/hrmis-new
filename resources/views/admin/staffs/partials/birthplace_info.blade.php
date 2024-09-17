<div class="row row-box">
	<div class="col-md-12">
        <h4><span class="section-num">@lang('number.num2'). </span>{{ __('common.pob') }}</h4>
        
        <div class="row">
            <!-- Province -->
            <div class="col-sm-3">
                <div class="form-group @error('birth_pro_code') has-error @enderror">
                    <label for="birth_pro_code">
                        {{ __('common.province') }} <span class="required">*</span>
                    </label>

                    {{ Form::select('birth_pro_code', ['' => __('common.choose').' ...'] + $provinces, null, ['class' => 'form-control kh select2', 'id' => 'pro_code_autocomplete', 'data-lang' => app()->getLocale(), 'data-old-value' => old('birth_pro_code')]) }}
                </div>
            </div>

            <!-- District -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="birth_district">
                        {{ __('common.district') }} <span class="required">*</span>
                    </label>

                    {{ Form::text('birth_district', null, ['class' => 'form-control kh​ '.($errors->has('birth_district') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'birth_district']) }}
                </div>
            </div>

            <!-- Commune -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="birth_commune">{{ __('common.commune') }}</label>

                    {{ Form::text('birth_commune', null, ['class' => 'form-control kh', 'autocomplete' => 'off', 'id' => 'birth_commune']) }}
                </div>
            </div>

            <!-- Village -->
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="birth_village">{{ __('common.village') }}</label>
                    
                    {{ Form::text('birth_village', null, ['class' => 'form-control kh', 'autocomplete' => 'off', 'id' => 'birth_village']) }}
                </div>
            </div>
        </div>
    </div>
</div>
