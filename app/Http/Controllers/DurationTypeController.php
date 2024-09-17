<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\DurationType;

class DurationTypeController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-duratin-type', ['only' => ['index']]);
        //$this->middleware('permission:create-duratin-type', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-duratin-type', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-duratin-type', ['only' => ['destroy']]);
    }


    /**
     * DurationType listing
     */
    public function index()
    {
    	$durationTypes = DurationType::orderBy('dur_type_id', 'ASC')->paginate(10);

    	return view('admin.duration_types.index', compact('durationTypes'));
    }


    /**
     * Store DurationType info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'dur_type_kh' => 'required',
    	]);

    	// Get last DurationType
    	$existDurationType = DurationType::latest('dur_type_id')->first();

    	$durationTypeData = $request->all();
    	$durationTypeData['dur_type_id'] = $existDurationType ? $existDurationType->dur_type_id + 1 : 1;

    	DurationType::create($durationTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing DurationType
     *
     * @param  Object  DurationType  $duration_type
     */
    public function edit(DurationType $duration_type)
    {
    	return $duration_type;
    }


    /**
     * Update existing DurationType info
     *
     * @param  Object  DurationType  $duration_type
     */
    public function update(Request $request, DurationType $duration_type)
    {
    	$request->validate([
    		'dur_type_kh' => 'required',
    	]);

    	$duration_type->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing DurationType info
     *
     * @param  Object  DurationType  $duration_type
     */
    public function destroy(DurationType $duration_type)
    {
    	$duration_type->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
