<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AdmirationSource;

class AdmirationSourceController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Admiration Source listing
     */
    public function index()
    {
    	$admirationSources = AdmirationSource::orderBy('source_id', 'ASC')->paginate(10);

    	return view('admin.admiration_source.index', compact('admirationSources'));
    }


    /**
     * Store Admiration Source info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'source_kh' => 'required',
    	]);

    	AdmirationSource::create($request->all());

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing Admiration Source
     *
     * @param  Object  AdmirationSource  $admiration_source
     */
    public function edit(AdmirationSource $admiration_source)
    {
    	return $admiration_source;
    }


    /**
     * Update existing Admiration Source info
     *
     * @param  Object  AdmirationSource  $admiration_source
     */
    public function update(Request $request, AdmirationSource $admiration_source)
    {
    	$request->validate([
    		'source_kh' => 'required',
    	]);

    	$admiration_source->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing Admiration Source info
     *
     * @param  Object  AdmirationSource  $admiration_source
     */
    public function destroy(AdmirationSource $admiration_source)
    {
    	$admiration_source->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
