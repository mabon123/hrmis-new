<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disability;
use App\Models\Ethnic;
use App\Models\MaritalStatus;

class LookupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function getEthnicities(Request $request) {
        $lang = $request->lang;
        $ethnics = Ethnic::select('ethnic_id as id', 'ethnic_kh as value')->get();
        $response = [
            'data' => $ethnics,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    public function getDisabilities(Request $request) {
        $lang = $request->lang;
        $disabilities = Disability::select('disability_id as id', 'disability_kh as value')->get();
        $response = [
            'data' => $disabilities,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    public function getMaritalStatus(Request $request) {
        $lang = $request->lang;
        $marital_status = MaritalStatus::select('maritalstatus_id as id', 'maritalstatus_kh as value')->get();
        $response = [
            'data' => $marital_status,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
}