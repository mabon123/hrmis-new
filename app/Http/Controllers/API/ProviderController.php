<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Controllers\API\CPDController;
use Illuminate\Http\Request;
use App\Models\CPD\Provider;

class ProviderController extends Controller
{
    public function __construct()
    {
    }
    // Get provider's logos
    public function getProviders(Request $request)
    {
        $request->validate([
            'lang'     => 'required'
        ]);
        $lang = $request->lang;
        $data = Provider::select('provider_id', 'provider_kh as provider_name', 'description_kh as description', 'provider_logo')
            ->orderBy('provider_kh')
            ->get();

        $response = [
            'data' => $data,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    public function getProviderDetails(Request $request)
    {
        $request->validate([
            'provider_id'   => 'required',
            'lang'          => 'required'
        ]);
        $provider_id = $request->provider_id;
        $lang = $request->lang;
        $provider = Provider::find($provider_id);
        $courses = CPDController::getActivities(0, 10, $request);
        $data = [
            "provider_id" => $provider->provider_id,
            "payroll_id" => $provider->payroll_id,
            "provider_kh" => $provider->provider_kh,
            "provider_en" => $provider->provider_en,
            "provider_email" => $provider->provider_email,
            "provider_phone" => $provider->provider_phone,
            "provider_logo" => $provider->provider_logo,
            "description_kh" => $provider->description_kh,
            "description_en" => $provider->description_en,
            "provider_type_name" => $provider->providerType->provider_type_kh,
            "provider_cat_name"  => $provider->providerCategory->provider_cat_kh,
            "accreditation_name" => $provider->accreditation->accreditation_kh,
            "accreditation_date" => date('d-m-Y', strtotime($provider->accreditation_date)),
            "pro_name" => $provider->province->name_kh,
            "dis_name" => $provider->district->name_kh,
            "com_name" => $provider->commune->name_kh,
            "vil_name" => $provider->village->name_kh
        ];
        $response = [
            'data' => [
                'provider'  => $data,
                'courses'   => $courses
            ],
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
}
