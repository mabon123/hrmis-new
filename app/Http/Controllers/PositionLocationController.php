<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LocationType;
use App\Models\Position;
use App\Models\PositionLocation;

class PositionLocationController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Position Location listing
     */
    public function index()
    {
    	$positions = Position::orderBy('position_hierarchy', 'asc')->pluck('position_kh', 'position_id')->all();
    	$locations = LocationType::pluck('location_type_kh', 'location_type_id')->all();

    	$posLocations = PositionLocation::with(['position', 'locationType'])
                                        ->when(request()->location_type_id, function($query) {
                                            $query->where('location_type_id', request()->location_type_id);
                                        })
                                        ->when(request()->position_id, function($query) {
                                            $query->where('position_id', request()->position_id);
                                        })
                                        ->paginate(10);

    	return view('admin.tools.pos_locations.index', compact('positions', 'locations', 'posLocations'));
    }


    /**
     * Store Position Location info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'position_id' => 'required',
    		'location_type_id' => 'required',
    	]);

    	PositionLocation::create($request->all());

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing Position Location
     *
     * @param  Object  PositionLocation  $position_location
     */
    public function edit(PositionLocation $position_location)
    {
    	return $position_location;
    }


    /**
     * Update existing position location info
     *
     * @param  Object  PositionLocation  $position_location
     */
    public function update(Request $request, PositionLocation $position_location)
    {
    	$request->validate([
    		'position_id' => 'required',
            'location_type_id' => 'required',
    	]);
    	
    	$position_location->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing position location info
     *
     * @param  Object  PositionLocation  $officeLocation
     */
    public function destroy(PositionLocation $position_location)
    {
    	$position_location->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
