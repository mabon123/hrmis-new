<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CommuneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
        //$this->middleware('permission:view-communes', ['only' => ['index']]);
        //$this->middleware('permission:create-communes', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-communes', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-communes', ['only' => ['destroy']]);

        /*----------Fix issue with count() function when validate upload------- */
        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            // Ignores notices and reports all other kinds... and warnings
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
        }
    }


    /**
     * Communes listing
     */
    public function index()
    {
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $districts = [];

        if (request()->pro_code) {
            $districts = District::where('pro_code', request()->pro_code)
                                ->pluck('name_kh', 'dis_code')
                                ->all();
        }
        
        $communes = Commune::when(request()->dis_code, function($query) {
                                $query->where('dis_code', request()->dis_code);
                            })
                            ->when(request()->com_code, function($query) {
                                $query->where('com_code', request()->com_code);
                            })
                            ->when(request()->commune_kh, function($query) {
                                $query->where('commune_kh', '%'.request()->commune_kh.'%');
                            })
                            ->when(request()->commune_en, function($query) {
                                $query->where('commune_en', '%'.request()->commune_en.'%');
                            })
                            ->orderBy('com_code', 'ASC')
                            ->paginate(10);
        
        return view('admin.tools.communes.index', compact('provinces', 'districts', 'communes'));
    }
    public function search(Request $request)
    {
        $rules = [
            'pro_code' => 'required',
            'dis_code' => 'required'
        ];        
        $request->validate($rules,
            [
            'pro_code.required' => 'ជ្រើសរើស រាជធានី/ខេត្ត!',
            'dis_code.required' => 'ជ្រើសរើស ក្រុង/ស្រុក/ខណ្ឌ!'
        ]);
        $pro = $request->get('pro_code');
        $dis = $request->get('dis_code');
        
        $data = DB::table('communes as com');
        $result = $data
            ->join('districts as dis', 'com.dis_code', '=', 'dis.dis_code')
            ->join('provinces as pro', 'dis.pro_code', '=', 'pro.pro_code')
            ->select('pro.name_kh as province', 'dis.name_kh as district','com.name_kh as commune')
            ->where('dis.pro_code', '=', $pro)
            ->where('com.dis_code', '=', $dis)
            ->orderBy('com.name_kh')
            ->get();
        return $result;
    }
    public function getNewData() {
        $data = DB::table('communes as com');
        $result = $data
            ->join('districts as dis', 'com.dis_code', '=', 'dis.dis_code')
            ->join('provinces as pro', 'dis.pro_code', '=', 'pro.pro_code')
            ->select('com.com_code', 'pro.name_kh as province', 'dis.name_kh as district','com.name_kh as commune')
            ->where('com.add_new', '=', true)
            ->orderBy('pro.name_kh')
            ->orderBy('dis.name_kh')
            ->orderBy('com.name_kh')
            ->get();
        return $result;
    }
    public function generateCommuneCode($district) {
        $maxCode = Commune::where('dis_code', $district)->max('com_code');
        $maxCom = substr($maxCode, 4, 2);
        $maxCom = (int)$maxCom;
        $maxCom += 1;
        $tempValue = $maxCom;
        if ($maxCom < 10) {
            $tempValue = '0'.$maxCom;
        }
        return $district.''.$tempValue;
    }
    public function create()
    {
        $provinces = Province::pluck('name_kh', 'pro_code');
        $communes = $this->getNewData();
        return view('communes.create', [
            'newData' => $communes,
            'provinces' => $provinces,
            'districts' => []
        ]);
    }
    private function validateData(Request $request, $id=0)
    {
        $rules = [
            'pro_code' => 'required',
            'dis_code' => 'required',
            'name_en' => 'required',
            'name_kh' => 'required',
        ];        
        $request->validate($rules,
            [
            'pro_code.required' => 'ជ្រើសរើស រាជធានី/ខេត្ត!',
            'dis_code.required' => 'ជ្រើសរើស ក្រុង/ស្រុក/ខណ្ឌ!',
            'name_en.required' => 'សូមបញ្ចូល ឃុំ/សង្កាត់ ជាភាសារអង់គ្លេស!',
            'name_kh.required' => 'សូមបញ្ចូល ឃុំ/សង្កាត់ ជាភាសារខ្មែរ!'
        ]);
    }


    /**
     * Store commune info
     */
    public function store(Request $request)
    {
        $request->validate([
            'dis_code' => 'required',
            'commune_code' => 'required',
            'name_kh' => 'required',
        ]);

        $communeData = $request->all();
        $communeData['com_code'] = $request->dis_code.$request->commune_code;
        $communeData['active'] = $request->active ? 1 : 0;

        $commune = Commune::where('com_code', $communeData['com_code'])->count();

        // Existing commune code
        if ($commune) {
            $request->validate(['com_code' => 'required|unique:sys_communes']);
        }

        // Store commune
        Commune::create($communeData);

        return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing commune info
     * 
     * @param  Object  Commune  $commune
     */
    public function edit(Commune $commune)
    {
        $commune->pro_code = $commune->district->pro_code;
        $commune->commune_code = substr($commune->com_code, 4, 2);

        return $commune;
    }


    /**
     * Update existing commune info
     * 
     * @param  Object  Commune  $commune
     */
    public function update(Request $request, Commune $commune)
    {
        $request->validate([
            'dis_code' => 'required',
            'commune_code' => 'required',
            'name_kh' => 'required',
        ]);

        $communeData = $request->all();
        $communeData['com_code'] = $request->dis_code.$request->commune_code;
        $communeData['active'] = $request->active ? 1 : 0;

        // Existing commune code
        $existCommune = Commune::where('com_code', $communeData['com_code'])->count();

        if ($existCommune) {
            $request->validate(['com_code' => 'required|unique:sys_communes']);
        }

        $commune->fill($communeData)->save();

        return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing commune info
     * 
     * @param  Object  Commune  $commune
     */
    public function destroy(Commune $commune)
    {
        try {

            $commune->delete();

            return redirect()->back()->withSuccess(__('validation.delete_success'));
        }

        catch (\Throwable $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }


    /**
     * Get all villages belong to a commune
     *
     * API Route
     *
     * @param  Commune $commune
     * @return  Village Array Object
     */
    public function getVillageOfCommune(Commune $commune)
    {
        return $commune->villages;
    }
}
