<?php

namespace App\Http\Controllers\TCP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TCP\ProfessionCategory;
use App\Models\TCP\ProfessionRank;

class ProfessionRankController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
    }

    // Listing
    public function index()
    {
        $profCategories = ProfessionCategory::pluck('tcp_prof_cat_kh', 'tcp_prof_cat_id')->all();
        $profRanks = ProfessionRank::orderBy('tcp_prof_rank_id', 'asc')->paginate(10);
        
        return view('admin.tools.prof_ranks.index', compact('profCategories', 'profRanks'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'tcp_prof_cat_id' => 'required',
            'tcp_prof_rank_kh' => 'required|unique:tcp_prof_ranks',
            'tcp_prof_rank_en' => 'required',
            'rank_hierarchy' => 'required',
        ]);

        $lastRecord = ProfessionRank::latest('tcp_prof_rank_id')->first();

        ProfessionRank::create([
            'tcp_prof_rank_id' => !empty($lastRecord) ? ($lastRecord->tcp_prof_rank_id + 1) : 1,
            'tcp_prof_cat_id' => $request->tcp_prof_cat_id,
            'tcp_prof_rank_kh' => $request->tcp_prof_rank_kh,
            'tcp_prof_rank_en' => $request->tcp_prof_rank_en,
            'rank_hierarchy' => $request->rank_hierarchy,
            'rank_low' => $request->rank_low ? $request->rank_low : null,
            'rank_high' => $request->rank_high ? $request->rank_high : null,
        ]);

        return redirect()->route('profession-ranks.index', app()->getLocale())
            ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(ProfessionRank $profession_rank)
    {
        return $profession_rank;
    }

    // Update
    public function update(ProfessionRank $profession_rank, Request $request)
    {
        $request->validate([
            'tcp_prof_cat_id' => 'required',
            'tcp_prof_rank_kh' => 'required',
            'tcp_prof_rank_en' => 'required',
            'rank_hierarchy' => 'required',
        ]);

        $profession_rank->fill([
            'tcp_prof_cat_id' => $request->tcp_prof_cat_id,
            'tcp_prof_rank_kh' => $request->tcp_prof_rank_kh,
            'tcp_prof_rank_en' => $request->tcp_prof_rank_en,
            'rank_hierarchy' => $request->rank_hierarchy,
            'rank_low' => $request->rank_low ? $request->rank_low : null,
            'rank_high' => $request->rank_high ? $request->rank_high : null,
        ])->save();

        return redirect()->route('profession-ranks.index', app()->getLocale())
            ->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(ProfessionRank $profession_rank)
    {
        $profession_rank->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
