<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QualificationCode;

class QualificationCodeController extends Controller
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
     * Qualification listing
     */
    public function index()
    {
    	$qualifications = QualificationCode::orderBy('qualification_hierachy', 'ASC')->paginate(10);

    	return view('admin.qualifications.index', compact('qualifications'));
    }


    /**
     * Store qualification info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'qualification_kh' => 'required',
    		'qualification_hierachy' => 'required',
    	]);

    	// Get last qualification
    	$existQual = QualificationCode::orderBy('qualification_code', 'desc')->first();

    	$qualData = $request->all();
    	$qualData['qualification_code'] = $existQual ? $existQual->qualification_code + 1 : 1;

    	QualificationCode::create($qualData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing qualification
     *
     * @param  Object  QualificationCode  $qualification_code
     */
    public function edit(QualificationCode $qualification_code)
    {
    	return $qualification_code;
    }


    /**
     * Update existing qualification
     *
     * @param  Object  QualificationCode  $qualification_code
     */
    public function update(Request $request, QualificationCode $qualification_code)
    {
    	$request->validate([
    		'qualification_kh' => 'required',
    		'qualification_hierachy' => 'required',
    	]);

    	$qualification_code->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing qualification info
     *
     * @param  Object  QualificationCode  $qualification
     */
    public function destroy(QualificationCode $qualification_code)
    {
    	$qualification_code->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
