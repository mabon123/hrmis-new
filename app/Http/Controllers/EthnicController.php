<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ethnic;

class EthnicController extends Controller
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
     * Countries listing
     */
    public function index()
    {
    	$ethnics = Ethnic::when(request()->ethnic_kh, function($query) {
                            $query->where('ethnic_kh', 'LIKE', '%'.request()->ethnic_kh.'%');
                        })
                        ->when(request()->ethnic_en, function($query) {
                            $query->where('ethnic_en', 'LIKE', '%'.request()->ethnic_en.'%');
                        })
                        ->orderBy('ethnic_id', 'ASC')->paginate(10);

    	return view('admin.tools.ethnics.index', compact('ethnics'));
    }


    /**
     * Store ethnic info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'ethnic_kh' => 'required',
    	]);

    	// Get last ethnic
    	$existingEthnic = Ethnic::orderBy('ethnic_id', 'desc')->first();

    	$ethnicData = $request->all();
    	$ethnicData['ethnic_id'] = $existingEthnic ? $existingEthnic->ethnic_id + 1 : 1;

    	Ethnic::create($ethnicData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing ethnic
     *
     * @param  Object  Ethnic  $ethnic
     */
    public function edit(Ethnic $ethnic)
    {
    	return $ethnic;
    }


    /**
     * Update existing ethnic info
     *
     * @param  Object  Ethnic  $ethnic
     */
    public function update(Request $request, Ethnic $ethnic)
    {
    	$request->validate([
    		'ethnic_kh' => 'required',
    	]);

    	$ethnic->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing ethnic info
     *
     * @param  Object  Ethnic  $ethnic
     */
    public function destroy(Ethnic $ethnic)
    {
    	$ethnic->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
