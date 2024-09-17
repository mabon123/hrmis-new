<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\ProfessionalType;

class ProfessionalTypeController extends Controller
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
     * Professional type listing
     */
    public function index()
    {
    	$profTypes = ProfessionalType::orderBy('prof_type_id', 'ASC')->paginate(10);

    	return view('admin.prof_types.index', compact('profTypes'));
    }


    /**
     * Store professional type info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'prof_type_kh' => 'required',
    	]);

    	// Get last professional type
    	$existingProfType = ProfessionalType::orderBy('prof_type_id', 'desc')->first();

    	$profTypeData = $request->all();
    	$profTypeData['prof_type_id'] = $existingProfType ? $existingProfType->prof_type_id + 1 : 1;
    	$profTypeData['active'] = $request->active ? 1 : 0;
    	$profTypeData['created_by'] = Auth::user()->id;
    	$profTypeData['updated_by'] = Auth::user()->id;

    	ProfessionalType::create($profTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing professional type
     *
     * @param  Object  ProfessionalType  $professional_type
     */
    public function edit(ProfessionalType $professional_type)
    {
    	return $professional_type;
    }


    /**
     * Update existing professional type info
     *
     * @param  Object  ProfessionalType  $professional_type
     */
    public function update(Request $request, ProfessionalType $professional_type)
    {
    	$request->validate([
    		'prof_type_kh' => 'required',
    	]);

    	$profTypeData = $request->all();
    	$profTypeData['active'] = $request->active ? 1 : 0;
    	$profTypeData['updated_by'] = Auth::user()->id;

    	$professional_type->fill($profTypeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing professional type info
     *
     * @param  Object  ProfessionalType  $professional_type
     */
    public function destroy(ProfessionalType $professional_type)
    {
    	$professional_type->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
