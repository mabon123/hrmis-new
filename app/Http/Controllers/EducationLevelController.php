<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EducationLevel;

class EducationLevelController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * EducationLevel listing
     */
    public function index()
    {
    	$educationLevels = EducationLevel::orderBy('edu_level_id', 'ASC')->paginate(10);

    	return view('admin.education_level.index', compact('educationLevels'));
    }


    /**
     * Store EducationLevel info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'edu_level_kh' => 'required',
    	]);

        $existEducationLevel = EducationLevel::latest('edu_level_id')->first();

        $educationLevelData = $request->all();
    	$educationLevelData['edu_level_id'] = $existEducationLevel ? $existEducationLevel->edu_level_id + 1 : 1;
    	EducationLevel::create($educationLevelData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing EducationLevel
     *
     * @param  Object  EducationLevel  $educationLevel
     */
    public function edit(EducationLevel $educationLevel)
    {
    	return $educationLevel;
    }


    /**
     * Update existing EducationLevel info
     *
     * @param  Object  EducationLevel  $educationLevel
     */
    public function update(Request $request, EducationLevel $educationLevel)
    {
    	$request->validate([
    		'edu_level_kh' => 'required',
    	]);
        $educationLevelData = $request->all();
    	$educationLevel->fill($educationLevelData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing EducationLevel info
     *
     * @param  Object  EducationLevel  $educationLevel
     */
    public function destroy(EducationLevel $educationLevel)
    {
    	$educationLevel->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
