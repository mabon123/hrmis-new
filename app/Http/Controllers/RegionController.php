<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Region;

class RegionController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Region listing
     */
    public function index()
    {
    	$regions = Region::orderBy('region_id', 'ASC')->paginate(10);

    	return view('admin.region.index', compact('regions'));
    }


    /**
     * Store Region info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'region_kh' => 'required',
    	]);

        $existRegion = Region::latest('region_id')->first();

    	$regionData = $request->all();
    	$regionData['region_id'] = $existRegion ? $existRegion->region_id + 1 : 1;

    	Region::create($regionData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing Region
     *
     * @param  Object  Region  $region
     */
    public function edit(Region $region)
    {
    	return $region;
    }


    /**
     * Update existing Region info
     *
     * @param  Object  Region  $region
     */
    public function update(Request $request, Region $region)
    {
    	$request->validate([
    		'region_kh' => 'required',
    	]);

    	$region->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing Region info
     *
     * @param  Object  Region  $region
     */
    public function destroy(Region $region)
    {
    	$region->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
