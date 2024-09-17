<div class="row justify-content-md-center">
    <!-- Fields -->
    <div class="col-sm-3">
        <div class="form-group">
            <label for="fifth_field">{{ __('common.table_field') }}</label>
            <select name="fifth_field" id="fifth_field" class="form-control select2 kh" style="width:100%;">
                <option value="">{{ __('common.choose') }}</option>
                @foreach ($reportFields as $reportField)
                    <option value="{{ $reportField->table_name.'.'.$reportField->field_name }}" 
                        data-field="{{ $reportField->is_date_field }}" data-section="fifth">
                        {{ $reportField->title_kh }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Operators -->
    <div class="col-sm-2">
        <div class="form-group">
            <label for="fifth_operator">{{ __('common.operator') }}</label>
            {{ Form::select('fifth_operator', ['' => __('common.choose').' ...'], request()->fifth_operator, 
                ['id' => 'fifth_operator', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
        </div>
    </div>

    <!-- Values -->
    <div class="col-sm-3">
        <div class="form-group">
            <label for="fifth_value">{{ __('common.value') }}</label>
            <div class="select2-blue">
                <div id="fifth_multiple">
                    {{ Form::select('fifth_value[]', [], null, 
                        ['id' => 'fifth_value_0', 'class' => 'select2 kh', 'style' => 'width:100%;', 
                        'multiple' => 'multiple', 'data-dropdown-css-class' => 'select2-blue']) 
                    }}
                </div>
                <div id="fifth_single" class="d-none">
                    {{ Form::text('fifth_value[]', null, 
                        ['id' => 'fifth_value_0', 'class' => 'form-control kh']) 
                    }}
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="col-sm-auto">
        <div class="form-group">
            <button type="button" class="btn btn-sm" id="btn-fifth-remove-0" style="margin-top:32px;" title="Remove Value">
                <i class="far fa-times-circle" style="color:red;font-size:25px;"></i></button>
        </div>
    </div>
</div>

<!-- New Value 5 -->
<div id="section-fifth-value"></div>

<div class="row justify-content-md-center text-center" style="margin-top:15px;">
    <div class="col-sm-3">
        <div class="form-group">
            <button type="button" class="btn btn-secondary" id="btn-add-report-fields" style="width:250px;">
                <i class="fas fa-cog"></i> Add Report Fields</button>
        </div>
    </div>
</div>
