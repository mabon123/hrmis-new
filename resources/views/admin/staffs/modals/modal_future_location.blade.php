<form method="post" id="frmEditFutureLocation" action="">
    @csrf

    <div class="modal fade" id="modal-future-location">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('trainee.edit_future_location') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="future_location_code">
                                        {{ __('trainee.future_location') }}
                                        <span class="required">*</span>
                                    </label>

                                    {{ Form::select(
                                        'future_location_code',
                                        ['' => __('common.choose')] + $locations,
                                        null,
                                        [
                                            "class" => "form-control kh select2",
                                            'id' => 'future_location_code',
                                            'style' => 'width:100%;',
                                            'required' => true,
                                        ])
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" id="btnClose" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        {{ __('button.close') }}
                    </button>

                    <button type="submit" id="btnSave" class="btn btn-primary" style="width:150px;" disabled>
                        {{ __('button.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>
