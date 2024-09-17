<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPD\FieldOfStudy;
use App\Models\CPD\SubjectOfStudy;

class CPDFieldOfStudyController extends Controller
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
    	$fieldStudies = FieldOfStudy::active()->paginate(20);

    	return view('admin.cpd_tcp.field_of_studies.index', compact('fieldStudies'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'cpd_field_kh' => 'required|unique:cpd_field_studies',
            'cpd_field_code' => 'required|unique:cpd_field_studies',
        ], [
            'cpd_field_kh.unique' => __('validation.duplicate_field_kh'),
            'cpd_field_code.unique' => __('validation.duplicate_field_code'),
        ]);
        
        FieldOfStudy::create([
            'cpd_field_code' => $request->cpd_field_code,
            'cpd_field_kh' => $request->cpd_field_kh,
            'cpd_field_en' => $request->cpd_field_en,
            'cpd_field_desc_kh' => $request->cpd_field_desc_kh,
            'cpd_field_desc_en' => $request->cpd_field_desc_en,
            'active' => $request->active,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('cpd-field-of-studies.index', app()->getLocale())
                        ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(FieldOfStudy $cpd_field_of_study)
    {
        return $cpd_field_of_study;
    }

    // Update
    public function update(Request $request, FieldOfStudy $cpd_field_of_study)
    {
        $request->validate([
            'cpd_field_kh' => 'required',
            'cpd_field_code' => 'required',
        ]);

        $existFieldCode = FieldOfStudy::where('cpd_field_code', 'LIKE', $request->cpd_field_code)->first();
        $existFieldKH = FieldOfStudy::where('cpd_field_kh', 'LIKE', $request->cpd_field_kh)->first();

        if ($existFieldCode) {
            return redirect()->route('cpd-field-of-studies.index', app()->getLocale())
                             ->withErrors(__('validation.duplicate_field_code'));
        }

        if ($existFieldKH) {
            return redirect()->route('cpd-field-of-studies.index', app()->getLocale())
                             ->withErrors(__('validation.duplicate_field_kh'));
        }

        $cpd_field_of_study->fill([
            'cpd_field_code' => $request->cpd_field_code,
            'cpd_field_kh' => $request->cpd_field_kh,
            'cpd_field_en' => $request->cpd_field_en,
            'cpd_field_desc_kh' => $request->cpd_field_desc_kh,
            'cpd_field_desc_en' => $request->cpd_field_desc_en,
            'active' => $request->active,
            'updated_by' => auth()->user()->id,
        ])->save();

        return redirect()->route('cpd-field-of-studies.index', app()->getLocale())
                        ->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(FieldOfStudy $cpd_field_of_study)
    {
        $cpd_field_of_study->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }

    // List subject of study belongs to field of study
    public function showSubjectOfFieldStudy($field_id)
    {
        return SubjectOfStudy::active()
                             ->where('cpd_field_id', $field_id)
                             ->select('cpd_subject_id', 'cpd_subject_code', 'cpd_subject_kh')
                             ->get();
    }
}
