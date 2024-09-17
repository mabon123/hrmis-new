<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Disability;

class DisabilityController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Disability listing
     */
    public function index()
    {
    	$disabilities = Disability::when(request()->disability_kh, function($query) {
                                    $query->where('disability_kh', 'LIKE', '%'.request()->disability_kh.'%');
                                })
                                ->when(request()->disability_en, function($query) {
                                    $query->where('disability_en', 'LIKE', '%'.request()->disability_en.'%');
                                })
                                ->orderBy('disability_id', 'ASC')
                                ->paginate(10);

    	return view('admin.tools.disability.index', compact('disabilities'));
    }


    /**
     * Store Disability info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'disability_kh' => 'required',
    	]);

        $existDisability = Disability::latest('disability_id')->first();

        $disabilityData = $request->all();
    	$disabilityData['disability_id'] = $existDisability ? $existDisability->disability_id + 1 : 1;
    	Disability::create($disabilityData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing Disability
     *
     * @param  Object  Disability  $disability
     */
    public function edit(Disability $disability)
    {
    	return $disability;
    }


    /**
     * Update existing Disability info
     *
     * @param  Object  Disability  $disability
     */
    public function update(Request $request, Disability $disability)
    {
    	$request->validate([
    		'disability_kh' => 'required',
    	]);
        $disabilityData = $request->all();
    	$disability->fill($disabilityData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing Disability info
     *
     * @param  Object  Disability  $disability
     */
    public function destroy(Disability $disability)
    {
    	$disability->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
