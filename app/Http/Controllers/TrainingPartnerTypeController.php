<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\TrainingPartnerType;

class TrainingPartnerTypeController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-partner-type', ['only' => ['index']]);
        //$this->middleware('permission:create-partner-type', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-partner-type', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-partner-type', ['only' => ['destroy']]);
    }


    /**
     * TrainingPartnerType listing
     */
    public function index()
    {
    	$partnerTypes = TrainingPartnerType::when(request()->partner_type_kh, function($query) {
                                            $query->where('partner_type_kh', 'LIKE', '%'.request()->partner_type_kh.'%');
                                        })
                                        ->when(request()->partner_type_en, function($query) {
                                            $query->where('partner_type_en', 'LIKE', '%'.request()->partner_type_en.'%');
                                        })
                                        ->orderBy('partner_type_id', 'ASC')->paginate(10);

    	return view('admin.tools.partner_types.index', compact('partnerTypes'));
    }


    /**
     * Store TrainingPartnerType info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'partner_type_kh' => 'required',
    	]);

    	$partnerTypeData = $request->all();
    	$partnerTypeData['active'] = $request->active ? 1 : 0;
    	$partnerTypeData['created_by'] = Auth::user()->id;
    	$partnerTypeData['updated_by'] = Auth::user()->id;

    	TrainingPartnerType::create($partnerTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing TrainingPartnerType
     *
     * @param  Object  TrainingPartnerType  $training_partner_type
     */
    public function edit(TrainingPartnerType $training_partner_type)
    {
    	return $training_partner_type;
    }


    /**
     * Update existing TrainingPartnerType info
     *
     * @param  Object  TrainingPartnerType  $training_partner_type
     */
    public function update(Request $request, TrainingPartnerType $training_partner_type)
    {
    	$request->validate([
    		'partner_type_kh' => 'required',
    	]);

    	$partnerTypeData = $request->all();
    	$partnerTypeData['active'] = $request->active ? 1 : 0;
    	$partnerTypeData['updated_by'] = Auth::user()->id;

    	$training_partner_type->fill($partnerTypeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing TrainingPartnerType info
     *
     * @param  Object  TrainingPartnerType  $training_partner_type
     */
    public function destroy(TrainingPartnerType $training_partner_type)
    {
    	$training_partner_type->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
