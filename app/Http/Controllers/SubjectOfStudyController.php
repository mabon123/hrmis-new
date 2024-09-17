<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPD\FieldOfStudy;
use App\Models\CPD\SubjectOfStudy;

class SubjectOfStudyController extends Controller
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
        $subjectOfStudies = SubjectOfStudy::paginate(20);

        return view('admin.cpd_tcp.subject_of_study.index', compact('subjectOfStudies'));
    }

    // Create
    public function create()
    {
        $fieldOfStudies = FieldOfStudy::active()->get()->pluck('field_code_kh', 'cpd_field_id')->all();
        
    	return view('admin.cpd_tcp.subject_of_study.create', compact('fieldOfStudies'));
    }

    // Stroe
    public function store(Request $request)
    {
        $request->validate([
            'cpd_subject_code' => 'required|max:10|unique:cpd_subjects',
            'cpd_subject_kh' => 'required|max:200|unique:cpd_subjects',
            'cpd_field_id' => 'required',
            'cpd_subject_desc_kh' => 'required',
        ], [
            'cpd_subject_code.unique' => __('validation.duplicate_subject_code'),
            'cpd_subject_kh.unique' => __('validation.duplicate_subject_kh'),
        ]);

        $subjectOfStudy = SubjectOfStudy::create([
            'cpd_field_id' => $request->cpd_field_id,
            'cpd_subject_code' => $request->cpd_subject_code,
            'cpd_subject_kh' => $request->cpd_subject_kh,
            'cpd_subject_en' => $request->cpd_subject_en,
            'cpd_subject_desc_kh' => $request->cpd_subject_desc_kh,
            'cpd_subject_desc_en' => $request->cpd_subject_desc_en,
            //'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'credits' => 0,
            'active' => $request->active ? 1 : 0,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('subject-of-study.index', app()->getLocale())
                         ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(SubjectOfStudy $subject_of_study)
    {
        $headerid = $subject_of_study->cpd_subject_id;
        $fieldOfStudies = FieldOfStudy::active()->get()->pluck('field_code_kh', 'cpd_field_id')->all();

        $subject_of_study->end_date = date('d-m-Y', strtotime($subject_of_study->end_date));
        
        return view('admin.cpd_tcp.subject_of_study.create', compact(
                'headerid', 'subject_of_study', 'fieldOfStudies'
            ));
    }

    // Update
    public function update(Request $request, SubjectOfStudy $subject_of_study)
    {
        $request->validate([
            'cpd_subject_code' => 'required|max:10',
            'cpd_subject_kh' => 'required|max:200',
            'cpd_field_id' => 'required',
            'cpd_subject_desc_kh' => 'required',
        ]);

        $existSubjectCode = SubjectOfStudy::where('cpd_subject_code', '<>', $subject_of_study->cpd_subject_code)
                                            ->where('cpd_subject_code', 'LIKE', $request->cpd_subject_code)
                                            ->first();
        $existSubjectKH = SubjectOfStudy::where('cpd_subject_kh', '<>', $subject_of_study->cpd_subject_kh)
                                        ->where('cpd_subject_kh', 'LIKE', $request->cpd_subject_kh)
                                        ->first();
        
        if ($existSubjectCode) {
            return redirect()->route('subject-of-study.index', app()->getLocale())
                             ->withErrors(__('validation.duplicate_subject_code'));
        }

        if ($existSubjectKH) {
            return redirect()->route('subject-of-study.index', app()->getLocale())
                             ->withErrors(__('validation.duplicate_subject_kh'));
        }

        $subject_of_study->fill([
            'cpd_field_id' => $request->cpd_field_id,
            'cpd_subject_code' => $request->cpd_subject_code,
            'cpd_subject_kh' => $request->cpd_subject_kh,
            'cpd_subject_en' => $request->cpd_subject_en,
            'cpd_subject_desc_kh' => $request->cpd_subject_desc_kh,
            'cpd_subject_desc_en' => $request->cpd_subject_desc_en,
            //'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'credits' => 0,
            'active' => $request->active ? 1 : 0,
            'updated_by' => auth()->user()->id,
        ])->save();

        return redirect()->route('subject-of-study.index', app()->getLocale())
                         ->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(SubjectOfStudy $subject_of_study)
    {
        $subject_of_study->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
