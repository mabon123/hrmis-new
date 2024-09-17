<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\ContractType;

class ContractTypeController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator', ['except' => ['getContractPositionOfContractType']]);
    }


    /**
     * ContractType listing
     */
    public function index()
    {
    	$contractTypes = ContractType::orderBy('contract_type_id', 'ASC')->paginate(10);

    	return view('admin.contract_teachers.types.index', compact('contractTypes'));
    }


    /**
     * Store ContractType info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'contract_type_kh' => 'required',
    	]);

    	// Get last ContractType
    	$existContractType = ContractType::latest('contract_type_id')->first();

    	$contTypeData = $request->all();
    	$contTypeData['contract_type_id'] = $existContractType ? $existContractType->contract_type_id + 1 : 1;

    	ContractType::create($contTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing ContractType
     *
     * @param  Object  ContractType  $contract_type
     */
    public function edit(ContractType $contract_type)
    {
    	return $contract_type;
    }


    /**
     * Update existing ContractType info
     *
     * @param  Object  ContractType  $contract_type
     */
    public function update(Request $request, ContractType $contract_type)
    {
    	$request->validate([
    		'contract_type_kh' => 'required',
    	]);

    	$contract_type->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing ContractType info
     *
     * @param  Object  ContractType  $contract_type
     */
    public function destroy(ContractType $contract_type)
    {
    	$contract_type->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }


    /**
     * Get contract position of the contract type
     *
     * @param  Object  ContractType  $contract_type
     */
    public function getContractPositionOfContractType(ContractType $contract_type)
    {
    	return $contract_type->contractPositions;
    }
}
