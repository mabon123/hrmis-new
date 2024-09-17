<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\ShortCourseCategory;

class ShortCourseCategoryController extends Controller
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
     * ShortCourseCategory listing
     */
    public function index()
    {
    	$shortCourseCats = ShortCourseCategory::when(request()->shortcourse_cat_kh, function($query) {
                                                $query->where('shortcourse_cat_kh', 'LIKE', '%'.request()->shortcourse_cat_kh.'%');
                                            })
                                            ->when(request()->shortcourse_cat_en, function($query) {
                                                $query->where('shortcourse_cat_en', 'LIKE', '%'.request()->shortcourse_cat_en.'%');
                                            })
                                            ->orderBy('shortcourse_cat_id', 'ASC')
                                            ->paginate(10);

    	return view('admin.tools.shortcourse_cats.index', compact('shortCourseCats'));
    }


    /**
     * Store ShortCourseCategory info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'shortcourse_cat_kh' => 'required',
    	]);

    	// Get last ShortCourseCategory
    	$existShortCourseCat = ShortCourseCategory::latest('shortcourse_cat_id')->first();

    	$shortCourseCatData = $request->all();
    	$shortCourseCatData['shortcourse_cat_id'] = $existShortCourseCat ? $existShortCourseCat->shortcourse_cat_id + 1 : 1;

    	ShortCourseCategory::create($shortCourseCatData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing ShortCourseCategory
     *
     * @param  Object  ShortCourseCategory  $shortcourse_category
     */
    public function edit(ShortCourseCategory $shortcourse_category)
    {
    	return $shortcourse_category;
    }


    /**
     * Update existing ShortCourseCategory info
     *
     * @param  Object  ShortCourseCategory  $shortcourse_category
     */
    public function update(Request $request, ShortCourseCategory $shortcourse_category)
    {
    	$request->validate([
    		'shortcourse_cat_kh' => 'required',
    	]);

    	$shortcourse_category->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing ShortCourseCategory info
     *
     * @param  Object  ShortCourseCategory  $shortcourse_category
     */
    public function destroy(ShortCourseCategory $shortcourse_category)
    {
    	$shortcourse_category->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
