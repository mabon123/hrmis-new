@extends('layouts.admin')

@push('styles')
    <style type="text/css">
        div.inner i.ion{font-size:70px !important;}
        div.inner h3{font-size:24px !important;}
        .bg-white-green{background:#fff !important;border:1px #28a745 solid;}
        .bg-green{background:#28a745;opacity:.8;}
        .bg-white-blue{background:#fff !important;border:1px #17a2b8 solid;}
        .bg-blue{background:#17a2b8;opacity:.8;}
        div.inner h2{margin-bottom:0;}
        .home-icon{width:72px;}
    </style>
@endpush

@section('content')
<!-- Main content -->
<section class="content" style="padding-top:50px;">
    <div class="container-fluid">
        <h3 class="text-center" style="font-family:'Khmer OS Muol Light', Moul !important;font-size:36px;">
            {{ $userWorkPlaceName }}</h3>
        
        <div class="row" style="margin-top:30px;">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-blue">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/newly_trained_teacher.png') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $newlyTrainedTeacher }}</h3>
                    </div>
                    <a href="{{ route('staffs.trainee-list', app()->getLocale()) }}" class="small-box-footer bg-blue kh">
                        @lang('menu.staff_trainee_list') <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-green">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/off_duty.png') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $offDutyStaff }}</h3>
                    </div>
                    <a href="{{ route('reports.offDutyStaff', app()->getLocale()) }}" class="small-box-footer bg-green kh">
                        {{ __('menu.dashboard_off_duty') }} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-green">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/leave_without_pay.png') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $leaveWithoutPayStaff }}</h3>
                    </div>
                    <a href="{{ route('reports.leaveWithoutPayStaff', app()->getLocale()) }}" class="small-box-footer bg-green kh">
                        {{ __('menu.dashboard_leave_without_pay') }} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-blue">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/continue_study.png') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $continueStudyStaff }}</h3>
                    </div>
                    <a href="{{ route('reports.continueStudyStaff', app()->getLocale()) }}" class="small-box-footer bg-blue kh">
                        {{ __('menu.dasboard_continue_staudy') }} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-green">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/movein.png') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $movedInStaff }}</h3>
                    </div>
                    <a href="{{ route('reports.showStaffTransferInInfo', app()->getLocale()) }}" 
                        class="small-box-footer bg-green kh" onclick="loading();">
                        {{ __('menu.dashboard_transferred_in') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-green">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/leave.png') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $staffOnLeave }}</h3>
                    </div>
                    <a href="{{ route('reports.showStaffOnLeave', app()->getLocale()) }}" 
                        class="small-box-footer bg-green kh" onclick="loadModalOverlay(true, 1000);">
                        {{ __('menu.dashboard_leave_info') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-green">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/requestCardreBycertification.jpg') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $cardreCertification }}</h3>
                    </div>
                    <a href="{{ route('reports.showRequestCardreByCertification', app()->getLocale()) }}" 
                        class="small-box-footer bg-green kh" onclick="loadModalOverlay(true, 1000);">
                        ស្នើដំឡើងថ្នាក់តាមសញ្ញាបត្រ <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info bg-white-green">
                    <div class="inner">
                        <h2 class="text-center">
                            <img class="home-icon" src="{{ asset('images/icons/requestCardreBycercle.jpg') }}" alt="">
                        </h2>
                        <h3 class="text-center">{{ $cardreCercle }}</h3>
                    </div>
                    <a href="{{ route('reports.showRequestCardreByCercle', app()->getLocale()) }}" 
                        class="small-box-footer bg-green kh" onclick="loadModalOverlay(true, 5000);">
                        ស្នើដំឡើងថ្នាក់តាមវេន <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
