<?php

namespace App\Http\Controllers\ApiV1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Staff;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function getUser($username, $nid, $phone)
    {
        try {
            $data = User::join('hrmis_staffs', 'admin_users.payroll_id', '=', 'hrmis_staffs.payroll_id')
                ->where('username', $username)
                ->where('hrmis_staffs.nid_card', $nid)
                ->where('hrmis_staffs.phone', $phone)
                ->select('username', 'hrmis_staffs.payroll_id', 'hrmis_staffs.nid_card', 'hrmis_staffs.phone',
                'name_kh', 'surname_kh', 'sex')
                ->first();

            if(!empty($data)) {
                $curWorkPlace = $data->staff->currentWorkPlace();
                $curPosition = $data->staff->currentPosition();

                $response = [
                    'username'      => $data->username,
                    'payroll_id'    => $data->payroll_id,
                    'nid_card'      => $data->nid_card,
                    'phone_number'  => $data->phone,
                    'first_name'    => $data->name_kh,
                    'last_name'     => $data->surname_kh,
                    'gender'        => $data->sex == 1 ? 'ប្រុស' : 'ស្រី',
                    'school'        => $data->work_place->location_kh,
                    'province'      => $curWorkPlace != null && $curWorkPlace->province != null ? $curWorkPlace->province->name_kh : null,
                    'position'      => $curPosition != null ? $curPosition->position_kh : ''
                ];
                return response($response);
            }else{
                return response(["message"=>"No record found!"]);
            }
        } catch (\Exception $exeption) {
            return response(["message"=>$exeption->getMessage()]);
        }
    }
}
