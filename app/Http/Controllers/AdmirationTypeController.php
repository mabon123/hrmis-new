<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AdmirationType;

class AdmirationTypeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Admiration Type listing
     */
    public function index()
    {
    	$admirationTypes = AdmirationType::orderBy('admiration_type_id', 'ASC')->paginate(10);

    	return view('admin.admiration_type.index', compact('admirationTypes'));
    }


    /**
     * Store Admiration Type info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'admiration_type_kh' => 'required',
    	]);

    	$existType = AdmirationType::latest('admiration_type_id')->first();

    	$typeData = $request->all();
    	$typeData['admiration_type_id'] = $existType ? $existType->admiration_type_id + 1 : 1;
        $typeData['active'] = $request->active ? 1 : 0;
        $typeData['created_by'] = auth()->id();
        $typeData['updated_by'] = auth()->id();

    	AdmirationType::create($typeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing Admiration Type
     *
     * @param  Object  AdmirationType  $admiration_type
     */
    public function edit(AdmirationType $admiration_type)
    {
    	return $admiration_type;
    }


    /**
     * Update existing Admiration Type info
     *
     * @param  Object  AdmirationType  $admiration_type
     */
    public function update(Request $request, AdmirationType $admiration_type)
    {
    	$request->validate([
    		'admiration_type_kh' => 'required',
    	]);

        $typeData = $request->all();
        $typeData['active'] = $request->active ? 1 : 0;
        $typeData['updated_by'] = auth()->id();

    	$admiration_type->fill($typeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing Admiration Type info
     *
     * @param  Object  AdmirationType  $admiration_type
     */
    public function destroy(AdmirationType $admiration_type)
    {
    	$admiration_type->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
