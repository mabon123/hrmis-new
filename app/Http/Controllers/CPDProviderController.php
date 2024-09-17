<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Image;
use Storage;
use Carbon\Carbon;
use App\Models\CPD\Accreditation;
use App\Models\CPD\Provider;
use App\Models\CPD\ProviderCategory;
use App\Models\CPD\ProviderType;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Village;
use App\Models\User;

class CPDProviderController extends Controller
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
        $providers = Provider::paginate(20);

        return view('admin.cpd_tcp.cpd_providers.index', compact('providers'));
    }

    // Create
    public function create()
    {
        $providerTypes = ProviderType::pluck('provider_type_kh', 'provider_type_id')->all();
        $providerCats = ['' => __('common.choose').' ...'];
        $accreditations = Accreditation::pluck('accreditation_kh', 'accreditation_id')->all();

        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();

    	return view('admin.cpd_tcp.cpd_providers.create', compact(
                'providerTypes', 'providerCats', 'accreditations', 'provinces'
            ));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'provider_type_id' => 'required',
            'provider_cat_id' => 'required',
            'accreditation_id' => 'required',
            'accreditation_date' => 'required',
            'provider_kh' => 'required',
            'provider_en' => 'required',
            'provider_phone' => 'required',
            'pro_code' => 'required',
            'dis_code' => 'required',
            'com_code' => 'required',
            'vil_code' => 'required',
            'level_id' => 'required',
            'role_id' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        
        // Upload provider logo
        if( $request->hasFile('provider_logo') ) {
            $providerName = strtolower(str_replace(' ', '_', $request->provider_en));
            $imageUpload = $request->file('provider_logo');
            $fileName = $providerName.'.'.$imageUpload->getClientOriginalExtension();

            $profileImage = Image::make($imageUpload)->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            Storage::disk('public')->put('images/cpd_providers/'.$fileName, $profileImage);
        }
        
        $newProvider = Provider::create([
            'provider_type_id' => $request->provider_type_id,
            'payroll_id' => $request->payroll_id,
            'provider_cat_id' => $request->provider_cat_id,
            'accreditation_id' => $request->accreditation_id,
            'accreditation_date' => date('Y-m-d', strtotime($request->accreditation_date)),
            'provider_kh' => $request->provider_kh,
            'provider_en' => $request->provider_en,
            'provider_email' => $request->provider_email,
            'provider_phone' => $request->provider_phone,
            'provider_logo' => $fileName,
            'pro_code' => $request->pro_code,
            'dis_code' => $request->dis_code,
            'com_code' => $request->com_code,
            'vil_code' => $request->vil_code,
            'description_kh' => $request->description_kh,
            'description_en' => $request->description_en,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        // Create new user account for cpd provider
        $newProviderAcc = User::create([
            'user_type' => 1,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'payroll_id' => null,
            'nid_card' => null,
            'provider_id' => $newProvider->provider_id,
            'level_id' => $request->level_id,
            'status' => config('constants.CONST_APPROVED'),
            'approver_id' => auth()->user()->id,
            'approved_date' => Carbon::now(),
            'validate_type' => null,
            'reg_type' => 1,
            'active' => 1,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        // Assign role to user
        $newProviderAcc->roles()->attach($request->role_id, ['created_by' => auth()->user()->id]);

        return redirect()->route('cpd-providers.index', app()->getLocale())
                         ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(Provider $cpd_provider)
    {
        $headerid = $cpd_provider->provider_id;
        $providerTypes = ProviderType::pluck('provider_type_kh', 'provider_type_id')->all();
        $providerCats = ProviderCategory::where('provider_type_id', $cpd_provider->provider_type_id)
                                        ->pluck('provider_cat_kh', 'provider_cat_id')
                                        ->all();
        $providerCats = ['' => __('common.choose').' ...'] + $providerCats;
        $accreditations = Accreditation::pluck('accreditation_kh', 'accreditation_id')->all();
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $districts = District::active()->whereProCode($cpd_provider->pro_code)
                            ->pluck('name_kh', 'dis_code')
                            ->all();
        $communes = Commune::whereDisCode($cpd_provider->dis_code)
                            ->pluck('name_kh', 'com_code')
                            ->all();
        $villages = Village::whereComCode($cpd_provider->com_code)
                            ->pluck('name_kh', 'vil_code')
                            ->all();

        $cpd_provider->accreditation_date = date('d-m-Y', strtotime($cpd_provider->accreditation_date));

        $providerUser = User::where('provider_id', $cpd_provider->provider_id)
                            ->select('id', 'username')
                            ->first();
        
        return view('admin.cpd_tcp.cpd_providers.create', compact(
                'providerTypes', 'providerCats', 'accreditations', 
                'provinces', 'headerid', 'districts', 'communes', 'villages', 
                'cpd_provider', 'providerUser'
            ));
    }

    // Update
    public function update(Request $request, Provider $cpd_provider)
    {
        $request->validate([
            'provider_type_id' => 'required',
            'provider_cat_id' => 'required',
            'accreditation_id' => 'required',
            'accreditation_date' => 'required',
            'provider_kh' => 'required',
            'provider_en' => 'required',
            'provider_phone' => 'required',
            'pro_code' => 'required',
            'dis_code' => 'required',
            'com_code' => 'required',
            'vil_code' => 'required',
        ]);
        
        // Upload provider logo
        if( $request->hasFile('provider_logo') ) {
            $providerName = strtolower(str_replace(' ', '_', $request->provider_en));
            $imageUpload = $request->file('provider_logo');
            $fileName = $providerName.'.'.$imageUpload->getClientOriginalExtension();

            $profileImage = Image::make($imageUpload)->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            Storage::disk('public')->put('images/cpd_providers/'.$fileName, $profileImage);

            $cpd_provider->fill([
                'provider_logo' => $fileName,
            ])->save();
        }
        
        $cpd_provider->fill([
            'provider_type_id' => $request->provider_type_id,
            'payroll_id' => $request->payroll_id,
            'provider_cat_id' => $request->provider_cat_id,
            'accreditation_id' => $request->accreditation_id,
            'accreditation_date' => date('Y-m-d', strtotime($request->accreditation_date)),
            'provider_kh' => $request->provider_kh,
            'provider_en' => $request->provider_en,
            'provider_email' => $request->provider_email,
            'provider_phone' => $request->provider_phone,
            'pro_code' => $request->pro_code,
            'dis_code' => $request->dis_code,
            'com_code' => $request->com_code,
            'vil_code' => $request->vil_code,
            'description_kh' => $request->description_kh,
            'description_en' => $request->description_en,
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now(),
        ])->save();

        // If there $request->password => then change new password
        if ($request->password) {
            $providerUser = User::where('provider_id', $cpd_provider->provider_id)->first();

            if (!empty($providerUser)) {
                $providerUser->fill([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'updated_by' => auth()->user()->id,
                ])->save();
            }
            else {
                // Create new user account for cpd provider
                $newProviderAcc = User::create([
                    'user_type' => 1,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'payroll_id' => null,
                    'nid_card' => null,
                    'provider_id' => $cpd_provider->provider_id,
                    'level_id' => $request->level_id,
                    'status' => config('constants.CONST_APPROVED'),
                    'approver_id' => auth()->user()->id,
                    'approved_date' => Carbon::now(),
                    'validate_type' => null,
                    'reg_type' => 1,
                    'active' => 1,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ]);

                // Assign role to user
                $newProviderAcc->roles()->attach($request->role_id, ['created_by' => auth()->user()->id]);
            }
        }

        return redirect()->route('cpd-providers.edit', [app()->getLocale(), $cpd_provider->provider_id])
                         ->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(Provider $cpd_provider)
    {
        $user = User::where('provider_id', $cpd_provider->provider_id)->first();
        
        if (!empty($user)) {
            $user->roles()->detach($user->role_id); // Remove user_role
            $user->delete(); // Remove user account
        }
        
        $cpd_provider->delete(); // Remove cpd_provider

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }

    // Get provider category of a provider type
    public function getProviderCategoryofProviderType($provider_type_id)
    {
        return ProviderCategory::where('provider_type_id', $provider_type_id)
                    ->pluck('provider_cat_kh', 'provider_cat_id')
                    ->all();
    }
}
