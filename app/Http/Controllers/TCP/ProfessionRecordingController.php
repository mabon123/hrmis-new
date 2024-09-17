<?php

namespace App\Http\Controllers\TCP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;
use App\Models\TCP\ProfessionRecording;

class ProfessionRecordingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:edit-staffs', ['only' => ['store', 'edit', 'update']]);
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'tcp_prof_cat_id' => 'required',
            'tcp_prof_rank_id' => 'required',
            'date_received' => 'required',
            'prokah_num' => 'required',
            'ref_document' => 'required',
            'description' => 'required',
        ]);

        // Upload prokah ref document
        $fileName = '';

        if( $request->hasFile('ref_document') ) {
            $imageUpload = $request->file('ref_document');
            $fileName = 'tcp_prof_'.$request->payroll_id.'_'.$request->tcp_prof_cat_id.$request->tcp_prof_rank_id.time().'.'.($imageUpload->getClientOriginalExtension() == 'pdf' ? $imageUpload->getClientOriginalExtension() : 'png');

            $filePath = $request->file('ref_document')->storeAs('images/ref_documents/', $fileName, 'public');
        }

        ProfessionRecording::create([
            'tcp_prof_cat_id' => $request->tcp_prof_cat_id,
            'tcp_prof_rank_id' => $request->tcp_prof_rank_id,
            'payroll_id' => $request->payroll_id,
            'date_received' => date('Y-m-d', strtotime($request->date_received)),
            'prokah_num' => $request->prokah_num,
            'ref_document' => $fileName,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('staffs.edit', [app()->getLocale(), $request->payroll_id])
            ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(ProfessionRecording $tcp_profession)
    {
        $tcp_profession->date_received = date('d-m-Y', strtotime($tcp_profession->date_received));

        return $tcp_profession;
    }

    // Update
    public function update(ProfessionRecording $tcp_profession, Request $request)
    {
        $request->validate([
            'tcp_prof_cat_id' => 'required',
            'tcp_prof_rank_id' => 'required',
            'date_received' => 'required',
            'prokah_num' => 'required',
            'description' => 'required',
        ]);

        // Re-upload prokah ref document
        $fileName = $tcp_profession->ref_document;

        if( $request->hasFile('ref_document') ) {
            $imageUpload = $request->file('ref_document');
            $fileName = 'tcp_prof_'.$request->payroll_id.'_'.$request->tcp_prof_cat_id.$request->tcp_prof_rank_id.time().'.'.($imageUpload->getClientOriginalExtension() == 'pdf' ? $imageUpload->getClientOriginalExtension() : 'png');

            $filePath = $request->file('ref_document')->storeAs('images/ref_documents/', $fileName, 'public');
        }

        $tcp_profession->fill([
            'tcp_prof_cat_id' => $request->tcp_prof_cat_id,
            'tcp_prof_rank_id' => $request->tcp_prof_rank_id,
            'payroll_id' => $request->payroll_id,
            'date_received' => date('Y-m-d', strtotime($request->date_received)),
            'prokah_num' => $request->prokah_num,
            'ref_document' => $fileName,
            'description' => $request->description,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_by' => auth()->user()->id,
        ])->save();

        return redirect()->route('staffs.edit', [app()->getLocale(), $request->payroll_id])
            ->withSuccess(__('validation.update_success'));
    }

    // Destroy
    public function destroy(ProfessionRecording $tcp_profession)
    {
        Storage::disk('public')->delete('images/ref_documents/'.$tcp_profession->ref_document);
        $tcp_profession->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
