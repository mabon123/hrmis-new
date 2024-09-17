<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Village;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VillageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
        //$this->middleware('permission:view-villages', ['only' => ['index']]);
        //$this->middleware('permission:create-villages', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-villages', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-villages', ['only' => ['destroy']]);

        /*----------Fix issue with count() function when validate upload------- */
        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            // Ignores notices and reports all other kinds... and warnings
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
        }
    }


    /**
     * Villages listing
     */
    public function index()
    {
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $districts = [];
        $communes = [];

        if (request()->pro_code) {
            $districts = District::where('pro_code', request()->pro_code)
                                ->pluck('name_kh', 'dis_code')
                                ->all();
        }

        if (request()->dis_code) {
            $communes = Commune::where('dis_code', request()->dis_code)
                                ->pluck('name_kh', 'com_code')
                                ->all();
        }

        $villages = Village::when(request()->com_code, function($query) {
                            $query->where('com_code', request()->com_code);
                        })
                        ->orderBy('vil_code', 'ASC')
                        ->paginate(10);

        return view('admin.tools.villages.index', compact('provinces', 'districts', 'communes', 'villages'));
    }

    public function search(Request $request)
    {
        $rules = [
            'pro_code' => 'required',
            'dis_code' => 'required',
            'com_code' => 'required'
        ];        
        $request->validate($rules,
            [
            'pro_code.required' => 'ជ្រើសរើស រាជធានី/ខេត្ត!',
            'dis_code.required' => 'ជ្រើសរើស ក្រុង/ស្រុក/ខណ្ឌ!',
            'com_code.required' => 'ជ្រើសរើស ឃុំ/សង្កាត់!',
        ]);
        $pro = $request->get('pro_code');
        $dis = $request->get('dis_code');
        $com = $request->get('com_code');
        
        $data = DB::table('villages as vil');
        $result = $data
            ->join('communes as com', 'vil.com_code', '=', 'com.com_code')
            ->join('districts as dis', 'com.dis_code', '=', 'dis.dis_code')
            ->join('provinces as pro', 'dis.pro_code', '=', 'pro.pro_code')
            ->select('pro.name_kh as province', 'dis.name_kh as district','com.name_kh as commune','vil.name_kh as village')
            ->where('dis.pro_code', '=', $pro)
            ->where('com.dis_code', '=', $dis)
            ->where('vil.com_code', '=', $com)
            ->orderBy('vil.name_kh')
            ->get();
        return $result;
    }
    public function getNewData() {
        $data = DB::table('villages as vil');
        $result = $data
            ->join('communes as com', 'vil.com_code', '=', 'com.com_code')
            ->join('districts as dis', 'com.dis_code', '=', 'dis.dis_code')
            ->join('provinces as pro', 'dis.pro_code', '=', 'pro.pro_code')
            ->select('vil.vil_code', 'pro.name_kh as province', 'dis.name_kh as district','com.name_kh as commune','vil.name_kh as village')
            ->where('vil.add_new', '=', true)
            ->orderBy('pro.name_kh')
            ->orderBy('dis.name_kh')
            ->orderBy('com.name_kh')
            ->orderBy('vil.name_kh')
            ->get();
        return $result;
    }
    public function generateVillageCode($commune) {
        $maxCode = Village::where('com_code', $commune)->max('vil_code');
        $maxVil = substr($maxCode, 6, 2);
        $maxVil = (int)$maxVil;
        $maxVil += 1;
        $tempValue = $maxVil;
        if ($maxVil < 10) {
            $tempValue = '0'.$maxVil;
        }
        return $commune.''.$tempValue;
    }
    public function create()
    {
        $provinces = Province::pluck('name_kh', 'pro_code');
        $villages = $this->getNewData();
        return view('villages.create', [
            'newData' => $villages,
            'provinces' => $provinces,
            'districts' => [],
            'communes' => []
        ]);
    }
    private function validateData(Request $request, $id=0)
    {
        $rules = [
            'pro_code' => 'required',
            'dis_code' => 'required',
            'com_code' => 'required',
            'name_en' => 'required',
            'name_kh' => 'required',
        ];        
        $request->validate($rules,
            [
            'pro_code.required' => 'ជ្រើសរើស រាជធានី/ខេត្ត!',
            'dis_code.required' => 'ជ្រើសរើស ក្រុង/ស្រុក/ខណ្ឌ!',
            'com_code.required' => 'ជ្រើសរើស ឃុំ/សង្កាត់!',
            'name_en.required' => 'សូមបញ្ចូល ភូមិ-មណ្ឌល ជាភាសារអង់គ្លេស!',
            'name_kh.required' => 'សូមបញ្ចូល ភូមិ-មណ្ឌល ជាភាសារខ្មែរ!'
        ]);
    }


    /**
     * Store village info
     */
    public function store(Request $request)
    {
        $request->validate([
            'pro_code' => 'required',
            'dis_code' => 'required',
            'com_code' => 'required',
            'village_code' => 'required',
            'name_kh' => 'required',
        ]);

        $villageData = $request->all();
        $villageData['vil_code'] = $request->com_code.$request->village_code;

        // Check existing village code
        $existVillage = Village::where('vil_code', $villageData['vil_code'])->count();

        if ($existVillage) {
            $request->validate(['vil_code' => 'required|unique:sys_villages']);
        }

        Village::create($villageData);

        return redirect()->back()->withSuccess(__('validation.add_success'));
    }

    /**
     * Edit existing village info
     * 
     * @param  Object  Village  $village
     */
    public function edit(Village $village)
    {
        $village->pro_code = $village->commune->district->pro_code;
        $village->dis_code = $village->commune->dis_code;
        $village->village_code = substr($village->vil_code, 6, 2);

        return $village;
    }


    /**
     * Update existing village info
     * 
     * @param  Object  Village  $village
     */
    public function update(Request $request, Village $village)
    {
        $request->validate([
            'pro_code' => 'required',
            'dis_code' => 'required',
            'com_code' => 'required',
            'village_code' => 'required',
            'name_kh' => 'required',
        ]);

        $villageData = $request->all();
        $villageData['vil_code'] = $request->com_code.$request->village_code;

        // Check existing village code
        $existVillage = Village::where('vil_code', $villageData['vil_code'])->count();

        if ($existVillage) {
            $request->validate(['vil_code' => 'required|unique:sys_villages']);
        }

        $village->fill($villageData)->save();

        return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing village info
     * 
     * @param  Object  Village  $village
     */
    public function destroy(Village $village)
    {
        try {
            $village->delete();
            return redirect()->back()->withSuccess(__('validation.delete_success'));
        }

        catch (\Throwable $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }
}
