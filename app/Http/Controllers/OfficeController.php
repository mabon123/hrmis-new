<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Office;

class OfficeController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Office listing
     */
    public function index()
    {
    	$offices = Office::when(request()->office_kh, function($query) {
                            $query->where('office_kh', 'like', '%'.request()->office_kh.'%');
                        })
                        ->when(request()->office_en, function($query) {
                            $query->where('office_en', 'like', '%'.request()->office_en.'%');
                        })
                        ->orderBy('office_id', 'ASC')
                        ->paginate(10);

    	return view('admin.tools.offices.index', compact('offices'));
    }


    /**
     * Store office info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'office_kh' => 'required',
    	]);

    	$officeData = $request->all();
    	$officeData['active'] = $request->active ? 1 : 0;

    	Office::create($officeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing office
     *
     * @param  Object  Office  $office
     */
    public function edit(Office $office)
    {
    	return $office;
    }


    /**
     * Update existing office info
     *
     * @param  Object  Office  $office
     */
    public function update(Request $request, Office $office)
    {
    	$request->validate([
    		'office_kh' => 'required',
    	]);

    	$officeData = $request->all();
    	$officeData['active'] = $request->active ? 1 : 0;

    	$office->fill($officeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing office info
     *
     * @param  Object  Office  $office
     */
    public function destroy(Office $office)
    {
    	$office->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
