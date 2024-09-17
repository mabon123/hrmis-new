<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HistoryType;

class HistoryTypeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * HistoryType listing
     */
    public function index()
    {
    	$historyTypes = HistoryType::orderBy('his_type_id', 'ASC')->paginate(10);

    	return view('admin.history_type.index', compact('historyTypes'));
    }


    /**
     * Store HistoryType info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'his_type_kh' => 'required',
    	]);

        $existHistoryType = HistoryType::latest('his_type_id')->first();

        $historyTypeData = $request->all();
    	$historyTypeData['his_type_id'] = $existHistoryType ? $existHistoryType->his_type_id + 1 : 1;
        $historyTypeData['active'] = $request->active ? 1 : 0;
    	HistoryType::create($historyTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing HistoryType
     *
     * @param  Object  HistoryType  $historyType
     */
    public function edit(HistoryType $historyType)
    {
    	return $historyType;
    }


    /**
     * Update existing HistoryType info
     *
     * @param  Object  HistoryType  $historyType
     */
    public function update(Request $request, HistoryType $historyType)
    {
    	$request->validate([
    		'his_type_kh' => 'required',
    	]);
        $historyTypeData = $request->all();
    	$historyTypeData['active'] = $request->active ? 1 : 0;
    	$historyType->fill($historyTypeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing HistoryType info
     *
     * @param  Object  HistoryType  $historyType
     */
    public function destroy(HistoryType $historyType)
    {
    	$historyType->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
