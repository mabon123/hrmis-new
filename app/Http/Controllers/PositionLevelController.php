<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\PositionLevel;

class PositionLevelController extends Controller
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
     * Position Level listing
     */
    public function index()
    {
    	$posLevels = PositionLevel::orderBy('pos_level_id', 'ASC')->paginate(10);

    	return view('admin.position_levels.index', compact('posLevels'));
    }


    /**
     * Store position_level info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'pos_level_kh' => 'required',
    	]);

    	// Get last position_level
    	$existPosLevel = PositionLevel::orderBy('pos_level_id', 'desc')->first();

    	$posLevelData = $request->all();
    	$posLevelData['pos_level_id'] = $existPosLevel ? $existPosLevel->pos_level_id + 1 : 1;
    	$posLevelData['active'] = $request->active ? 1 : 0;
    	$posLevelData['created_by'] = Auth::user()->id;
    	$posLevelData['updated_by'] = Auth::user()->id;

    	PositionLevel::create($posLevelData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing professional type
     *
     * @param  Object  PositionLevel  $position_level
     */
    public function edit(PositionLevel $position_level)
    {
    	return $position_level;
    }


    /**
     * Update existing professional type info
     *
     * @param  Object  PositionLevel  $position_level
     */
    public function update(Request $request, PositionLevel $position_level)
    {
    	$request->validate([
    		'pos_level_kh' => 'required',
    	]);

    	$posLevelData = $request->all();
    	$posLevelData['active'] = $request->active ? 1 : 0;
    	$posLevelData['updated_by'] = Auth::user()->id;

    	$position_level->fill($posLevelData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing position_level info
     *
     * @param  Object  PositionLevel  $position_level
     */
    public function destroy(PositionLevel $position_level)
    {
    	$position_level->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
