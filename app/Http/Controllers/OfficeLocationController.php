<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AdminOffice;
use App\Models\Office;
use App\Models\Province;
use App\Models\Location;

class OfficeLocationController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Office Location listing
     */
    public function index()
    {
        $offices = Office::pluck('office_kh', 'office_id')->all();
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        
        $locations = Location::when(request()->pro_code, function($query) {
                                $query->where('pro_code', 'like', '%'.request()->pro_code.'%');
                            })
                            ->pluck('location_kh', 'location_code')
                            ->all();

        $officeLocations = AdminOffice::with(['office', 'province', 'location'])
                                    ->when(request()->pro_code, function($query) {
                                        $query->where('pro_code', 'like', '%'.request()->pro_code.'%');
                                    })
                                    ->when(request()->location_code, function($query) {
                                        $query->where('location_code', 'like', '%'.request()->location_code.'%');
                                    })
                                    ->orderBy('sys_admin_office_id', 'ASC')->paginate(10);

    	return view('admin.tools.office_locations.index', compact('officeLocations', 'offices', 'provinces', 'locations'));
    }


    /**
     * Store Office Location info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'office_id' => 'required',
            'pro_code' => 'required',
            'location_code' => 'required',
    	]);

        $locationData = $request->all();
        $locationData['created_by'] = auth()->id();
    	$locationData['updated_by'] = auth()->id();

    	AdminOffice::create($locationData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing officeLocation
     *
     * @param  Object  AdminOffice  $officeLocation
     */
    public function edit(AdminOffice $officeLocation)
    {
    	return $officeLocation;
    }


    /**
     * Update existing office location info
     *
     * @param  Object  AdminOffice  $officeLocation
     */
    public function update(Request $request, AdminOffice $officeLocation)
    {
    	$request->validate([
    		'office_id' => 'required',
            'pro_code' => 'required',
            'location_code' => 'required',
    	]);

        $locationData = $request->all();
        $locationData['updated_by'] = auth()->id();
    	$officeLocation->fill($locationData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing officeLocation info
     *
     * @param  Object  AdminOffice  $officeLocation
     */
    public function destroy(AdminOffice $officeLocation)
    {
    	$officeLocation->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
