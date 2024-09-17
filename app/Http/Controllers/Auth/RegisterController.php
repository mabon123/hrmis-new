<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'payroll_id' => ['required', 'integer', 'unique:hrmis_staffs'],
            'level_id' => ['required', 'integer'],
            'gen_dept_id' => ['required', 'integer'],
            'dpeartment_id' => ['required', 'integer'],
            'pro_code' => ['required', 'string', 'max:2'],
            'dis_code' => ['required', 'string', 'max:4'],
            'location_code' => ['required', 'string', 'max:11'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'payroll_id' => $data['payroll_id'],
            'level_id' => $data['level_id'],
            'gen_dept_id' => $data['gen_dept_id'],
            'dpeartment_id' => $data['dpeartment_id'],
            'pro_code' => $data['pro_code'],
            'dis_code' => $data['dis_code'],
            'location_code' => $data['location_code'],
            'lastdate_login' => $data['lastdate_login'],
            'created_by' => $data['created_by'],
            'updated_by' => $data['updated_by'],
            'active' => $data['active'],
        ]);
    }
}
