<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TCPAssessmentRankController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }


    // Create
    public function create()
    {
    	return view('admin.cpd_tcp.assessment_ranks.create');
    }
}
