<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\TraineeStatus;

class TraineeStatusController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-trainee-status', ['only' => ['index']]);
        //$this->middleware('permission:create-trainee-status', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-trainee-status', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-trainee-status', ['only' => ['destroy']]);
    }


    /**
     * Trainee status listing
     */
    public function index()
    {
    	$traineeStatus = TraineeStatus::orderBy('trainee_status_id', 'ASC')->paginate(10);

    	return view('admin.trainee_status.index', compact('traineeStatus'));
    }


    /**
     * Store trainee status info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'trainee_status_kh' => 'required',
    	]);

    	// Get last trainee status
    	$existStatus = TraineeStatus::latest('trainee_status_id')->first();

    	$statusData = $request->all();
    	$statusData['trainee_status_id'] = $existStatus ? $existStatus->trainee_status_id + 1 : 1;

    	TraineeStatus::create($statusData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing trainee status
     *
     * @param  Object  TraineeStatus  $trainee_status
     */
    public function edit(TraineeStatus $trainee_status)
    {
    	return $trainee_status;
    }


    /**
     * Update existing trainee status info
     *
     * @param  Object  TraineeStatus  $trainee_status
     */
    public function update(Request $request, TraineeStatus $trainee_status)
    {
    	$request->validate([
    		'trainee_status_kh' => 'required',
    	]);

    	$trainee_status->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing trainee status info
     *
     * @param  Object  TraineeStatus  $trainee_status
     */
    public function destroy(TraineeStatus $trainee_status)
    {
    	$trainee_status->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
