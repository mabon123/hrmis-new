<?php

namespace App\Http\Controllers\TCP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TCP\ProfessionCategory;
use App\Models\TCP\ProfessionRank;

class ProfessionCategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator')->only(['index', 'store', 'edit', 'update', 'destroy']);
    }

    // Listing
    public function index()
    {
        $professionCategories = ProfessionCategory::orderBy('tcp_prof_cat_id', 'asc')->paginate(10);
        
        return view('admin.tools.prof_categories.index', compact('professionCategories'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'tcp_prof_cat_kh' => 'required|unique:tcp_prof_categories',
            'tcp_prof_cat_en' => 'required',
        ]);

        $lastRecord = ProfessionCategory::latest('tcp_prof_cat_id')->first();

        ProfessionCategory::create([
            'tcp_prof_cat_id' => !empty($lastRecord) ? ($lastRecord->tcp_prof_cat_id + 1) : 1,
            'tcp_prof_cat_kh' => $request->tcp_prof_cat_kh,
            'tcp_prof_cat_en' => $request->tcp_prof_cat_en,
        ]);

        return redirect()->route('profession-categories.index', app()->getLocale())
            ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(ProfessionCategory $profession_category)
    {
        return $profession_category;
    }

    // Update
    public function update(ProfessionCategory $profession_category, Request $request)
    {
        $request->validate([
            'tcp_prof_cat_kh' => 'required',
            'tcp_prof_cat_en' => 'required',
        ]);

        $profession_category->fill([
            'tcp_prof_cat_kh' => $request->tcp_prof_cat_kh,
            'tcp_prof_cat_en' => $request->tcp_prof_cat_en,
        ])->save();

        return redirect()->route('profession-categories.index', app()->getLocale())
            ->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(ProfessionCategory $profession_category)
    {
        $profession_category->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }

    // Get TCP profession rank by category
    public function ajaxGetProfessionRankByCategory(ProfessionCategory $prof_cat)
    {
        $profRanks = ProfessionRank::where('tcp_prof_cat_id', $prof_cat->tcp_prof_cat_id)
                                    ->orderBy('rank_hierarchy', 'ASC')
                                    ->get();

        return $profRanks;
    }
}
