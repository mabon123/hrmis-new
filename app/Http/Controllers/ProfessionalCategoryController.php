<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProfessionalCategory;

class ProfessionalCategoryController extends Controller
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
     * Professional category listing
     */
    public function index()
    {
    	$profCategories = ProfessionalCategory::orderBy('prof_hierachy', 'ASC')->paginate(10);

    	return view('admin.prof_categories.index', compact('profCategories'));
    }


    /**
     * Store Professional category info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'prof_category_kh' => 'required',
    		'prof_hierachy' => 'required',
    	]);

    	// Get last Professional category
    	$existingProfCategory = ProfessionalCategory::orderBy('prof_category_id', 'desc')->first();

    	$profCatData = $request->all();
    	$profCatData['prof_category_id'] = $existingProfCategory ? $existingProfCategory->prof_category_id + 1 : 1;

    	ProfessionalCategory::create($profCatData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing professional category
     *
     * @param  Object  ProfessionalCategory  $professional_category
     */
    public function edit(ProfessionalCategory $professional_category)
    {
    	return $professional_category;
    }


    /**
     * Update existing professional category info
     *
     * @param  Object  ProfessionalCategory  $professional_category
     */
    public function update(Request $request, ProfessionalCategory $professional_category)
    {
    	$request->validate([
    		'prof_category_kh' => 'required',
    		'prof_hierachy' => 'required',
    	]);

    	$professional_category->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing professional category info
     *
     * @param  Object  ProfessionalCategory  $professional_category
     */
    public function destroy(ProfessionalCategory $professional_category)
    {
    	$professional_category->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
