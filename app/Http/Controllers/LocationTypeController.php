<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LocationType;

class LocationTypeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-location-types', ['only' => ['index']]);
        //$this->middleware('permission:create-location-types', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-location-types', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-location-types', ['only' => ['destroy']]);
    }


    /**
     * Location Type listing
     */
    public function index()
    {
    	$locationTypes = LocationType::orderBy('location_type_id', 'ASC')->paginate(10);

    	return view('admin.location_types.index', compact('locationTypes'));
    }


    /**
     * Store location type info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'location_type_kh' => 'required',
    	]);

    	// Get last location type
    	$type = LocationType::latest('location_type_id')->first();

    	$locationTypeData = $request->all();
    	$locationTypeData['location_type_id'] = $type ? $type->location_type_id + 1 : 1;

    	LocationType::create($locationTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing locationType
     *
     * @param  Object  LocationType  $locationType
     */
    public function edit(LocationType $locationType)
    {
    	return $locationType;
    }


    /**
     * Update existing location type info
     *
     * @param  Object  LocationType  $locationType
     */
    public function update(Request $request, LocationType $locationType)
    {
    	$request->validate([
    		'location_type_kh' => 'required',
    	]);

    	$locationType->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing locationType info
     *
     * @param  Object  LocationType  $locationType
     */
    public function destroy(LocationType $locationType)
    {
    	$locationType->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }

    public function ajaxGetLocationTypes(Request $request) {
        return LocationType::select()
                    ->where('location_type_id', '!=', 1)
                    ->when($request->has('under_moeys'), function($q) use ($request) {
                        $q->where('under_moeys', $request->under_moeys);
                    })
                    ->get()
                    ->toArray();
    }
}
