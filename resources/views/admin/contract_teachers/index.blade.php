@extends('layouts.admin')

@section('content')
    
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fa fa-file"></i> {{ __('menu.contract_teacher_info') }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('index', app()->getLocale()) }}">
                                <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('contract-teachers.index', app()->getLocale()) }}">
                                <i class="nav-icon fas fa-users"></i> {{ __('menu.contract_teacher_info') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('common.search_cont_teacher') }}</li>
                    </ol>

                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <form id="frmSearchContTeacher" action="{{ route('contract-teachers.index', app()->getLocale()) }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('common.search_cont_teacher') }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
                            <input type="hidden" name="search" value="true">
                            
                            <div class="row">
                                <!-- Province -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pro_code">{{ __('common.province') }}</label>

                                        {{ Form::select('pro_code', $provinces, request()->pro_code, 
                                            ['id' => 'pro_code', 'class' => 'form-control kh select2 procode_location', 'style' => 'width:100%;', 
                                                'disabled' => (count($provinces) == 1 ? true : false)]) 
                                        }}
                                    </div>
                                </div>

                                <!-- District -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dis_code">{{ __('common.district') }}</label>

                                        {{ Form::select('dis_code', $districts, request()->dis_code, 
                                            ['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
                                                'disabled' => (auth()->user()->hasRole('doe-admin')
                                                    or auth()->user()->hasRole('school-admin')) ? true : 
                                                    ((auth()->user()->hasRole('poe-admin') or request()->pro_code) ? false : true)
                                            ]) 
                                        }}
                                    </div>
                                </div>

                                <!-- Contract type -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="contract_type_id"> {{__('common.contract_type')}}</label>

                                        {{ Form::select('contract_type_id', ['' => __('common.choose').' ...'] + $contTypes, request()->contract_type_id, ['class' => 'form-control kh select2', 'id' => 'contract_type_dropdown', 'style' => 'width:100%', 'data-old-value' => old('contract_type_id')]) }}
                                    </div>
                                </div>

                                <!-- Contract skill -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cont_pos_id">@lang('common.contract_position')</label>

                                        {{ Form::select('cont_pos_id', ['' => __('common.choose').' ...'] + $contPositions, request()->cont_pos_id, ['class' => 'form-control kh select2', 'id' => 'cont_pos_id', 'style' => 'width:100%', 'disabled' => request()->contract_type_id ? false : true]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Current location -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="location_code">{{ __('common.current_location') }}</label>

                                        {{ Form::select('location_code', $locations, request()->location_code, 
                                            ['id' => 'location_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
                                                'disabled' => auth()->user()->hasRole('school-admin', 'dept-admin') ? true : false]) 
                                        }}
                                    </div>
                                </div>

                                <!-- Filter by -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="filter_by">{{ __('common.filter_by') }}</label>

                                        <?php
                                            $filters = [
                                                '' => __('common.choose'),
                                                'surname_kh' => __('common.surname_kh'),
                                                'name_kh' => __('common.name_kh'),
                                                'surname_en' => __('common.surname_latin'),
                                                'name_en' => __('common.name_latin'),
                                                'fullnamekh' => __('គោត្តនាម នាម (ខ្មែរ)'),
                                                'fullnameen' => __('គោត្តនាម នាម (ឡាតាំង)')
                                            ];
                                        ?>

                                        {{ Form::select('filter_by', $filters, request()->filter_by, ['class' => 'form-control kh select2', 'style' => 'width:100%;', 'id' => 'filter_dropdown']) }}
                                    </div>
                                </div>

                                <!-- Search keyword -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="keyword">{{__('common.filter_value')}}</label>

                                        {{ Form::text('keyword', request()->keyword, ['id' => 'keyword', 'class' => 'form-control kh', 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-danger" style="width:160px;">
                                <i class="fa fa-undo"></i>&nbsp;{{ __('button.reset') }}
                            </button>

                            <button type="submit" class="btn btn-info" style="width:180px;" onclick="loadModalOverlay();">
                                <i class="fa fa-search"></i>&nbsp;{{ __('button.search') }}
                            </button>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </form>


        <!-- Staff listing -->
        @if( count($contTeachers) > 0 )

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('common.payroll_num') }}</th>
                                    <th>{{ __('common.name') }}</th>
                                    <th>{{ __('common.fullname_en') }}</th>
                                    <th>{{ __('common.sex') }}</th>
                                    <th>{{ __('common.dob') }}</th>
                                    <th>{{ __('common.current_status') }}</th>
                                    <th>{{ __('common.current_location') }}</th>
                                    <th class="text-right">
                                        <span>{{ __('common.total_amount') .':'. $contTeachers->total() }}</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($contTeachers as $index => $staff)
                                
                                    <tr>
                                        <td>{{ $contTeachers->firstItem() + $index }}</td>
                                        <td>
                                            <a href="{{ route('contract-teachers.show', [app()->getLocale(), $staff->payroll_id]) }}" 
                                                target="_blank">{{ $staff->payroll_id }}</a>
                                        </td>
                                        <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                                        <td class="text-uppercase">{{ $staff->surname_en.' '.$staff->name_en }}</td>
                                        <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
                                        <td class="kh">{{ !empty($staff->status) ? $staff->status->status_kh : '' }}</td>
                                        <td>{{ $staff->location_kh }}</td>

                                        <td class="text-right">
                                            <!-- View -->
                                            <a href="{{ route('contract-teachers.show', [app()->getLocale(), $staff->payroll_id]) }}" 
                                                class="btn btn-xs btn-success" target="_blank">
                                                <i class="fas fa-print"></i> {{ __('button.print') }}
                                            </a>

                                            <!-- Edit -->
                                            @if (auth()->user()->can('edit-cont-staffs'))
                                                <a href="{{ route('contract-teachers.edit', [app()->getLocale(), $staff->payroll_id]) }}" 
                                                    class="btn btn-xs btn-info" onclick="loadModalOverlay()">
                                                    <i class="far fa-edit"></i> {{ __('button.edit') }}
                                                </a>
                                            @endif

                                            <!-- Delete -->
                                            <?php /* ?><button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $staff->contstaff_id }}" data-delete-url="{{ route('contract-teachers.destroy', [app()->getLocale(), $staff->contstaff_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button><?php */ ?>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-center">
                    @if(request()->search)
                        <div>
                            @if($contTeachers->hasPages())
                                {!! $contTeachers->appends(Request::except('page'))->render() !!}
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        @endif

    </section>

@endsection

@push('scripts')

    <script type="text/javascript">
        
        $(function() {

            $("#contract-teacher").addClass("menu-open");
            $("#contract-teacher-listing > a").addClass("active");

            // Contract type dropdown event
            $("#contract_type_dropdown").change(function() {
                
                if( $(this).val() !== "" ) {
                    $("#cont_pos_id").empty();
                    $("#cont_pos_id").append('<option value="">ជ្រើសរើស ...</option>');

                    $.ajax({
                        type: "GET",
                        url: "/contract-type/" + $(this).val() + "/contract-position",
                        success: function (contractpos) {
                            if( contractpos.length > 0 ) {
                                for(var index in contractpos) {
                                    $("#cont_pos_id").append('<option value="'+contractpos[index].cont_pos_id+'">'+ contractpos[index].cont_pos_kh +'</option>');
                                }

                                if( $("#cont_pos_id").attr('data-old-value') ) {
                                    $("#cont_pos_id").val( $("#cont_pos_id").attr('data-old-value')).trigger('change')
                                    $("#cont_pos_id").attr('data-old-value', '')
                                }
                            } else {
                                $("#cont_pos_id").prop("disabled", true);
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });

                    $("#cont_pos_id").prop("disabled", false);
                }
                else {
                    $("#cont_pos_id").empty();
                    $("#cont_pos_id").append('<option value="">ជ្រើសរើស ...</option>');
                    $("#cont_pos_id").prop("disabled", true);
                }
            });

            // Filter dropdown event
            $("#filter_dropdown").change(function() {
                //$("#keyword").val("");

                if( $(this).val() != "" ) {
                    $.ajax({
                        type: "GET",
                        url: "/filter-by/" + $(this).val() + "/contract-teacher",
                        success: function (contTeachers) {
                            $("#keyword").autocomplete({
                                source: contTeachers,
                            });
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });
                }
            });

            if( $("#filter_dropdown").val() != "" ) {
                $("#filter_dropdown").trigger("change");
            }

            // District change -> auto-fill data for location belong to that district
            $("#dis_code").change(function() {
                if ($(this).val() > 0) {
                    $.ajax({
                        type: "GET",
                        url: "/districts/" + $(this).val() + "/locations",
                        success: function (locations) {
                            var locationCount = Object.keys(locations).length;
                            $("#location_code").find('option:not(:first)').remove();

                            if ( locationCount > 0 ) {
                                for(var key in locations) {
                                    $("#location_code").append('<option value="'+key+'">'+ locations[key] +'</option>');
                                }
                            }
                        },
                        error: function (err) {
                            console.log('Error:', err);
                        }
                    });
                }
            });

        });

    </script>

@endpush