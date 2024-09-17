<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DocumentType;

class DocumentTypeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * DocumentType listing
     */
    public function index()
    {
    	$documentTypes = DocumentType::orderBy('doc_type_id', 'ASC')->paginate(10);

    	return view('admin.document_type.index', compact('documentTypes'));
    }


    /**
     * Store DocumentType info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'doc_type_kh' => 'required',
    	]);

        $existDocType = DocumentType::latest('doc_type_id')->first();

        $docTypeData = $request->all();
    	$docTypeData['doc_type_id'] = $existDocType ? $existDocType->doc_type_id + 1 : 1;
    	DocumentType::create($docTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing DocumentType
     *
     * @param  Object  DocumentType  $documentType
     */
    public function edit(DocumentType $documentType)
    {
    	return $documentType;
    }


    /**
     * Update existing DocumentType info
     *
     * @param  Object  DocumentType  $documentType
     */
    public function update(Request $request, DocumentType $documentType)
    {
    	$request->validate([
    		'doc_type_kh' => 'required',
    	]);

        $docTypeData = $request->all();
    	$documentType->fill($docTypeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing DocumentType info
     *
     * @param  Object  DocumentType  $documentType
     */
    public function destroy(DocumentType $documentType)
    {
    	$documentType->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
