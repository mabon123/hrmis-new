<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\ContractStaffPosition;
use App\Models\ContractType;

class ContStaffPositionController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * ContractStaffPosition listing
     */
    public function index()
    {
    	$contPositions = ContractStaffPosition::orderBy('cont_pos_id', 'ASC')->paginate(10);

    	$contractTypes = ContractType::pluck('contract_type_kh', 'contract_type_id');

    	return view('admin.contract_teachers.positions.index', compact('contPositions', 'contractTypes'));
    }


    /**
     * Store ContractStaffPosition info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'contract_type_id' => 'required',
    		'cont_pos_kh' => 'required',
    	]);

    	// Get last ContractStaffPosition
    	$existContPosition = ContractStaffPosition::latest('cont_pos_id')->first();

    	$contPositionData = $request->all();
    	$contPositionData['cont_pos_id'] = $existContPosition ? $existContPosition->cont_pos_id + 1 : 1;

    	ContractStaffPosition::create($contPositionData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing ContractStaffPosition
     *
     * @param  Object  ContractStaffPosition  $contstaff_position
     */
    public function edit(ContractStaffPosition $contstaff_position)
    {
    	return $contstaff_position;
    }


    /**
     * Update existing ContractStaffPosition info
     *
     * @param  Object  ContractStaffPosition  $contstaff_position
     */
    public function update(Request $request, ContractStaffPosition $contstaff_position)
    {
    	$request->validate([
    		'contract_type_id' => 'required',
    		'cont_pos_kh' => 'required',
    	]);

    	$contstaff_position->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing ContractStaffPosition info
     *
     * @param  Object  ContractStaffPosition  $contstaff_position
     */
    public function destroy(ContractStaffPosition $contstaff_position)
    {
    	$contstaff_position->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
