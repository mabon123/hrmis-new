<div class="row-box">
    <div class="row">
        <!-- Qualification -->
        <div class="col-sm-4">
            <div class="form-group">
                <label for="qualification_code">{{__('common.qualification')}} <span class="required">*</span></label>
                {{ Form::select('qualification_code', ['' => __('common.choose').' ...'] + $qualificationCodes, null, 
                    ['class' => 'form-control kh select2', 'id' => 'qualification_code', 'style' => 'width:100%', 'required' => true]) 
                }}
            </div>
        </div>

        <!-- Professional level -->
        <div class="col-sm-4">
            <div class="form-group">
                <label for="subject_id">@lang('common.professional_level')</label>
                {{ Form::select('subject_id', ['' => __('common.choose').' ...'] + $subjects, null, 
                    ['class' => 'form-control kh select2', 'id' => 'professional_level', 'style' => 'width:100%']) 
                }}
            </div>
        </div>

        <!-- Experience in year -->
        <div class="col-sm-4">
            <div class="form-group">
                <label for="experience">@lang('common.experience')</label>
                {{ Form::text('experience', null, ['class' => 'form-control kh', 'autocomplete' => 'off', 'id' => 'experience']) }}
            </div>
        </div>
    </div>
</div>
