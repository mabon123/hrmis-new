<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OfficialRank;
use App\Models\SalaryLevel;

class OfficialRankController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-ethnics', ['only' => ['index']]);
        //$this->middleware('permission:create-ethnics', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-ethnics', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-ethnics', ['only' => ['destroy']]);
    }


    /**
     * OfficialRank listing
     */
    public function index()
    {
    	$salaryLevels = SalaryLevel::pluck('salary_level_kh', 'salary_level_id');

    	$officialRanks = OfficialRank::orderBy('official_rank_id', 'ASC')->paginate(10);

    	return view('admin.official_ranks.index', compact('officialRanks', 'salaryLevels'));
    }


    /**
     * Store cardretype info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'official_rank_kh' => 'required',
    		'salary_level_id' => 'required',
    	]);

    	// Get last cardretype
    	$existOfficialRank = OfficialRank::latest('official_rank_id')->first();
    	
    	$officialRankData = $request->all();
    	$officialRankData['official_rank_id'] = $existOfficialRank ? $existOfficialRank->official_rank_id + 1 : 1;
    	
    	OfficialRank::create($officialRankData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing official_rank
     *
     * @param  Object  OfficialRank  $official_rank
     */
    public function edit(OfficialRank $official_rank)
    {
    	return $official_rank;
    }


    /**
     * Update existing official_rank info
     *
     * @param  Object  OfficialRank  $official_rank
     */
    public function update(Request $request, OfficialRank $official_rank)
    {
    	$request->validate([
    		'official_rank_kh' => 'required',
    		'salary_level_id' => 'required',
    	]);

    	$official_rank->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing official_rank info
     *
     * @param  Object  OfficialRank  $official_rank
     */
    public function destroy(OfficialRank $official_rank)
    {
    	$official_rank->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
