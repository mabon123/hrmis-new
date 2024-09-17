<div class="row justify-content-md-center">
    <!-- Fields -->
    <div class="col-sm-3">
        <div class="form-group">
            <label for="first_field">{{ __('common.table_field') }} <span class="required">*</span></label>
            <select name="first_field" id="first_field" class="form-control select2 kh" style="width:100%;" required>
                <option value="">{{ __('common.choose') }}</option>
                @foreach ($reportFields as $reportField)
                    <option value="{{ $reportField->table_name.'.'.$reportField->field_name }}" 
                        data-field="{{ $reportField->is_date_field }}" data-section="first">
                        {{ $reportField->title_kh }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Operators -->
    <div class="col-sm-2">
        <div class="form-group">
            <label for="first_operator">{{ __('common.operator') }} <span class="required">*</span></label>
            {{ Form::select('first_operator', ['' => __('common.choose').' ...'], request()->first_operator, 
            	['id' => 'first_operator', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
                'required' => true]) }}
        </div>
    </div>

    <!-- Values -->
    <div class="col-sm-3">
        <div class="form-group">
            <label for="first_value">{{ __('common.value') }} <span class="required">*</span></label>
            <div class="select2-blue">
                <div id="first_multiple">
                    {{ Form::select('first_value[]', [], null, 
                        ['id' => 'first_value_0', 'class' => 'select2 kh', 'style' => 'width:100%;', 
                        'multiple' => 'multiple', 'data-dropdown-css-class' => 'select2-blue', 
                        'required' => true]) 
                    }}
                </div>
                <div id="first_single" class="d-none">
                    {{ Form::text('first_value[]', null, 
                        ['id' => 'first_value_0', 'class' => 'form-control kh', 'required' => true]) 
                    }}
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="col-sm-auto">
        <div class="form-group">
            <button type="button" class="btn btn-sm" id="btn-first-remove-0" style="margin-top:32px;" title="Remove Value">
                <i class="far fa-times-circle" style="color:red;font-size:25px;"></i></button>
        </div>
    </div>
</div>

<!-- New Value 1 -->
<div id="section-first-value"></div>
<div class="row justify-content-md-center">
    <div class="col-sm-9" style="border-bottom:2px #666 solid;margin-bottom:15px;max-width:70%;"></div>
    <div class="col-sm-9" style="padding-left:0;max-width:70%;">
        <div class="form-group">
            <div class="icheck-primary d-inline">
                <input type="checkbox" name="first_and" id="first_and" value="1">
                <label for="first_and"><strong>AND</strong></label>
            </div>
        </div>
    </div>
</div>
