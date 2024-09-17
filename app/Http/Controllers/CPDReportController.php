<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CPD\Provider;

class CPDReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Reports page
    public function index()
    {
        if (auth()->user()->hasRole('administrator')) {
            $providers = ['' => __('common.choose') . ' ...'] + Provider::pluck('provider_kh', 'provider_id')->all();
            return view('admin.cpd_tcp.cpd_reports.index', compact('providers'));
        } else {
            return redirect()->back();
        }
    }

    //Staff who successfully received credits
    public function creditedStaff(Request $request)
    {
    }

    //List of CPD offerings
    public function cpdOfferingsList(Request $request)
    {
    }
}
