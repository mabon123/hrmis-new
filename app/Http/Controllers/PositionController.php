<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\LocationType;
use App\Models\Position;
use App\Models\PositionCategory;
use App\Models\PositionLevel;

class PositionController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-ethnics', ['only' => ['index']]);
        //$this->middleware('permission:create-ethnics', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-ethnics', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-ethnics', ['only' => ['destroy']]);
    }


    /**
     * Position listing
     */
    public function index()
    {
    	$positionCats = PositionCategory::pluck('pos_category_kh', 'pos_category_id')->all();
        $locationTypes = LocationType::pluck('location_type_kh', 'location_type_id')->all();

    	$positions = Position::when(request()->pos_category_id, function($query) {
                                $query->where('pos_category_id', request()->pos_category_id);
                            })
                            ->when(request()->pos_level_id, function($query) {
                                $query->where('pos_level_id', request()->pos_level_id);
                            })
                            ->when(request()->position_hierarchy, function($query) {
                                $query->where('position_hierarchy', request()->position_hierarchy);
                            })
                            ->when(request()->position_kh, function($query) {
                                $query->where('position_kh', 'LIKE', '%'.request()->position_kh.'%');
                            })
                            ->when(request()->position_en, function($query) {
                                $query->where('position_en', 'LIKE', '%'.request()->position_en.'%');
                            })
                            ->orderBy('position_hierarchy', 'ASC')
                            ->paginate(10);

    	return view('admin.tools.positions.index', compact('positions', 'positionCats', 'locationTypes'));
    }


    /**
     * Store position
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'position_kh' => 'required',
    		'pos_category_id' => 'required',
    		'pos_level_id' => 'required',
    		'position_hierarchy' => 'required',
    	]);

    	// Get last position
    	$existPosition = Position::latest('position_id')->first();
    	
    	$positionData = $request->all();
    	$positionData['position_id'] = $existPosition ? $existPosition->position_id + 1 : 1;
    	$positionData['created_by'] = Auth::user()->id;
    	$positionData['updated_by'] = Auth::user()->id;
    	
    	Position::create($positionData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing position
     *
     * @param  Object  Position  $position
     */
    public function edit(Position $position)
    {
    	return $position;
    }


    /**
     * Update existing position info
     *
     * @param  Object  Position  $position
     */
    public function update(Request $request, Position $position)
    {
    	$request->validate([
    		'position_kh' => 'required',
    		'pos_category_id' => 'required',
    		'pos_level_id' => 'required',
    		'position_hierarchy' => 'required',
    	]);

    	$positionData = $request->all();
    	$positionData['updated_by'] = Auth::user()->id;

    	$position->fill($positionData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing position info
     *
     * @param  Object  Position  $position
     */
    public function destroy(Position $position)
    {
    	$position->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
