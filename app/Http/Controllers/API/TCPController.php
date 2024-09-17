<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\LookupController;

use Illuminate\Http\Request;

class TCPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    // Get qualification code
    public function getQualification()
    {
        
    }
}