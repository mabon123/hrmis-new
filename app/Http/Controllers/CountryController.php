<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Country;

class CountryController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('role:administrator');
        //$this->middleware('permission:view-countries', ['only' => ['index']]);
        //$this->middleware('permission:create-countries', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-countries', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-countries', ['only' => ['destroy']]);
    }


    /**
     * Countries listing
     */
    public function index()
    {
    	$countries = Country::when(request()->country_kh, function($query) {
                                $query->where('country_kh', 'LIKE', '%'.request()->country_kh.'%');
                            })
                            ->when(request()->country_en, function($query) {
                                $query->where('country_en', 'LIKE', '%'.request()->country_en.'%');
                            })
                            ->orderBy('country_id', 'ASC')
                            ->paginate(10);

    	return view('admin.tools.countries.index', compact('countries'));
    }


    /**
     * Store country info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'country_kh' => 'required',
    	]);

    	// Get last country
    	$existingCountry = Country::orderBy('country_id', 'desc')->first();

    	$countryData = $request->all();
    	$countryData['country_id'] = $existingCountry ? $existingCountry->country_id + 1 : 1;
    	$countryData['active'] = $request->active ? 1 : 0;

    	Country::create($countryData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing country
     *
     * @param  Object  Country  $country
     */
    public function edit(Country $country)
    {
    	return $country;
    }


    /**
     * Update existing country info
     *
     * @param  Object  Country  $country
     */
    public function update(Request $request, Country $country)
    {
    	$request->validate([
    		'country_kh' => 'required',
    	]);

    	$countryData = $request->all();
    	$countryData['active'] = $request->active ? 1 : 0;

    	$country->fill($countryData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing country info
     *
     * @param  Object  Country  $country
     */
    public function destroy(Country $country)
    {
    	$country->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
