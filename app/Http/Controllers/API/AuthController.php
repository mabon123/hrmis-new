<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Models\ContractTeacher;
use App\Models\Staff;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\WorkHistory;

class AuthController extends Controller
{
    private $base_url = null;
    private $username = null;
    private $passmd5 = null;
    private $sender_id = null;

    public function __construct()
    {
        $this->base_url = config('sms_conf.base_url');
        $this->username = config('sms_conf.username');
        $this->passmd5 = config('sms_conf.passmd5');
        $this->sender_id = config('sms_conf.sender_id');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'user_type' => 'required', //1=General Staff, 2=Contract Staff
            'nid_card' => 'required',
            'phone_number' => 'required',
            //'username' => 'required|string|unique:admin_users,username',
            'username' => 'required|string', // To return costom message
            'password' => 'required|min:6',
            'password_confirmation' => 'required', // To return custom message
            'validate_type' => 'required', //1=Organization, 2=SMS OTP
            'lang' => 'required',
            'reg_type' => 'required', // 1=HRMIS web portal, 2=HRCPD mobile app, 3=CPD website
        ]);
        $lang = $request->lang;
        if ($request->password != $request->password_confirmation) {
            $response = [
                'code' => config('constants.codes.fail_400'),
                'message' => $lang == 'en' ? 'Your password confirmation does not match!' : 'សូមបញ្ជាក់លេខកូដសម្ងាត់ឱ្យបានត្រឹមត្រូវ!'
            ];
            return response($response, 400);
        } else {
            $level_id = 5;
            $staff = '';
            // Government staff
            if ($request->user_type == '1') {
                $request->validate([
                    'payroll_id' => 'required'
                ]);
                $staff = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                    ->select('hrmis_staffs.payroll_id', 'hrmis_staffs.nid_card', 'hrmis_staffs.phone')
                    ->where('cur_pos', 1)
                    ->where('is_cont_staff', 0)
                    ->where('hrmis_staffs.payroll_id', $request->payroll_id)->first();
                if (empty($staff)) {
                    $response = [
                        'code' => config('constants.codes.fail_404'),
                        'message' => $lang == 'en' ? 'Your payroll number is invalid!' : 'អត្តលេខមន្ត្រីរបស់អ្នកមិនត្រឹមត្រូវ!'
                    ];
                    return response($response, 404);
                }
            }
            // If $staff=empty then check with NID for contract staff
            if (empty($staff)) {
                $staff = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                    ->select('hrmis_staffs.payroll_id', 'hrmis_staffs.nid_card', 'hrmis_staffs.phone')
                    ->where('cur_pos', 1)
                    ->where('is_cont_staff', 1)
                    ->where('nid_card', $request->nid_card)->first();
                if (empty($staff)) {
                    $response = [
                        'code' => config('constants.codes.fail_404'),
                        'message' => $lang == 'en' ? 'Your national identity number is invalid!' : 'លេខអត្តសញ្ញាណប័ណ្ណរបស់អ្នកមិនត្រឹមត្រូវ!'
                    ];
                    return response($response, 404);
                }
            }
            // Validate the rest conditions. For NID check its validity if gov staff
            if ($request->user_type == '1' && $request->nid_card != $staff->nid_card) {
                $response = [
                    'code' => config('constants.codes.fail_404'),
                    'message' => $lang == 'en' ? 'Your national identity number is invalid!' : 'លេខអត្តសញ្ញាណប័ណ្ណរបស់អ្នកមិនត្រឹមត្រូវ!'
                ];
                return response($response, 404);
            } else if ($request->phone_number != $staff->phone) {
                $response = [
                    'code' => config('constants.codes.fail_404'),
                    'message' => $lang == 'en' ? 'Your phone number is invalid!' : 'លេខទូរស័ព្ទរបស់អ្នកមិនត្រឹមត្រូវ!'
                ];
                return response($response, 404);
            } else {
                $user = User::where('payroll_id', $staff->payroll_id)->first(); //Get from $staff to avoid null if contract staff
                if (!empty($user)) { //Payroll ID already existed in table user
                    $response = [
                        'code' => config('constants.codes.fail_404'),
                        'message' => $lang == 'en' ? 'Payroll number ' . $staff->payroll_id . ' is already existed in users list please contact your data administrator!' :
                            'អត្តលេខមន្ត្រី ' . $staff->payroll_id . ' មានរួចហើយនៅក្នុងបញ្ជីអ្នកប្រើប្រាស់ប្រព័ន្ធ សូមទាក់ទងអ្នកគ្រប់គ្រងទិន្នន័យក្នុងអង្គភាពរបស់អ្នក!'
                    ];
                    return response($response, 404);
                } else {
                    $user = User::where('username', $request->username)->first();
                    if (!empty($user)) { //Username already existed
                        $response = [
                            'code' => config('constants.codes.fail_404'),
                            'message' => $lang == 'en' ? 'User ' . $request->username . ' is already existed, please use different username. Ex. ' . $request->username . '1' :
                                'ឈ្មោះគណនី ' . $request->username . ' របស់អ្នកដូចឈ្មោះគណនីរបស់គេ ដូច្នេះសូមប្រើឈ្មោះខុសពីនេះ។ ឧទាហរណ៍ ' . $request->username . '1'
                        ];
                        return response($response, 404);
                    } else {
                        $curWorkPlace = WorkHistory::join('sys_locations as t2', 'hrmis_work_histories.location_code', '=', 't2.location_code')
                            ->join('sys_location_types as t3', 't2.location_type_id', '=', 't3.location_type_id')
                            ->where('payroll_id', $staff->payroll_id)
                            ->where('cur_pos', 1)
                            ->select('level_id')
                            ->first();
                        if ($curWorkPlace) {
                            $level_id = $curWorkPlace->level_id;
                        }
                    }
                }
            }

            $data_row = [
                'user_type' => $request->user_type,
                'payroll_id' => $staff->payroll_id, //Get from $staff to avoid null if contract staff. 
                'nid_card' => $request->nid_card,
                'provider_id' => null,
                'level_id' => $level_id,
                'active' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'status' => config('constants.CONST_PENDING'),
                'approver_id' => null,
                'approved_date' => null,
                'validate_type' => $request->validate_type,
                'reg_type' => $request->reg_type,
            ];

            $user = User::create($data_row);
            // Assign role to user
            $user->roles()->attach(8, ['created_by' => 1]);
            if ($user) {
                if ($request->validate_type == 1) {
                    $response = [
                        'data' => $user,
                        'code'  => config('constants.codes.success'),
                        'message' => $lang == 'en' ? config('constants.messages_en.register_success') : config('constants.messages.register_success')
                    ];
                    return response($response, 201);
                } else {
                    $resData = $this->sendSMS($lang, $request->phone_number, $user->id, false);
                    return $resData;
                }
            } else {
                $response_fail = [
                    'code' => config('constants.codes.fail_404'),
                    'message' => $lang == 'en' ? config('constants.messages_en.register_fail') : config('constants.messages.register_fail')
                ];
                return response($response_fail, 500);
            }
        }
    }

    private function sendSMS($lang, $gsmphone, $user_id, $resend = false, $custdata = "")
    {
        $response_fail = [
            'code' => config('constants.codes.fail_404'),
            'message' => $lang == 'en' ? 'There is a problem with SMS service please try again!' : 'មានបញ្ហាបណ្ដាញសេវាSMS សូមព្យាយាមម្តងទៀត!'
        ];

        try {
            if ($resend) {
                $num_otps = UserOtp::where('user_id', $user_id)
                    ->where('otp_type', config('sms_conf.otp_types.user_registration'))
                    ->where('is_verified', 0)->count('id');
                if ($num_otps == 3) {
                    $response = [
                        'code' => '333', //special
                        'message' => 'អ្នកមិនអាចស្នើសុំលេខកូដផ្ទៀងផ្ទាត់ការចុះឈ្មោះច្រើនជាង៣ដងទេ។'
                    ];
                    return response($response, 200);
                }
            }

            $otp_code = rand(100000, 999999);
            $params = [
                'username' => $this->username,
                'pass' => $this->passmd5,
                'sender' => $this->sender_id,
                'cd' => $custdata,
                'smstext' => 'លេខកូដផ្ទៀងផ្ទាត់ការចុះឈ្មោះគណនីរបស់អ្នកគឺ ' . $otp_code,
                'gsm' => $gsmphone
            ];
            $return_value = Http::asForm()->post($this->base_url . 'postsms.aspx', $params);

            if (!empty($return_value) && substr($return_value, 0, 1) == '0') {
                $user_otp = UserOtp::create([
                    'user_id' => $user_id,
                    'otp_type' => config('sms_conf.otp_types.user_registration'),
                    'otp_code' => $otp_code,
                    'expired_at' => Carbon::now()->addMinutes(config('sms_conf.expired_duration')),
                    'is_verified' => 0,
                    'platform' => '',
                    'device_id' => ''
                ]);
                if ($user_otp) {
                    $response = [
                        'code'  => config('constants.codes.success'),
                        'data' => [
                            'phone_number' => $gsmphone,
                            'user_id' => $user_id,
                            'otp_time_limit' => config('sms_conf.expired_duration') * 60, //convert to second
                        ],
                        'message' => 'លេខកូដផ្ទៀងផ្ទាត់ការចុះឈ្មោះគណនីរបស់អ្នក ត្រូវបានផ្ញើររួចរាល់ទៅកាន់លេខទូរស័ព្ទនេះ ' . $gsmphone . '។'
                    ];
                    return response($response, 201);
                } else {
                    return response($response_fail, 500);
                }
            } else {
                return response($response_fail, 500);
            }
        } catch (\Throwable $error) {
            return response($response_fail, 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $fields = $request->validate([
            'user_id'      => 'required',
            'otp_code'      => 'required'
        ]);
        $user_otp = UserOtp::where('user_id', $fields['user_id'])
            ->where('is_verified', 0)
            ->orderBy('expired_at', 'DESC')
            ->first();

        if ($user_otp) {
            if ($user_otp->otp_code != $fields['otp_code']) {
                $response = [
                    'code' => config('constants.codes.fail_400'),
                    'message' => 'លេខកូដផ្ទៀងផ្ទាត់ការចុះឈ្មោះគណនីនេះមិនត្រឹមត្រូវ។'
                ];
                return response($response, 200);
            } else if ($user_otp->expired_at <= Carbon::now()) {
                $response = [
                    'code' => '000', //special condition
                    'message' => 'លេខកូដផ្ទៀងផ្ទាត់ការចុះឈ្មោះគណនីនេះបានអស់សុពលភាពហើយ។'
                ];
                return response($response, 200);
            } else {
                //Update table user to automatically approved by own user
                $user = User::find($fields['user_id']);
                $user_row = [
                    'status' => config('constants.CONST_APPROVED'),
                    'approver_id' => $fields['user_id'],
                    'approved_date' => Carbon::now(),
                ];
                $user->fill($user_row)->save();

                //Update table user OTP
                $user_otp_row = [
                    'is_verified' => 1,
                    'verified_at' => Carbon::now()
                ];
                $user_otp->fill($user_otp_row)->save();

                $response = [
                    'code'  => config('constants.codes.success'),
                    'message' => 'គណនីរបស់អ្នកត្រូវបានបង្កើត និងផ្ទៀងផ្ទាត់ដោយជោគជ័យ។ សូមបញ្ចូលឈ្មោះគណនី និងលេខកូដសម្ងាត់ដើម្បីចូលប្រើកម្មវិធី HRCPD។'
                ];
                return response($response, 200);
            }
        }
    }

    public function requestNewOTP(Request $request)
    {
        $fields = $request->validate([
            'user_id'       => 'required',
            'lang'          => 'required',
            'phone_number'  => 'required'
        ]);
        $resData = $this->sendSMS($fields["lang"], $fields["phone_number"], $fields["user_id"], true);
        return $resData;
    }

    // Login
    public function login(Request $request)
    {
        $fields = $request->validate([
            'username'      => 'required|string',
            'password'      => 'required|string',
            'device_token'  => 'required', //This will be used for notification
            'os_type'       => 'required', //This will be used for notification
            'lang'          => 'required'
        ]);

        $lang = $request->lang;
        $user = User::where('username', $fields['username'])
            ->where('status', config('constants.CONST_APPROVED'))
            ->first();

        // Check username & password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'code'  => config('constants.codes.fail_401'),
                'message' => $lang == 'en' ? config('constants.messages_en.login_fail') : config('constants.messages.login_fail')
            ], 401);
        }
        // Generate user_token
        $token = $user->createToken('usertoken')->plainTextToken;
        //$user->role_id = $user->roles[0]->role_id;
        $data = array(
            "id" => $user->id,
            "user_type" => $user->user_type,
            "username" => $user->username,
            "payroll_id" => $user->payroll_id,
            "nid_card" => $user->nid_card,
            "provider_id" => $user->provider_id,
            "level_id" => $user->level_id,
            "role_id" => $user->roles[0]->role_id,
            "work_place" => $user->work_place
        );

        $approver = [];

        $response = [
            'data' => ['user' => $data, 'approver' => $approver],
            'access_token' => $token,
            'token_type' => 'Bearer',
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? config('constants.messages_en.login_success') : config('constants.messages.login_success')
        ];

        return response($response, 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'id'       => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required', // To return custom message
            'lang'     => 'required'
        ]);
        $lang = $request->lang;
        if ($request->password != $request->password_confirmation) {
            $response = [
                'code' => config('constants.codes.fail_400'),
                'message' => $lang == 'en' ? 'Your password confirmation does not match!' : 'សូមបញ្ជាក់លេខកូដសម្ងាត់ឱ្យបានត្រឹមត្រូវ!'
            ];
            return response($response, 400);
        } else {
            $user = User::find($request->id);
            if ($user) {
                $user->fill(['password' => bcrypt($request->password)])->save();
                $response = [
                    'code'  => config('constants.codes.success'),
                    'message' => $lang == 'en' ? 'Your new password has been changed successfully.' : 'លេខកូដសម្ងាត់ថ្មីរបស់អ្នកត្រូវបានកែប្រែដោយជោគជ័យ។'
                ];
                return response($response, 200);
            }
        }
    }
}
