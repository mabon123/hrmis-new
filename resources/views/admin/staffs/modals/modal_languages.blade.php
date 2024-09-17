<div class="modal fade" id="modal-languages">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="frmCreateLanguage" action="{{ route('staff-language.store', [app()->getLocale(), $staff->payroll_id]) }}">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.foreign_language') }}</h4>

                    <span class="kh" style="margin-left:15px;">សំគាល់៖ A = ល្អ , B = មធ្យម , C = ខ្សោយ</span>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="language_id">
                                        {{ __('common.languages') }}
                                        <span class="required">*</span>
                                    </label>

                                    <select class="form-control select2" name="language_id" id="language_id" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        
                                        @foreach($languages as $language)
                                            <option value="{{ $language->language_id }}">
                                                {{ $language->language_kh }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="reading">{{ __('common.reading') }} <span class="required">*</span></label>

                                    <select class="form-control select2" name="reading" id="reading" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="writing">{{ __('common.writing') }} <span class="required">*</span></label>

                                    <select class="form-control select2" name="writing" id="writing" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="conversation">{{ __('common.conversation') }} <span class="required">*</span></label>

                                    <select class="form-control select2" name="conversation" id="conversation" style="width:100%;">
                                        <option value="">{{ __('common.choose') }} ...</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
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

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
