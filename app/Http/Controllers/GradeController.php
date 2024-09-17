<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Grade;
use App\Models\EducationLevel;

class GradeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * Grade listing
     */
    public function index()
    {
        $educationLevels = EducationLevel::pluck('edu_level_kh', 'edu_level_id')->all();

        $grades = Grade::when(request()->edu_level_id, function($query) {
                            $query->where('edu_level_id', request()->edu_level_id);
                        })
                        ->when(request()->grade_kh, function($query) {
                            $query->where('grade_kh', 'LIKE', '%'.request()->grade_kh.'%');
                        })
                        ->when(request()->grade_en, function($query) {
                            $query->where('grade_en', 'LIKE', '%'.request()->grade_en.'%');
                        })
                        ->orderBy('grade_id', 'ASC')
                        ->paginate(10);

    	return view('admin.tools.grade.index', compact('grades', 'educationLevels'));
    }


    /**
     * Store Grade info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'grade_kh' => 'required',
            'edu_level_id' => 'required',
    	]);

        $existGrade = Grade::latest('grade_id')->first();

        $gradeData = $request->all();
    	$gradeData['grade_id'] = $existGrade ? $existGrade->grade_id + 1 : 1;
    	Grade::create($gradeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing Grade
     *
     * @param  Object  Grade  $grade
     */
    public function edit(Grade $grade)
    {
    	return $grade;
    }


    /**
     * Update existing Grade info
     *
     * @param  Object  Grade  $grade
     */
    public function update(Request $request, Grade $grade)
    {
    	$request->validate([
    		'grade_kh' => 'required',
            'edu_level_id' => 'required',
    	]);

        $gradeData = $request->all();
    	$grade->fill($gradeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing Grade info
     *
     * @param  Object  Grade  $grade
     */
    public function destroy(Grade $grade)
    {
    	$grade->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
