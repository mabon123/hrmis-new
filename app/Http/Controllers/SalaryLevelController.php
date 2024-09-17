<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Location;
use App\Models\SalaryLevel;

class SalaryLevelController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
        //$this->middleware('permission:view-ethnics', ['only' => ['index']]);
        //$this->middleware('permission:create-ethnics', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-ethnics', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-ethnics', ['only' => ['destroy']]);
    }


    /**
     * SalaryLevel listing
     */
    public function index()
    {
    	$salaryLevels = SalaryLevel::orderBy('salary_level_id', 'ASC')->paginate(10);

    	return view('admin.salary_levels.index', compact('salaryLevels'));
    }


    /**
     * Store salary_level info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'salary_level_kh' => 'required',
    	]);

    	// Get last salary level
    	$existSalaryLevel = SalaryLevel::latest('salary_level_id')->first();
    	
    	$salaryLevelData = $request->all();
    	$salaryLevelData['salary_level_id'] = $existSalaryLevel ? $existSalaryLevel->salary_level_id + 1 : 1;
    	
    	SalaryLevel::create($salaryLevelData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing salary_level
     *
     * @param  Object  SalaryLevel  $salary_level
     */
    public function edit(SalaryLevel $salary_level)
    {
    	return $salary_level;
    }


    /**
     * Update existing salary_level info
     *
     * @param  Object  SalaryLevel  $salary_level
     */
    public function update(Request $request, SalaryLevel $salary_level)
    {
    	$request->validate([
    		'salary_level_kh' => 'required',
    	]);

    	$salary_level->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing salary_level info
     *
     * @param  Object  SalaryLevel  $salary_level
     */
    public function destroy(SalaryLevel $salary_level)
    {
    	$salary_level->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }


    /**
     * Get official rank info by salary level
     *
     * @param  Object  SalaryLevel $salary_level
     * @param  String  $location_kh
     */
    public function getOfficialRankBySalaryLevel(SalaryLevel $salary_level, $location_code)
    {
        $location = Location::where('location_code', $location_code)->first();
        
        $isSchool = !empty($location->locationType) ? $location->locationType->is_school : 0;

        return $salary_level->officialRanks()->where('is_school', $isSchool)->get();
    }
}
