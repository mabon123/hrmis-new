<div class="modal fade" id="modal-new-location">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => ['staffs.acceptTransfer', [app()->getLocale()]], 'method' => 'PUT', 'id' => 'frmChooseNewLocation']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('staff.choose_new_location') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Province -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="pro_code">{{ __('common.province') }}</label>
                                {{ Form::select('pro_code', $provinces, null, 
                                    ['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
                                    'disabled' => (auth()->user()->hasRole('poe-admin', 'central-admin') ? true : false)]) 
                                }}
                            </div>
                        </div>

                        <!-- District -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="dis_code">{{ __('common.district') }}</label>
                                {{ Form::select('dis_code', ['' => __('common.choose').' ...'] + $districts, null, [
                                    'id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) }}
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="location_code">{{ __('staff.new_location') }} <span class="required">*</span></label>
                                {{ Form::select('location_code', ['' => __('common.choose').' ...'] + $locations, null, 
                                    ['id' => 'location_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
                                    'disabled' => true, 'required']) 
                                }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="submit" id="btnTransfer" class="btn btn-primary" style="width:150px;">
                        <i class="far fa-save"></i> {{ __('button.save') }}
                    </button>
                </div>
            {{ Form::close() }}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
