<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use App\Models\Customer;
use App\Models\Diagnose;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExpertSystemController extends Controller
{
    public $exp_time;

    public function __construct()
    {
        $this->exp_time = 60 * 24;

        config(['jwt.ttl' => $this->exp_time]);
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email:strict|max:255',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email terlalu panjang',
        ]);
        $email = $request->email;
        $user = Customer::where('email', $email)->first();
        if ($user) {
            return responseJson('success', 'Email is found', null, 200);
        } else {
            return responseJson('error', 'Email is not found', null, 404);
        }
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $credentials = $request->only('email', 'password');

        $user = Customer::where('email', $email)->first();

        if (!$user) {
            return responseJson('error', 'Email is not found', null, 404);
        }

        $token = auth()->guard('api')->attempt($credentials);

        if (Hash::check($password, $user->password)) {
            $encrypToken = encrypt($token);
            if (env('APP_ENV') == 'production') {
                $cookie = cookie('jwt', $encrypToken, $this->exp_time, null, '.mitrajamurindonesia.com', true);
            } else {
                $cookie = cookie('jwt', $encrypToken, $this->exp_time, null);
            }
            return response()->json([
                'status' => "success",
                'message' => 'Login Success',
                'data' => null,
            ], 200)->withCookie($cookie);
        } else {
            return responseJson('error', 'Password salah', null, 400);
        }
    }

    public function register(Request $request)
    {
        $messages = [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email terlalu panjang',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama terlalu panjang',
        ];

        $request->validate([
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
        ], $messages);

        $email = $request->email;
        $password = $request->password;
        $name = $request->name;

        $user = Customer::create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name,
        ]);

        $token = auth()->guard('api')->login($user);

        $encrypToken = encrypt($token);
        if (env('APP_ENV') == 'production') {
            $cookie = cookie('jwt', $encrypToken, $this->exp_time, null, '.mitrajamur.com', true);
        } else {
            $cookie = cookie('jwt', $encrypToken, $this->exp_time, null);
        }

        return response()->json([
            'status' => "success",
            'message' => 'Register Success',
            'data' => null,
        ], 200)->withCookie($cookie);
    }

    public function logout()
    {
        if (env('APP_ENV') == 'production') {
            $cookie = Cookie::forget('jwt', null, '.mitrajamur.com');
        } else {
            $cookie = Cookie::forget('jwt');
        }
        auth()->guard('api')->logout();
        return responseJson('success', 'Logout Success', null, 200)->withCookie($cookie);
    }

    public function getDiagnoseList()
    {
        $customer_id = auth()->guard('api')->user()->id;

        $diagnose = DB::table('diagnoses')
            ->join('pest_diseases', 'diagnoses.pest_disease_id', '=', 'pest_diseases.id')
            ->whereNull('pest_diseases.deleted_at')
            ->whereNull('diagnoses.deleted_at')
            ->select('diagnoses.id as diagnoses_id', 'pest_diseases.id as pest_disease_id', 'pest_diseases.label', 'pest_diseases.code', 'pest_diseases.treatment', 'diagnoses.created_at', 'diagnoses.updated_at', 'diagnoses.history')
            ->orderBy('diagnoses.created_at', 'desc')
            ->where('diagnoses.customer_id', '=', $customer_id)
            ->get();

        $diagnoseList = [];
        foreach ($diagnose as $key => $value) {
            $unfiltered = json_decode($value->history)->treatment;
            $diagnoseList[$key]['id'] = $value->diagnoses_id;
            $diagnoseList[$key]['badge'] = count(array_filter($unfiltered, function ($item) {
                return $item->treatment == null;
            })) > 0 ? 'Butuh Konfirmasi' : 'Selesai';
            $diagnoseList[$key]['pest_disease']['id'] = $value->pest_disease_id;
            $diagnoseList[$key]['pest_disease']['label'] = $value->label;
            $diagnoseList[$key]['pest_disease']['code'] = $value->code;
            $diagnoseList[$key]['pest_disease']['treatment'] = json_decode($value->treatment);
            $diagnoseList[$key]['created_at'] = $value->created_at;
            $diagnoseList[$key]['updated_at'] = $value->updated_at;
        }

        return responseJson('success', 'Get Diagnose List Success', $diagnoseList, 200);
    }

    public function getDiagnoseById($id)
    {
        $customer_id = auth()->guard('api')->user()->id;

        $diagnose = DB::table('diagnoses')
            ->join('pest_diseases', 'diagnoses.pest_disease_id', '=', 'pest_diseases.id')
            ->select('diagnoses.id as diagnoses_id', 'pest_diseases.id as pest_disease_id', 'pest_diseases.label', 'pest_diseases.code', 'pest_diseases.treatment', 'diagnoses.created_at', 'diagnoses.updated_at', 'diagnoses.history', 'pest_diseases.description', 'pest_diseases.day')
            ->whereNull('pest_diseases.deleted_at')
            ->where('diagnoses.customer_id', '=', $customer_id)
            ->where('diagnoses.id', '=', $id)
            ->first();

        if (!$diagnose) {
            return responseJson('error', 'Diagnose not found', null, 404);
        }

        $conditions = DB::table('conditions')
            ->select('conditions.id', 'conditions.status', 'conditions.value', 'conditions.treatment', 'conditions.day', 'conditions.is_after')
            ->whereNull('conditions.deleted_at')
            ->where('conditions.pest_disease_id', '=', $diagnose->pest_disease_id)
            ->get();

        $diagnoseList = [];
        $diagnoseList['id'] = $diagnose->diagnoses_id;
        $diagnoseList['history'] = json_decode($diagnose->history);
        $diagnoseList['pest_disease']['id'] = $diagnose->pest_disease_id;
        $diagnoseList['pest_disease']['label'] = $diagnose->label;
        $diagnoseList['pest_disease']['code'] = $diagnose->code;
        $diagnoseList['pest_disease']['treatment'] = json_decode($diagnose->treatment);
        $diagnoseList['pest_disease']['description'] = $diagnose->description;
        $diagnoseList['pest_disease']['day'] = $diagnose->day;
        $diagnoseList['created_at'] = $diagnose->created_at;
        $diagnoseList['updated_at'] = $diagnose->updated_at;
        $diagnoseList['conditions'] = $conditions->map(function ($item) {
            $item->treatment = json_decode($item->treatment);
            return $item;
        });

        return responseJson('success', 'Get Diagnose Detail Success', $diagnoseList, 200);
    }

    public function addDaysTreatment(Request $request)
    {
        $request->validate([
            'diagnose_id' => 'required|exists:diagnoses,id',
            'condition_id' => 'required|exists:conditions,id',
        ]);

        // days is json format cast to array, then push new days
        // first, check diagnose_id is exist
        $diagnose = Diagnose::find($request->diagnose_id);
        $condition = Condition::find($request->condition_id);
        if (!$diagnose) {
            return responseJson('error', 'Diagnose not found', null, 404);
        }
        if (!$condition) {
            return responseJson('error', 'Condition not found', null, 404);
        }

        $last_treatment = Arr::last($diagnose->history['treatment']);

        if ($condition->status == 'DIED' || $condition->status == 'HEALED' || $condition->day == 0) {
            $new_treatment = [
                [
                    'day' => $last_treatment['day'],
                    'id' => $condition->id,
                    'code' => $condition->code,
                    'value' => $condition->value,
                    'status' => $condition->status,
                    'treatment' => $condition->treatment,
                ],
            ];
        } else {
            $new_treatment = [
                [
                    'day' => $last_treatment['day'],
                    'id' => $condition->id,
                    'code' => $condition->code,
                    'value' => $condition->value,
                    'status' => $condition->status,
                    'treatment' => $condition->treatment,
                ],
                [
                    'day' => Carbon::now()->addDays($condition->day),
                    'id' => null,
                    'code' => null,
                    'value' => null,
                    'status' => null,
                    'treatment' => null,
                ]
            ];
        }


        $history = [];
        $history['symptoms'] = $diagnose->history['symptoms'];
        $history['treatment'] = $diagnose->history['treatment'];
        array_pop($history['treatment']);
        array_push($history['treatment'], ...$new_treatment);
        $diagnose->history = $history;
        $diagnose->save();

        return responseJson('success', 'Add Days Treatment Success', null, 200);
    }

    public function postDiagnostic(Request $request)
    {
        $request->validate(
            [
                'symptoms' => 'required|array',
                'symptoms.*' => 'required|distinct|exists:symptoms,code',
                'symptoms' => 'min:1',
            ],
            [
                'symptoms.required' => 'Please select at least 1 symptoms',
                'symptoms.min' => 'Please select at least 1 symptoms',
                // 'symptoms.max' => 'Please select maximum 5 symptoms',
                'symptoms.*.required' => 'Please select at least 1 symptoms',
                'symptoms.*.distinct' => 'Please select unique symptoms',
                'symptoms.*.exists' => 'Please select valid symptoms',
            ]
        );

        if (!$request->symptoms) {
            return response()->json([
                'message' => 'Please select at least 1 symptoms',
                'errors' => [
                    'symptoms' => [
                        'Please select at least 1 symptoms',
                    ],
                ],
            ], 422);
        }

        // if request data is passed validation then continue to process
        // get all symptoms code from request data and store it in array
        $symptoms = $request->symptoms;

        // get all rules from database join with pest_diseases table
        $rules = DB::table('rules')
            ->whereNull('rules.deleted_at')
            ->join('pest_diseases', 'rules.pest_disease_id', '=', 'pest_diseases.id')
            ->whereNull('pest_diseases.deleted_at')
            ->select('rules.id', 'rules.code', 'pest_diseases.label as pest_disease_label', 'pest_diseases.treatment as pest_disease_treatment', 'pest_diseases.description as pest_disease_description', 'pest_diseases.id as pest_disease_id', 'pest_diseases.day as pest_disease_day')
            ->get();

        // check what rules has highest percentage of symptoms
        $highestPercentage = 0;

        // store the rule that has highest percentage of symptoms
        $highestPercentageRule = null;

        // loop through each rule
        foreach ($rules as $rule) {
            // get all symptoms code from current rule
            // rule_symptom table is pivot table between rules and symptoms
            // rule_symptom table has rule_id and symptom_id
            // symptoms table has id and code
            // so we need to join rule_symptom table with symptoms table
            // then select symptoms code from symptoms table
            $ruleSymptoms = DB::table('rule_symptoms')
                ->join('symptoms', 'rule_symptoms.symptoms_id', '=', 'symptoms.id')
                ->where('rule_symptoms.rule_id', $rule->id)
                ->whereNull('symptoms.deleted_at')
                ->select('symptoms.code')
                ->get();

            // convert ruleSymptoms to array
            $ruleSymptoms = $ruleSymptoms->map(function ($item) {
                return $item->code;
            })->toArray();

            // get the percentage of symptoms that match between request data and current rule
            // formula is (count of symptoms that match between request data and current rule) / (count of symptoms in match rule) * 100
            $percentage = count(array_intersect($symptoms, $ruleSymptoms)) / count($ruleSymptoms) * 100;

            // if percentage is higher than highest percentage then store the percentage and the rule
            if ($percentage > $highestPercentage) {
                $highestPercentage = $percentage;
                $highestPercentageRule = $rule;
            }
        }

        // get all symptoms label from request data and store it in array
        $getSymptoms = DB::table('symptoms')
            ->whereNull('deleted_at')
            ->whereIn('code', $symptoms)
            ->select('code', 'label')
            ->get();

        // if highest percentage rule is not null then return success response json with status code 200
        if ($highestPercentageRule) {

            $treatment = json_decode($highestPercentageRule->pest_disease_treatment);
            $treatmentNew = [
                [
                    'day' => Carbon::now(),
                    'treatment' => $treatment,
                ], [
                    'day' => Carbon::now()->addDays($highestPercentageRule->pest_disease_day),
                    'id' => null,
                    'code' => null,
                    'value' => null,
                    'status' => null,
                    'treatment' => null,
                ],
            ];

            $history = [
                'symptoms' => $getSymptoms,
                'treatment' => $treatmentNew,
            ];

            $diagnose = new Diagnose();
            $diagnose->customer_id = auth()->guard('api')->user()->id;
            $diagnose->pest_disease_id = $highestPercentageRule->pest_disease_id;
            $diagnose->history = $history;
            $diagnose->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Diagnostic success',
                'data' => [
                    'id' => $diagnose->id,
                    'pest_disease_id' => $highestPercentageRule->pest_disease_id,
                    'percentage' => round($highestPercentage, 2)
                ],
            ], 200);
        }

        // if highest percentage rule is null then return 200 and return error message
        return response()->json([
            'status' => 'error',
            'message' => 'Diagnostic failed',
        ], 400);
    }

    public function getProfile()
    {
        $user = auth()->guard('api')->user();

        if (!$user) {
            return responseJson('error', 'User not found', null, 404);
        }

        return responseJson('success', 'Get Profile Success', $user, 200);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->guard('api')->user();

        if (!$user) {
            return responseJson('error', 'User not found', null, 404);
        }

        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama terlalu panjang',
            'phone.required' => 'Nomor telepon tidak boleh kosong',
            'phone.max' => 'Nomor telepon terlalu panjang',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email terlalu panjang',
            'email.unique' => 'Email sudah terdaftar',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:customers,phone,' . $user->id,
            'email' => 'required|string|email|max:255|unique:customers,email,' . $user->id,
        ], $messages);

        Customer::where('id', $user->id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return responseJson('success', 'Update Profile Success', $user, 200);
    }
}
