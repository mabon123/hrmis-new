<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ReportField;

class ReportFieldController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
    }

    // Listing
    public function index()
    {
        $fields = ReportField::orderBy('id', 'asc')->paginate(10);
        
        return view('admin.tools.report_fields.index', compact('fields'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'table_name' => 'required',
            'field_name' => 'required',
            'title_kh' => 'required',
        ]);

        ReportField::create([
            'table_name' => $request->table_name,
            'field_name' => $request->field_name,
            'title_kh' => $request->title_kh,
            'title_en' => $request->title_en,
            'is_date_field' => $request->is_date_field ? 1 : 0,
            'active' => $request->active ? 1 : 0,
        ]);

        return back()->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(ReportField $report_field)
    {
        return $report_field;
    }

    // Update
    public function update(ReportField $report_field, Request $request)
    {
        $request->validate([
            'table_name' => 'required',
            'field_name' => 'required',
            'title_kh' => 'required',
        ]);

        $report_field->fill([
            'table_name' => $request->table_name,
            'field_name' => $request->field_name,
            'title_kh' => $request->title_kh,
            'title_en' => $request->title_en,
            'is_date_field' => $request->is_date_field ? 1 : 0,
            'active' => $request->active ? 1 : 0,
        ])->save();

        return back()->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(ReportField $report_field)
    {
        $report_field->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
