<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TCPAssessmentTeacherController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }


    // Create
    public function create()
    {
    	return view('admin.cpd_tcp.assessment_teachers.create');
    }
}
