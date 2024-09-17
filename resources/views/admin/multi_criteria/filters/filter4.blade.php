<div class="row justify-content-md-center">
    <!-- Fields -->
    <div class="col-sm-3">
        <div class="form-group">
            <label for="fourth_field">{{ __('common.table_field') }}</label>
            <select name="fourth_field" id="fourth_field" class="form-control select2 kh" style="width:100%;">
                <option value="">{{ __('common.choose') }}</option>
                @foreach ($reportFields as $reportField)
                    <option value="{{ $reportField->table_name.'.'.$reportField->field_name }}" 
                        data-field="{{ $reportField->is_date_field }}" data-section="fourth">
                        {{ $reportField->title_kh }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Operators -->
    <div class="col-sm-2">
        <div class="form-group">
            <label for="fourth_operator">{{ __('common.operator') }}</label>
            {{ Form::select('fourth_operator', ['' => __('common.choose').' ...'], request()->fourth_operator, 
                ['id' => 'fourth_operator', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
        </div>
    </div>

    <!-- Values -->
    <div class="col-sm-3">
        <div class="form-group">
            <label for="fourth_value">{{ __('common.value') }}</label>
            <div class="select2-blue">
                <div id="fourth_multiple">
                    {{ Form::select('fourth_value[]', [], null, 
                        ['id' => 'fourth_value_0', 'class' => 'select2 kh', 'style' => 'width:100%;', 
                        'multiple' => 'multiple', 'data-dropdown-css-class' => 'select2-blue']) 
                    }}
                </div>
                <div id="fourth_single" class="d-none">
                    {{ Form::text('fourth_value[]', null, 
                        ['id' => 'fourth_value_0', 'class' => 'form-control kh']) 
                    }}
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="col-sm-auto">
        <div class="form-group">
            <button type="button" class="btn btn-sm" id="btn-fourth-remove-0" style="margin-top:32px;" title="Remove Value">
                <i class="far fa-times-circle" style="color:red;font-size:25px;"></i></button>
        </div>
    </div>
</div>

<!-- New Value 4 -->
<div id="section-fourth-value"></div>
<div class="row justify-content-md-center">
    <div class="col-sm-9" style="border-bottom:2px #666 solid;margin-bottom:15px;max-width:70%;"></div>
    <div class="col-sm-9" style="padding-left:0;max-width:70%;">
        <div class="form-group">
            <div class="icheck-primary d-inline">
                <input type="checkbox" name="fourth_and" id="fourth_and" value="1">
                <label for="fourth_and"><strong>AND</strong></label>
            </div>
        </div>
    </div>
</div>
