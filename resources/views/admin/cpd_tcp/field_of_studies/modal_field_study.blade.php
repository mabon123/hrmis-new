<div class="modal fade" id="modal_field_study">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {!! Form::open(['route' => ['cpd-field-of-studies.store', [app()->getLocale()]], 'method' => 'POST', 'id' => 'form_field_study']) !!}

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('cpd.field_of_study') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-box">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cpd_field_kh">{{ __('cpd.field_kh') }} 
                                    <span class="required">*</span></label>
                                <input type="text" name="cpd_field_kh" id="cpd_field_kh" class="form-control kh" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cpd_field_en">{{ __('cpd.field_en') }}</label>
                                <input type="text" name="cpd_field_en" id="cpd_field_en" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cpd_field_code">{{ __('cpd.field_code') }}
                                    <span class="required">*</span></label>
                                <input type="text" name="cpd_field_code" id="cpd_field_code" class="form-control" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="cpd_field_desc_kh">{{ __('cpd.field_desc_kh') }}</label>
                            <textarea name="cpd_field_desc_kh" id="cpd_field_desc_kh" class="form-control kh textarea" style="width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;"></textarea>
                        </div>

                        <div class="col-sm-12">
                            <label for="cpd_field_desc_en">{{ __('cpd.field_desc_en') }}</label>
                            <textarea name="cpd_field_desc_en" id="cpd_field_desc_en" class="form-control textarea" style="width:100%;font-size:14px;line-height:18px;border:1px solid #dddddd;padding:10px;"></textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix" style="margin-top:15px;">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="active" name="active" value="1" checked>
                                    <label for="active">{{__('login.active')}}</label>
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
            {{ Form::close() }}
        </div>
    </div>
</div>
