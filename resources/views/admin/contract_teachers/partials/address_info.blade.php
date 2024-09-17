<div class="row">
    <!-- House number -->
    <div class="col-sm-2">
        <div class="form-group">
            <label for="house_num">{{ __('common.house_number') }}</label>

            {{ Form::text('house_num', null, ['class' => 'form-control kh', 'id' => 'house_num', 'maxlength' => 8]) }}
        </div>
    </div>

    <!-- Group number -->
    <div class="col-sm-2">
        <div class="form-group">
            <label for="group_num">{{ __('common.group_number') }}</label>

            {{ Form::text('group_num', null, ['class' => 'form-control kh', 'id' => 'group_num', 'maxlength' => 10]) }}
        </div>
    </div>

    <!-- Street name or number -->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="street_num">{{ __('common.street') }}</label>

            {{ Form::text('street_num', null, ['class' => 'form-control kh', 'id' => 'street_num', 'maxlength' => 50]) }}
        </div>
    </div>

    <!-- Province -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="adr_pro_code">{{ __('common.province') }}</label>

            {{ Form::select('adr_pro_code', ['' => __('common.choose').' ...'] + $provinces, null, ['class' => 'form-control kh select2', 'id' => 'pro_code', 'style' => 'width:100%', 'data-old-value' => old('adr_pro_code')]) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="adr_dis_code">{{ __('common.district') }}</label>

            {{ Form::select('adr_dis_code', ['' => __('common.choose').' ...'] + (isset($addr_dists) ? $addr_dists : []), null, ['class' => 'form-control kh select2', 'id' => 'dis_code', 'style' => 'width:100%', 'data-old-value' => old('adr_dis_code'), 'disabled' => isset($contract_teacher, $contract_teacher->adr_pro_code) ? false : true]) }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="adr_com_code">{{ __('common.commune') }}</label>

            {{ Form::select('adr_com_code', ['' => __('common.choose').' ...'] + (isset($addr_comms) ? $addr_comms : []), null, ['class' => 'form-control kh select2', 'id' => 'com_code', 'style' => 'width:100%', 'data-old-value' => old('adr_com_code'), 'disabled' => isset($contract_teacher, $contract_teacher->adr_dis_code) ? false : true]) }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="adr_vil_code">{{ __('common.village') }}</label>

            {{ Form::select('adr_vil_code', ['' => __('common.choose').' ...'] + (isset($addr_vills) ? $addr_vills : []), null, ['class' => 'form-control kh select2', 'id' => 'vil_code', 'style' => 'width:100%', 'data-old-value' => old('adr_vil_code'), 'disabled' => isset($contract_teacher, $contract_teacher->adr_com_code) ? false : true]) }}
        </div>
    </div>
</div>

<div class="row">
    <!-- Phone number -->
    <div class="col-md-4">
        <label for="phone">{{ __('common.telephone') }}</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>

            {{ Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'data-inputmask' => '"mask":["999-999-9999", "+855 99 999 9999"]', 'data-mask']) }}
        </div>
    </div>
</div>