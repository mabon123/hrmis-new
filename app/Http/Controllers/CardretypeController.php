<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CardreType;

class CardretypeController extends Controller
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
     * CardreType listing
     */
    public function index()
    {
    	$cardretypes = CardreType::orderBy('cardre_type_id', 'ASC')->paginate(10);

    	return view('admin.cardretypes.index', compact('cardretypes'));
    }


    /**
     * Store cardretype info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'cardre_type_kh' => 'required',
    	]);

    	// Get last cardretype
    	$existCardretype = CardreType::latest('cardre_type_id')->first();
    	
    	$cardretypeData = $request->all();
    	$cardretypeData['cardre_type_id'] = $existCardretype ? $existCardretype->cardre_type_id + 1 : 1;
    	
    	CardreType::create($cardretypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing cardretype
     *
     * @param  Object  CardreType  $cardretype
     */
    public function edit(CardreType $cardretype)
    {
    	return $cardretype;
    }


    /**
     * Update existing cardretype info
     *
     * @param  Object  CardreType  $cardretype
     */
    public function update(Request $request, CardreType $cardretype)
    {
    	$request->validate([
    		'cardre_type_kh' => 'required',
    	]);

    	$cardretype->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing cardretype info
     *
     * @param  Object  CardreType  $cardretype
     */
    public function destroy(CardreType $cardretype)
    {
    	$cardretype->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
