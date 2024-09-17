<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Storage;
use App\Models\AdmirationBlame;
use App\Models\AdmirationSource;
use App\Models\AdmirationType;
use App\Models\Staff;

class AdmirationController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:create-staffs', ['only' => ['index', 'edit']]);
    }


    /**
     * List admiration info belong to a staff
     *
     * @param  Object  Staff $staff
     */
    public function index(Staff $staff)
    {
    	$headerid = $staff->payroll_id;

    	$admirationTypes    = AdmirationType::active()->get();
        $admirationSources  = AdmirationSource::all();

    	$admirations = AdmirationBlame::where('payroll_id', $staff->payroll_id)->orderBy('admiration_date','Desc')->paginate(10);

    	return view('admin.staffs.admiration', compact(
    			'admirations', 'headerid', 'staff', 'admirationTypes', 'admirationSources'
    		));
    }


    /**
     * Store admiration info of student
     *
     * @param  Object Staff $staff
     */
    public function store(Staff $staff, Request $request)
    {
    	$admirationData = $request->all();
        $admiDate = $request->admiration_date;

        // Upload prokah ref document
        $fileName = '';

        if( $request->hasFile('prokah_doc') ) {
            $imageUpload = $request->file('prokah_doc');
            $fileExtension = $imageUpload->getClientOriginalExtension();
            $fileName = 'adm_'.$staff->payroll_id.'_'.time().'.'.$fileExtension;
            $filePath = $request->file('prokah_doc')->storeAs('images/ref_documents/', $fileName, 'public');

            $admirationData['prokah_doc'] = $fileName;
        }

        // Get last workplace
    	$lastWorkPlace = $staff->latestWorkPlace();

        $admirationType = AdmirationType::where('admiration_type_id', $request->admiration_type_id)
                                        ->first();

        $admirationData['payroll_id']       = $staff->payroll_id;
        $admirationData['pro_code']         = !empty($lastWorkPlace) ? $lastWorkPlace->pro_code : 0;
        $admirationData['admiration_date']  = $admiDate > 0 ? date('Y-m-d', strtotime($admiDate)) : null;
        $admirationData['admiration']       = !is_null($request->admiration) ? $request->admiration : 
                                                $admirationType->admiration_type_kh;
        $admirationData['created_by']       = Auth::user()->id;
        $admirationData['updated_by']       = Auth::user()->id;

        AdmirationBlame::create($admirationData);

        return redirect()->route('admirations.index', [app()->getLocale(), $staff->payroll_id])
                         ->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit admiration info
     *
     * @param  number  $payroll_id
     * @param  Object AdmirationBlame  $admiration
     */
    public function edit($payroll_id, AdmirationBlame $admiration)
    {
    	$admiration->admiration_date = date('d-m-Y', strtotime($admiration->admiration_date));

    	return $admiration;
    }


    /**
     * Update admiration info
     *
     * @param  number  $payroll_id
     * @param  Object AdmirationBlame  $admiration
     */
    public function update($payroll_id, AdmirationBlame $admiration, Request $request)
    {
    	$admirationData = $request->all();
        $admiDate = $request->admiration_date;
        
        // Upload prokah ref document
        $fileName = '';

        if( $request->hasFile('prokah_doc') ) {
            $imageUpload = $request->file('prokah_doc');
            //$fileName = 'adm_'.$payroll_id.'_'.time().'.'.$imageUpload->getClientOriginalExtension();

            $fileExtension = $imageUpload->getClientOriginalExtension();
            $fileName = 'adm_'.$payroll_id.'_'.time().'.'.$fileExtension;
            $filePath = $request->file('prokah_doc')->storeAs('images/ref_documents/', $fileName, 'public');

            $admirationData['prokah_doc'] = $fileName;
        }

    	$admirationData['admiration_date'] = $admiDate > 0 ? date('Y-m-d', strtotime($admiDate)) : null;
        $admirationData['updated_by'] = Auth::user()->id;

        $admiration->fill($admirationData)->save();

        return redirect()->route('admirations.index', [app()->getLocale(), $payroll_id])
                         ->with('success', 'Admiration/Blame has beeen updated successfully.');
    }


    /**
     * Remove admiration info
     *
     * @param  number  $payroll_id
     * @param  Object AdmirationBlame  $admiration
     */
    public function destroy($payroll_id, AdmirationBlame $admiration)
    {
    	$admiration->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
