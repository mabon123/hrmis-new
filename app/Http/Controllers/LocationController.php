<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getDistricts(Request $request)
    {
        $districts = District::where('pro_code', $request->province)->where('active', 1)->pluck('name_kh', 'dis_code');
        return $districts->toArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getCommunes(Request $request)
    {
        $communes = Commune::where('dis_code', $request->district)->where('active', 1)->pluck('name_kh', 'com_code');
        return $communes->toArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getVillages(Request $request)
    {
        $villages = Village::where('com_code', $request->commune)->pluck('name_kh', 'vil_code');
        return $villages->toArray();
    }


    /**
     * Get offices within location
     *
     * API Route
     *
     * @param  string  $locationName
     * @return  Object  Office
     */
    public function getOfficeOfLocation(Location $location)
    {
        return $location->offices;
    }

    public function getPositionOfLocation(Location $location)
    {
        $posLocations = PositionLocation::where('location_type_id', $location->location_type_id)
                                        ->pluck('position_id')
                                        ->all();

        $positions = Position::whereIn('position_id', $posLocations)
                             ->select('position_id', 'position_kh', 'position_hierarchy')
                             ->orderBy('position_hierarchy', 'ASC')
                             ->get();

        return $positions;
    }

    // Get all locations information
    public function allLocations()
    {
        return Location::get()->pluck('location_commune', 'location_code')->all();
    }
}