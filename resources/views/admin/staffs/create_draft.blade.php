@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('common.personal_details') }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
                            {{ __('menu.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('menu.staff_info') }}</li>
                    <li class="breadcrumb-item active">{{ __('menu.new_staff') }}</li>
                </ol>

            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button style="position: relative; top: -20px;" class="close" data-dismiss="alert"
                    type="button">×</button>
            </div><br />
            @endif

            @if (session()->has('success'))
            <div class="alert alert-success">
                @if(is_array(session()->get('success')))
                <ul>
                    @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @else
                {{ session()->get('success') }}
                @endif
                <button class="close" data-dismiss="alert" type="button">×</button>
            </div>
            @endif
        </div>
    </div>

    <form enctype="multipart/form-data" method="post" action="{{ route('staffs.store', app()->getLocale()) }}">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('common.basic_info') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="payroll_num">1. {{__('common.payroll_num')}} <span
                                                    style="color:#f00">*</span></label>
                                            <input type="number" name="payroll_num" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="nid">{{__('common.nid')}} </label>
                                            <input type="number" name="nid" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="bankacc_num">{{__('common.bankacc_num')}}</label>
                                            <input type="number" name="bankacc_num" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="sex"> {{__('common.current_status')}} <span
                                                    style="color:#f00">*</span></label>
                                            <select name="sex" class="form-control select2">
                                                <option value="" selected="selected">{{ __('common.choose') }} ...
                                                </option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="surname_kh">2. {{__('common.surname_kh')}} <span
                                                    style="color:#f00">*</span></label>
                                            <input type="text" name="surname_kh" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name_kh">{{__('common.name_kh')}} <span
                                                    style="color:#f00">*</span></label>
                                            <input type="text" name="name_kh" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="surname_latin">{{__('common.surname_latin')}} <span
                                                    style="color:#f00">*</span></label>
                                            <input type="text" name="surname_latin" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name_latin">{{__('common.name_latin')}} <span
                                                    style="color:#f00">*</span></label>
                                            <input type="text" name="name_latin" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="sex">3. {{__('common.sex')}} <span
                                                    style="color:#f00">*</span></label>
                                            <select name="sex" class="form-control select2">
                                                <option value="" selected="selected">{{ __('common.choose') }} ...
                                                </option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="dob">{{__('common.dob')}}<span
                                                    style="color:#f00">*</span>(dd/mm/yyyy)</label>
                                            <div class="input-group date" data-provide="datepicker"
                                                data-date-format="dd/mm/yyyy">
                                                <input type="text" autocomplete="off" name="dob"
                                                    class="datepicker form-control">
                                                <div class="input-group-addon">
                                                    <span class="far fa-calendar-alt"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="ethnic">{{__('common.ethnic')}}</label>
                                            <select class="form-control select2" style="width: 100%;">
                                                <option value="" selected="selected">{{ __('common.choose') }} ...
                                                </option>
                                                <option>Alaska</option>
                                                <option>California</option>
                                                <option>Delaware</option>
                                                <option>Tennessee</option>
                                                <option>Texas</option>
                                                <option>Washington</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group btn-upload">
                                    <div class="up-icons">
                                        <i class="flaticon-upload"></i>
                                        <label>{{ __('common.choose_photo') }}</label><br>
                                    </div>
                                    <input id="file_upload" name="doc_src" type="file">
                                </div>
                                <div id="upload_list"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">4. {{ __('common.pob') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pro_code">{{__('common.province')}} <span
                                            style="color:#f00">*</span></label>
                                    <select class="form-control select2">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="dis_code">{{__('common.district')}}<span
                                            style="color:#f00">*</span></label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="com_code">{{__('common.commune')}}</label>
                                    <select class="form-control select2">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="vil_code">{{__('common.village')}}</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> {{ __('common.work_info') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="datestart_work">5. {{__('common.datestart_work')}}</label>
                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="datestart_work"
                                            class="datepicker form-control">
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="appointment_date">6. {{__('common.appointment_date')}}</label>
                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="appointment_date"
                                            class="datepicker form-control">
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="com_code">7. {{__('common.current_location')}}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control rounded-0">
                                        <span class="input-group-append">
                                            <button type="button"
                                                class="btn btn-default btn-flat">{{ __('common.choose') }}...</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="vil_code">8. {{__('common.office')}}</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="appointment_date">9. {{__('common.status')}}</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="com_code">10. {{__('common.position')}}</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 div-checkbox">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="current_position" checked>
                                        <label for="current_position">{{__('common.cur_position')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 div-checkbox">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="prokah">
                                        <label for="prokah">{{__('common.prokah')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="vil_code"> {{__('common.position_equal')}}</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="position_level"> {{__('common.position_level')}}</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="code_position_level">{{__('common.code_position_level')}}</label>
                                    <input type="number" name="code_position_level" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="last_promotion_date"> {{__('common.last_promotion_date')}}</label>
                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="last_promotion_date"
                                            class="datepicker form-control">
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('common.salary_info') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="salary_type">11. {{__('common.salary_type')}} </label>
                                    <select class="form-control select2">
                                        <option value="" selected="selected">{{ __('common.choose') }} ...</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="degree">{{__('common.degree')}}</label>
                                    <input type="number" name="degree" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="promotion_date_cycle">12. {{__('common.promotion_date_cycle')}}</label>
                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="promotion_date_cycle"
                                            class="datepicker form-control">
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="certificate_promotion">{{__('common.certificate_promotion')}}</label>
                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="certificate_promotion"
                                            class="datepicker form-control">
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="code_num">{{__('common.code_num')}} </label>
                                    <input type="number" name="code_num" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="dis_code">{{__('common.sign_date')}}</label>
                                    <div class="input-group date" data-provide="datepicker"
                                        data-date-format="dd/mm/yyyy">
                                        <input type="text" autocomplete="off" name="sign_date"
                                            class="datepicker form-control">
                                        <div class="input-group-addon">
                                            <span class="far fa-calendar-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="rank_num">{{__('common.rank_num')}}</label>
                                    <input type="number" name="rank_num" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('common.other_info') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="teaching" name="teaching">
                                        <label for="teaching">13. {{__('common.teaching')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 teaching-box">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" name="pre_school" type="checkbox">
                                                <label class="form-check-label">{{__('common.pre_school')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="class1" type="checkbox">
                                                        <label class="form-check-label">{{__('number.num1')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="class2" type="checkbox">
                                                        <label class="form-check-label">{{__('number.num2')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="class3" type="checkbox">
                                                        <label class="form-check-label">{{__('number.num3')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="class4" type="checkbox">
                                                        <label class="form-check-label">{{__('number.num4')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="class5" type="checkbox">
                                                        <label class="form-check-label">{{__('number.num5')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="class6" type="checkbox">
                                                        <label class="form-check-label">{{__('number.num6')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="p_year1" type="checkbox">
                                                        <label class="form-check-label">{{__('common.p_year1')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="p_year2" type="checkbox">
                                                        <label class="form-check-label">{{__('common.p_year2')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="p_year3" type="checkbox">
                                                        <label class="form-check-label">{{__('common.p_year3')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="class_incharge"
                                                            type="checkbox">
                                                        <label
                                                            class="form-check-label">{{__('common.class_incharge')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="technical_lead"
                                                            type="checkbox">
                                                        <label
                                                            class="form-check-label">{{__('common.technical_lead')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
    </form>
</section>

@endsection

@push('scripts')

@endpush