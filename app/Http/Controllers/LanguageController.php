<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Language;

class LanguageController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-language', ['only' => ['index']]);
        //$this->middleware('permission:create-language', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-language', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-language', ['only' => ['destroy']]);
    }


    /**
     * Language listing
     */
    public function index()
    {
    	$languages = Language::orderBy('language_id', 'ASC')->paginate(10);

    	return view('admin.languages.index', compact('languages'));
    }


    /**
     * Store foriegn language info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'language_kh' => 'required',
    	]);

    	// Get last foriegn language
    	$existLanguage = Language::latest('language_id')->first();

    	$languageData = $request->all();
    	$languageData['language_id'] = $existLanguage ? $existLanguage->language_id + 1 : 1;

    	Language::create($languageData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing foriegn language
     *
     * @param  Object  Language  $foriegn_language
     */
    public function edit(Language $foriegn_language)
    {
    	return $foriegn_language;
    }


    /**
     * Update existing foriegn language info
     *
     * @param  Object  Language  $foriegn_language
     */
    public function update(Request $request, Language $foriegn_language)
    {
    	$request->validate([
    		'language_kh' => 'required',
    	]);

    	$foriegn_language->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing foriegn language info
     *
     * @param  Object  Language  $foriegn_language
     */
    public function destroy(Language $foriegn_language)
    {
    	$foriegn_language->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
