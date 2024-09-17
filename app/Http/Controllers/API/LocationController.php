<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Commune;
use App\Models\District;
use App\Models\Location;
use App\Models\Position;
use App\Models\PositionLocation;
use App\Models\Province;
use App\Models\Village;

class LocationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:sanctum');
    }

    public function getProvinces(Request $request)
    {
        $lang = $request->lang;
        $provinces = Province::active()->select('pro_code as id', 'name_kh as value')->get();
        $response = [
            'data' => $provinces,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }

    public function getDistricts(Request $request)
    {
        $lang = $request->lang;
        $districts = District::where('pro_code', $request->pro_code)->where('active', 1)->select('dis_code as id', 'name_kh as value')->get();
        $response = [
            'data' => $districts,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getCommunes(Request $request)
    {
        $lang = $request->lang;
        $communes = Commune::where('dis_code', $request->dis_code)->where('active', 1)->select('com_code as id', 'name_kh as value')->get();
        $response = [
            'data' => $communes,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getVillages(Request $request)
    {
        $lang = $request->lang;
        $villages = Village::where('com_code', $request->com_code)->select('vil_code as id', 'name_kh as value')->get();
        $response = [
            'data' => $villages,
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }


    /**
     * Get offices within location
     *
     * API Route
     *
     * @param  string  $locationName
     * @return  Object  Office
     */
    public function getOfficeOfLocation($locationName)
    {
        $locationKH = explode(' - ', $locationName);

        $location = Location::where('location_kh', 'LIKE', $locationKH[0])->first();

        return $location->offices;
    }

    public function getPositionOfLocation($locationName)
    {
        $locationKH = explode(' - ', $locationName);

        $location = Location::where('location_kh', 'LIKE', $locationKH[0])->select('location_type_id')->first();

        $posLocations = PositionLocation::where('location_type_id', $location->location_type_id)
                                        ->pluck('position_id')
                                        ->all();

        $positions = Position::whereIn('position_id', $posLocations)
                             ->select('position_id', 'position_kh', 'position_hierarchy')
                             ->orderBy('position_hierarchy', 'ASC')
                             ->get();

        return $positions;
    }
}