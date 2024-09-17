<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Subject;
use App\Models\EducationLevel;

class SubjectController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-subject', ['only' => ['index']]);
        //$this->middleware('permission:create-subject', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-subject', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-subject', ['only' => ['destroy']]);
    }


    /**
     * Subject listing
     */
    public function index()
    {
        $educationLevels = EducationLevel::pluck('edu_level_kh', 'edu_level_id')->all();

        $subjects = Subject::with('educationLevel')
                        ->when(request()->edu_level_id, function($query) {
                            $query->where('edu_level_id', request()->edu_level_id);
                        })
                        ->when(request()->subject_hierachy, function($query) {
                            $query->where('subject_hierachy', request()->subject_hierachy);
                        })
                        ->when(request()->subject_kh, function($query) {
                            $query->where('subject_kh', 'LIKE', '%'.request()->subject_kh.'%');
                        })
                        ->when(request()->subject_en, function($query) {
                            $query->where('subject_en', 'LIKE', '%'.request()->subject_en.'%');
                        })
                        ->orderBy('subject_id', 'ASC')
                        ->paginate(10);

    	return view('admin.tools.subjects.index', compact('subjects', 'educationLevels'));
    }


    /**
     * Store Subject info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'subject_kh' => 'required',
    	]);

    	// Get last subject
    	$subject = Subject::latest('subject_id')->first();

    	$subjectData = $request->all();

        $subjectData['subject_id'] = $subject ? $subject->subject_id + 1 : 1;
        $subjectData['created_by'] = auth()->id();
    	$subjectData['updated_by'] = auth()->id();

    	Subject::create($subjectData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing subject
     *
     * @param  Object  Subject  $subject
     */
    public function edit(Subject $subject)
    {
    	return $subject;
    }


    /**
     * Update existing Subject info
     *
     * @param  Object  Subject  $subject
     */
    public function update(Request $request, Subject $subject)
    {
    	$request->validate([
    		'subject_kh' => 'required',
    	]);

        $subjectData = $request->all();

        $subjectData['updated_by'] = auth()->id();
        $subjectData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

    	$subject->fill($subjectData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing subject info
     *
     * @param  Object  Subject  $subject
     */
    public function destroy(Subject $subject)
    {
    	$subject->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
