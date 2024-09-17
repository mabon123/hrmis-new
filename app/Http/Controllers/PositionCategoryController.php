<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PositionCategory;

class PositionCategoryController extends Controller
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
     * Position Category listing
     */
    public function index()
    {
    	$posCats = PositionCategory::orderBy('pos_category_id', 'ASC')->paginate(10);

    	return view('admin.position_categories.index', compact('posCats'));
    }


    /**
     * Store position_category info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'pos_category_kh' => 'required',
    	]);

    	// Get last position_category
    	$existPosCat = PositionCategory::orderBy('pos_category_id', 'desc')->first();

    	$posCatData = $request->all();
    	$posCatData['pos_category_id'] = $existPosCat ? $existPosCat->pos_category_id + 1 : 1;

    	PositionCategory::create($posCatData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing position_category
     *
     * @param  Object  PositionCategory  $position_category
     */
    public function edit(PositionCategory $position_category)
    {
    	return $position_category;
    }


    /**
     * Update existing professional type info
     *
     * @param  Object  PositionCategory  $position_category
     */
    public function update(Request $request, PositionCategory $position_category)
    {
    	$request->validate([
    		'pos_category_kh' => 'required',
    	]);

    	$position_category->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing position_category info
     *
     * @param  Object  PositionCategory  $position_category
     */
    public function destroy(PositionCategory $position_category)
    {
    	$position_category->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
