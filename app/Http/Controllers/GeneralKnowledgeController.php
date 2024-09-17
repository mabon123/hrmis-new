<?php

namespace App\Http\Controllers;

use Auth;

use Image;
use Storage;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Country;
use App\Models\Subject;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use App\Models\QualificationCode;
use App\Models\StaffProfessional;
use App\Models\StaffQualification;

class GeneralKnowledgeController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:create-staffs', ['only' => ['index', 'edit']]);
    }


    /**
     * List general knowledge info belong to a staff
     *
     * @param  Object  Staff $staff
     */
    public function index(Staff $staff)
    {
    	$headerid = $staff->payroll_id;

    	$qualificationCodes = QualificationCode::orderBy('qualification_hierachy', 'ASC')->get();

    	$countries = Country::active()->get();

    	$subjects = Subject::orderBy('subject_hierachy', 'ASC')->select('subject_id', 'subject_kh', 'subject_en')->get();

    	$knowledges = StaffQualification::where('payroll_id', $staff->payroll_id)->orderBy('qual_id', 'Desc')->paginate(10);

        $highestKnowledge = StaffQualification::join('sys_qualification_codes', 'hrmis_staff_qualifications.qualification_code', '=', 'sys_qualification_codes.qualification_code')
                                              ->where('hrmis_staff_qualifications.payroll_id', $staff->payroll_id)
                                              ->latest('sys_qualification_codes.qualification_code')
                                              ->select('sys_qualification_codes.qualification_kh', 'sys_qualification_codes.qualification_code')
                                              ->first();      
                 
        $request_cardre_status = (StaffQualification::where('payroll_id', $staff->payroll_id)->where('request_cardre_check_status',1)->first()) != null ? 1: 0;
    	
        return view('admin.staffs.knowledge', compact(
    			'headerid', 'staff', 'countries', 'qualificationCodes', 'subjects', 'knowledges',
                'highestKnowledge','request_cardre_status'
    		));
    }


    /**
     * Store general knowledge info of student
     *
     * @param  Object Staff $staff
     */
    public function store(Staff $staff, Request $request)
    {
    	$genKnowledgeData = $request->all();

    	$cur_WorkHistory = $staff->workHistories->where('cur_pos', 1)->first();

        $payroll_id = $genKnowledgeData['payroll_id'] = $staff->payroll_id;
        $pro_code = $genKnowledgeData['pro_code']   = $cur_WorkHistory->pro_code;
        $subject_id = $request->subject_id;
        $genKnowledgeData['qual_date']  = $request->qual_date > 0 ? date('Y-m-d', strtotime($request->qual_date)) : null;
        $genKnowledgeData['created_by'] = Auth::user()->id;
        $genKnowledgeData['updated_by'] = Auth::user()->id;       
       
        StaffQualification::create($genKnowledgeData);

        // Upload prokah ref document
        $qualification = StaffQualification::where('payroll_id', $payroll_id)->where('pro_code', $pro_code)->where('subject_id', $subject_id)->first();
        $qual_id = $qualification->qual_id; 
        $fileName = '';
        if( $request->hasFile('qual_doc') ) {
            $fileUpload = $request->file('qual_doc');
            $fileExtension = $fileUpload->getClientOriginalExtension();
            $fileName = 'qual_'.$staff->payroll_id.'_'.$qual_id.'.'.$fileExtension;
            $filePath = $request->file('qual_doc')->storeAs('pdfs/ref_documents/', $fileName, 'public');
        }
        $qualification->update(['qual_doc' => $fileName]); 

        StaffQualification::where('payroll_id', $payroll_id)->update(['highest_qualification' => 0]); 
        $dd_qualification = StaffQualification::where('payroll_id', $payroll_id)->orderBy('qualification_code', 'DESC')->first();
        //dd($dd_qualification->qualification_code);
        $dd_qualification->update(['highest_qualification' => 1]); 
        
        return redirect()->route('general-knowledge.index', [app()->getLocale(), $staff->payroll_id])
                         ->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit general knowledge info
     *
     * @param  number  $payroll_id
     * @param  Object StaffQualification  $general_knowledge
     */
    public function edit($payroll_id, StaffQualification $general_knowledge)
    {
    	$general_knowledge->qual_date = date('d-m-Y', strtotime($general_knowledge->qual_date));

    	return $general_knowledge;
    }


    /**
     * Update general knowledge info
     *
     * @param  number  $payroll_id
     * @param  Object StaffQualification  $general_knowledge
     */
    public function update($payroll_id, StaffQualification $general_knowledge, Request $request)
    {
    	$genKnowledgeData = $request->all();

    	$genKnowledgeData['qual_date']  = $request->qual_date > 0 ? date('Y-m-d', strtotime($request->qual_date)) : null;
        $genKnowledgeData['updated_by'] = Auth::user()->id;
        
        $general_knowledge->fill($genKnowledgeData)->save();

        $pro_code = $general_knowledge->pro_code;
        $subject_id = $general_knowledge->subject_id;
        $qualification_code = $general_knowledge->qualification_code;
        $qualification = StaffQualification::where('payroll_id', $payroll_id)->where('qualification_code', $qualification_code)->where('pro_code', $pro_code)->where('subject_id', $subject_id)->first();
        $qual_id = $qualification->qual_id; 
        // Upload prokah ref document
        $fileName = '';
        if( $request->hasFile('qual_doc') ) {
            $fileUpload = $request->file('qual_doc');
            $fileExtension = $fileUpload->getClientOriginalExtension();
            $fileName = 'qual_'.$payroll_id.'_'.$qual_id.'.'.$fileExtension;
            $filePath = $request->file('qual_doc')->storeAs('pdfs/ref_documents/', $fileName, 'public');
        }
        $qualification->update(['qual_doc' => $fileName]); 

        StaffQualification::where('payroll_id', $payroll_id)->update(['highest_qualification' => 0]); 
        $dd_qualification = StaffQualification::where('payroll_id', $payroll_id)->orderBy('qualification_code', 'DESC')->first();
        //dd($dd_qualification->qualification_code);
        $dd_qualification->update(['highest_qualification' => 1]); 

        return redirect()->route('general-knowledge.index', [app()->getLocale(), $payroll_id])
                         ->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove general knowledge info
     *
     * @param  number  $payroll_id
     * @param  Object StaffQualification  $general_knowledge
     */
    public function destroy($payroll_id, StaffQualification $general_knowledge)
    {
    	$general_knowledge->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }


    /**
     * Get General Knowledge Rank for requiring subject
     *
     * if it's hierachy <= no required subject/skill otherwise it required
     *
     * @param  Object QualificationCode  $knowledge
     */
    public function getGenKnowledgeRank(QualificationCode $knowledge)
    {
        return $knowledge->qualification_hierachy;
    }
}
