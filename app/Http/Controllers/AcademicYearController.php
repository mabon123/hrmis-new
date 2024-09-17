<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\AcademicYear;

class AcademicYearController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-academic-year', ['only' => ['index']]);
        //$this->middleware('permission:create-academic-year', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-academic-year', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-academic-year', ['only' => ['destroy']]);
    }


    /**
     * AcademicYear listing
     */
    public function index()
    {
    	$academicYears = AcademicYear::orderBy('year_id', 'ASC')->paginate(10);

    	return view('admin.academic_years.index', compact('academicYears'));
    }


    /**
     * Store AcademicYear info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'year_kh' => 'required',
    	]);

    	// Get last AcademicYear
    	$existAcademicYear = AcademicYear::latest('year_id')->first();

        // If this new record is cur_academic_year, then change others to 0
        $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        if ($request->cur_year && !empty($curAcademicYear)) {
            $curAcademicYear->fill(['cur_year' => 0])->save();
        }

    	$academicYearData = $request->all();
        $academicYearData['year_id'] = $existAcademicYear ? $existAcademicYear->year_id + 1 : 1;
        $academicYearData['cur_year'] = $request->cur_year ? 1 : 0;
    	$academicYearData['start_date'] = $request->start_date > 0 ? 
                                            date('Y-m-d', strtotime($request->start_date)) : null;
        $academicYearData['end_date'] = $request->end_date > 0 ? 
                                            date('Y-m-d', strtotime($request->end_date)) : null;
        
    	AcademicYear::create($academicYearData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing AcademicYear
     *
     * @param  Object  AcademicYear  $academic_year
     */
    public function edit(AcademicYear $academic_year)
    {
        $academic_year->start_date = $academic_year->start_date > 0 ? 
                                        date('d-m-Y', strtotime($academic_year->start_date)) : null;
        $academic_year->end_date = $academic_year->end_date > 0 ? 
                                        date('d-m-Y', strtotime($academic_year->end_date)) : null;

    	return $academic_year;
    }


    /**
     * Update existing AcademicYear info
     *
     * @param  Object  AcademicYear  $academic_year
     */
    public function update(Request $request, AcademicYear $academic_year)
    {
    	$request->validate([
    		'year_kh' => 'required',
    	]);

        // If this new record is cur_academic_year, then change others to 0
        $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        if ($request->cur_year && !empty($curAcademicYear)) {
            $curAcademicYear->fill(['cur_year' => 0])->save();
        }

        $academicYearData = $request->all();
        $academicYearData['cur_year'] = $request->cur_year ? 1 : 0;
        $academicYearData['start_date'] = $request->start_date > 0 ? 
                                            date('Y-m-d', strtotime($request->start_date)) : null;
        $academicYearData['end_date'] = $request->end_date > 0 ? 
                                            date('Y-m-d', strtotime($request->end_date)) : null;

    	$academic_year->fill($academicYearData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing AcademicYear info
     *
     * @param  Object  AcademicYear  $academic_year
     */
    public function destroy(AcademicYear $academic_year)
    {
    	$academic_year->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
