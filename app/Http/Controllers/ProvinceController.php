<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Commune;
use App\Models\Province;
use App\Models\Village;
use App\Models\Location;

class ProvinceController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        //$this->middleware('permission:view-provinces', ['only' => ['index']]);
        //$this->middleware('permission:create-provinces', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-provinces', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-provinces', ['only' => ['destroy']]);
    }


    /**
     * Provinces listing
     */
    public function index()
    {
        $provinces = Province::orderBy('pro_code', 'ASC')->paginate(10);

        return view('admin.provinces.index', compact('provinces'));
    }


    /**
     * Store province
     */
    public function store(Request $request)
    {
        $request->validate([
            'pro_code' => 'required|unique:sys_provinces',
            'name_kh' => 'required',
        ]);

        $provinceData = $request->all();
        $provinceData['active'] = $request->active ? 1 : 0;

        Province::create($provinceData);

        return redirect()->route('provinces.index', app()->getLocale())
                         ->with('success', __('validation.add_success'));
    }


    /**
     * Edit existing province
     *
     * @param  Object  Province  $province
     */
    public function edit(Province $province)
    {
        return $province;
    }


    /**
     * Update existing province info
     *
     * @param  Object  Province  $province
     */
    public function update(Request $request, Province $province)
    {
        $request->validate([
            'pro_code' => 'required',
            'name_kh' => 'required',
        ]);

        $provinceData = $request->all();
        $provinceData['active'] = $request->active ? 1 : 0;

        $province->fill($provinceData)->save();

        return redirect()->route('provinces.index', app()->getLocale())
                         ->with('success', __('validation.update_success'));
    }


    /**
     * Remove existing province info
     *
     * @param  Object  Province  $province
     */
    public function destroy(Province $province)
    {
        try {

            $province->delete();

            return redirect()->back()->with('success', __('validation.delete_success'));
        }

        catch (\Throwable $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }


    /**
     * Get all districts belong to a province
     *
     * API Route
     *
     * @param  Province  $province
     * @return  District Array Object
     */
    public function getDistrictOfProvince(Province $province)
    {
    	return $province->districts;
    }


    /**
     * Get all communes within a province
     *
     * API Route
     *
     * @param  int  $proCode
     * @return  Commune Array Object
     */
    public function getCommuneOfProvince($proCode)
    {
    	$communes = Commune::where(DB::raw('LEFT(com_code, 2)'), $proCode)
    					   ->distinct()
    					   ->pluck('name_kh');

    	return $communes;
    }


    /**
     * Get all villages within a province - second character of vil_code represent
     * a selected province
     *
     * API Route
     *
     * @param  int  $proCode
     * @return  Village Array Object
     */
    public function getVillageOfProvince($proCode)
    {
    	$villages = Village::where(DB::raw('LEFT(vil_code, 2)'), $proCode)
    					   ->distinct()
    					   ->pluck('name_kh');

    	return $villages;
    }


    /**
     * Get all locations within a province
     *
     * @param number $proCode
     */
    public function getLocationOfProvince($proCode)
    {
        $locations = Location::where('pro_code', $proCode)
                             ->pluck('location_kh', 'location_code')
                             ->all();

        return $locations;
    }
}
