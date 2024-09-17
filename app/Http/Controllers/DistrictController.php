<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\District;
use App\Models\Province;
use App\Models\Location;

class DistrictController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
        //$this->middleware('permission:view-districts', ['only' => ['index']]);
        //$this->middleware('permission:create-districts', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-districts', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-districts', ['only' => ['destroy']]);
    }


    /**
     * Districts listing
     */
    public function index()
    {
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();

        $districts = District::when(request()->pro_code, function($query) {
                                $query->where('pro_code', request()->pro_code);
                            })
                            ->when(request()->dis_code, function($query) {
                                $query->where('dis_code', request()->dis_code);
                            })
                            ->when(request()->district_kh, function($query) {
                                $query->where('name_kh', 'LIKE', '%'.request()->district_kh.'%');
                            })
                            ->when(request()->district_en, function($query) {
                                $query->where('name_en', 'LIKE', '%'.request()->district_en.'%');
                            })
                            ->orderBy('pro_code', 'ASC')
                            ->paginate(10);

        return view('admin.tools.districts.index', compact('provinces', 'districts'));
    }


    /**
     * Store district
     */
    public function store(Request $request)
    {
        $request->validate([
            'pro_code' => 'required',
            'dis_code' => 'required|unique:sys_districts',
            'name_kh' => 'required',
        ]);

        $districtData = $request->all();
        $districtData['active'] = $request->active ? 1 : 0;
        
        District::create($districtData);

        return redirect()->route('districts.index', app()->getLocale())
                         ->with('success', __('validation.add_success'));
    }


    /**
     * Edit existing district
     *
     * @param  Object  District  $district
     */
    public function edit(District $district)
    {
        return $district;
    }


    /**
     * Update existing district info
     *
     * @param  Object  District  $district
     */
    public function update(Request $request, District $district)
    {
        $request->validate([
            'pro_code' => 'required',
            'name_kh' => 'required',
        ]);

        $provinceData = $request->all();
        $provinceData['active'] = $request->active ? 1 : 0;

        $district->fill($provinceData)->save();

        return redirect()->route('districts.index', app()->getLocale())
                         ->with('success', __('validation.update_success'));
    }


    /**
     * Remove existing district info
     *
     * @param  Object  District  $district
     */
    public function destroy(District $district)
    {
        try {

            $district->delete();

            return redirect()->back()->with('success', __('validation.delete_success'));
        }

        catch (\Throwable $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }


    /**
     * Get all communes belong to a district
     *
     * API Route
     *
     * @param  District $district
     * @return  Commune Array Object
     */
    public function getCommuneOfDistrict(District $district)
    {
    	return $district->communes;
    }


    /**
     * Get all locations within a district
     *
     * @param number $disCode
     */
    public function getLocationOfDistrict($disCode)
    {
        $locations = Location::where('dis_code', $disCode)
                             ->pluck('location_kh', 'location_code')
                             ->all();

        return $locations;
    }
}
