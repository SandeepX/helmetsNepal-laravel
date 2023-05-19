<?php

namespace App\Http\Services;

use App\Events\EmailVerificationEvent;
use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EDateFormat;
use App\Http\Repositories\CustomerRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Request;

class CustomerApiServices
{
    protected CustomerRepository $customerRepository;
    private string $notFoundMessage = "Sorry! Customer not found";
    private string $error_message = "Oops! Something went wrong.";

    public function __construct()
    {
        $this->customerRepository = new CustomerRepository();
    }

    /**
     * @throws SMException
     */

    public function getCustomerDetailById($customerId)
    {
        return $this->customerRepository->find($customerId);
    }

    public function registerCustomer($request): JsonResponse
    {
        $validator_register = $this->checkCustomerRegisterValidation($request);
        if ($validator_register->fails()) {
            $validation_error = [];
            if ($validator_register->errors()->has('first_name')) {
                $validation_error['error']['first_name'] = $validator_register->errors()->first('first_name');
            }
            if ($validator_register->errors()->has('middle_name')) {
                $validation_error['error']['middle_name'] = $validator_register->errors()->first('middle_name');
            }
            if ($validator_register->errors()->has('last_name')) {
                $validation_error['error']['last_name'] = $validator_register->errors()->first('last_name');
            }
            if ($validator_register->errors()->has('email')) {
                $validation_error['error']['email'] = $validator_register->errors()->first('email');
            }
            if ($validator_register->errors()->has('primary_contact_1')) {
                $validation_error['error']['primary_contact_1'] = $validator_register->errors()->first('primary_contact_1');
            }
            if ($validator_register->errors()->has('password')) {
                $validation_error['error']['password'] = $validator_register->errors()->first('password');
            }

            return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
        }
        $data = $request->all();
        $password = Helper::passwordHashing($data['password']);
        $_customer = $this->customerRepository->save([
            "first_name" => $data['first_name'],
            "middle_name" => $data['middle_name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "primary_contact_1" => $data['primary_contact_1'],
            "password" => $password,
            "user_type" => $data['user_type'],
        ]);
        if ($_customer) {
            if ($_customer->user_type == 'customer') {
                event(new EmailVerificationEvent($_customer));
//                dispatch(new EmailVerifyJob($_customer));
            }
            return Helper::successResponseAPI(message: "Register Successful");
        }
        return Helper::errorResponseAPI(message: $this->error_message);
    }


    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function checkCustomerRegisterValidation($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:customers|max:50',
            'primary_contact_1' => 'required|digits:10|unique:customers',
            'password' => 'required|confirmed|string|between:8,100',
        ]);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function loginCustomer($request): JsonResponse
    {
        $validator = $this->checkLoginValidation($request);
        if ($validator->fails()) {
            $validation_error = [];
            if ($validator->errors()->has('email')) {
                $validation_error['error']['email'] = $validator->errors()->first('email');
            }
            if ($validator->errors()->has('password')) {
                $validation_error['error']['password'] = $validator->errors()->first('password');
            }
            return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
        }

        $customerWithEmail = $this->customerRepository->getCustomerByEmail($request->email);

        if ($customerWithEmail) {
            if ($customerWithEmail->user_type == 'customer' && !($customerWithEmail->is_verified)) {
                event(new EmailVerificationEvent($customerWithEmail));
//                dispatch(new EmailVerifyJob($customerWithEmail));
                return Helper::errorResponseAPI(message: "Please verify your email address sent in your mail to access your account.");
            }

            if ($customerWithEmail->user_type == 'vendor' && !($customerWithEmail->is_verified)) {
                return Helper::errorResponseAPI(message: "Contact Administration for verification");
            }
            $data = $request->all();
            $check_password = Helper::checkPassword($data['password'], $customerWithEmail->password);
            if ($check_password) {
                $credential = [
                    'email' => $data['email'],
                    'password' => Helper::getSaltedPassword($data['password'])
                ];

                if ($this->getAttempt($credential)) {
                    $_customer = Auth::guard('customer')->user();
                    $last_login_ipAddress = Request::ip();
                    $this->customerRepository->update($_customer, [
                        'last_login' => now()->format((string)EDateFormat::YmdHis->value),
                        'last_login_ipAddress' => $last_login_ipAddress
                    ]);
                    $return_response =
                        [
                            'token' => $_customer->createToken('AppName')->accessToken,
                            'first_name' => $_customer->first_name,
                            'last_name' => $_customer->last_name,
                            'profile_image_path' => ($_customer->profile_image) ? $_customer->profile_image_path : '',
                            'user_type' => $_customer->user_type ?? "",
                            'email_status' => $_customer->is_verified ?? false,
                        ];
                    return Helper::successResponseAPI(message: "Success", data: $return_response);
                }
            } else {
                return Helper::errorResponseAPI(message: "Password is Incorrect", code: Response::HTTP_UNAUTHORIZED, status: Response::HTTP_UNAUTHORIZED);
            }
        }
        return Helper::errorResponseAPI(message: "Email does not matched.", code: Response::HTTP_UNAUTHORIZED, status: Response::HTTP_UNAUTHORIZED);

    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function checkLoginValidation($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|max:255|min:6',
        ], [
                'email.required' => 'Email is required',
                'password.required' => 'Password field is required.',
                'password.min' => 'Username or Password is incorrect. Please try again',
                'password.max' => 'Username or Password is incorrect. Please try again',
            ]
        );
    }

    protected function getAttempt(array $credentials): bool
    {
        return Auth::guard('customer')->attempt($credentials);
    }

    private function checkUpdateCustomerProfileValidation($request, $_customer): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'primary_contact_1' => 'required|digits:10|unique:customers,primary_contact_1,' . $_customer->id,
            'Secondary_contact_1' => 'nullable|digits:10|unique:customers,Secondary_contact_1,' . $_customer->id,
            'primary_contact_2' => 'nullable|digits:10|unique:customers,primary_contact_2,' . $_customer->id,
            'Secondary_contact_2' => 'nullable|digits:10|unique:customers,Secondary_contact_2,' . $_customer->id,
            'address_line1' => 'required|string|between:2,100',
        ]);
    }

    public function updateCustomerProfile($request): JsonResponse
    {
        $data = $request->all();
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {


            $validator_register = $this->checkUpdateCustomerProfileValidation($request, $_customer);
            if ($validator_register->fails()) {
                $validation_error = [];
                if ($validator_register->errors()->has('first_name')) {
                    $validation_error['error']['first_name'] = $validator_register->errors()->first('first_name');
                }
                if ($validator_register->errors()->has('last_name')) {
                    $validation_error['error']['last_name'] = $validator_register->errors()->first('last_name');
                }
                if ($validator_register->errors()->has('address_line1')) {
                    $validation_error['error']['address_line1'] = $validator_register->errors()->first('address_line1');
                }
                if ($validator_register->errors()->has('primary_contact_1')) {
                    $validation_error['error']['primary_contact_1'] = $validator_register->errors()->first('primary_contact_1');
                }
                if ($validator_register->errors()->has('Secondary_contact_1')) {
                    $validation_error['error']['Secondary_contact_1'] = $validator_register->errors()->first('Secondary_contact_1');
                }
                if ($validator_register->errors()->has('primary_contact_2')) {
                    $validation_error['error']['primary_contact_2'] = $validator_register->errors()->first('primary_contact_2');
                }
                if ($validator_register->errors()->has('Secondary_contact_2')) {
                    $validation_error['error']['Secondary_contact_2'] = $validator_register->errors()->first('Secondary_contact_2');
                }
                return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
            }

            $_customer_update = $this->customerRepository->update($_customer, [
                "first_name" => $data['first_name'],
                "middle_name" => $data['middle_name'],
                "last_name" => $data['last_name'],
                "address_line1" => $data['address_line1'],
                "address_line2" => $data['address_line2'],
                "primary_contact_1" => $data['primary_contact_1'],
                "Secondary_contact_1" => $data['secondary_contact_1'],
                "primary_contact_2" => $data['primary_contact_2'],
                "Secondary_contact_2" => $data['secondary_contact_2'],
            ]);
            if ($_customer_update) {
                $_customer_return = $this->customerRepository->find($_customer->id);
                return Helper::successResponseAPI(message: "Update Successful", data: [
                    'first_name' => $_customer_return->first_name,
                    'middle_name' => $_customer_return->middle_name ?? "",
                    'last_name' => $_customer_return->last_name,
                    'email' => $_customer_return->email,
                    'primary_contact_1' => $_customer_return->primary_contact_1 ?? "",
                    'secondary_contact_1' => $_customer_return->Secondary_contact_1 ?? "",
                    'primary_contact_2' => $_customer_return->primary_contact_2 ?? "",
                    'secondary_contact_2' => $_customer_return->Secondary_contact_2 ?? "",
                    'address_line1' => $_customer_return->address_line1 ?? "",
                    'address_line2' => $_customer_return->address_line2 ?? "",
                    'user_type' => $_customer_return->user_type ?? "",
                ]);
            }
            return Helper::errorResponseAPI(message: $this->error_message);
        }
        return Helper::errorResponseAPI(message: $this->notFoundMessage);
    }

    public function updateCustomerEmail($request): JsonResponse
    {
        $data = $request->all();
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            if ($_customer->email == $data['email']) {
                $_customer_update = $this->customerRepository->update($_customer, [
                    "email" => $data['email'],
                ]);
                $message = "Update Successful";
            } else {
                $_customer_update = $this->customerRepository->update($_customer, [
                    "email" => $data['email'],
                    'is_verified' => false,
                ]);
                $_customer_return = $this->customerRepository->find($_customer->id);
                event(new EmailVerificationEvent($_customer_return));
                $message = "Successful. Please verify your email address sent in your mail to access your account.";
            }
            if ($_customer_update) {
                $_customer_return = $this->customerRepository->find($_customer->id);
                return Helper::successResponseAPI(message: $message, data: [
                    'email' => $_customer_return->email,
                ]);
            }
            return Helper::errorResponseAPI(message: $this->error_message);
        }
        return Helper::errorResponseAPI(message: $this->notFoundMessage);
    }

    public function updateCustomerImage($request): JsonResponse
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            if ($request->hasFile('profile_image')) {
                $_customer_image = Helper::uploadFile(file: $request->profile_image, file_folder_name: "customer");
            } else {
                return Helper::errorResponseAPI(message: "Customer profile image not found");
            }

            $_customer_update = $this->customerRepository->update($_customer, [
                "profile_image" => $_customer_image
            ]);
            if ($_customer_update) {
                $_customer_return = $this->customerRepository->find($_customer->id);
                return Helper::successResponseAPI(message: "Update Successful", data: $_customer_return->profile_image_path);
            }
        }
        return Helper::errorResponseAPI(message: $this->error_message);
    }

    /**
     * @throws SMException
     */
    public function getCustomerDetails(): JsonResponse
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $_customer_return = $this->customerRepository->find($_customer->id);
            return Helper::successResponseAPI(message: "Success", data: [
                'first_name' => $_customer_return->first_name,
                'middle_name' => $_customer_return->middle_name ?? "",
                'last_name' => $_customer_return->last_name,
                'email' => $_customer_return->email,
                'user_type' => $_customer_return->user_type ?? "",
                'profile_image' => ($_customer_return->profile_image) ? $_customer_return->profile_image_path : '',
                'primary_contact_1' => $_customer_return->primary_contact_1 ?? "",
                'secondary_contact_1' => $_customer_return->Secondary_contact_1 ?? "",
                'primary_contact_2' => $_customer_return->primary_contact_2 ?? "",
                'secondary_contact_2' => $_customer_return->Secondary_contact_2 ?? "",
                'address_line1' => $_customer_return->address_line1 ?? "",
                'address_line2' => $_customer_return->address_line2 ?? "",

            ]);
        }
        throw new SMException("Must login");
    }

    public function resetPassword($request): JsonResponse
    {
        $validator_register = $this->checkCustomerPasswordValidation($request);
        if ($validator_register->fails()) {
            $validation_error = [];
            if ($validator_register->errors()->has('password')) {
                $validation_error['error']['password'] = $validator_register->errors()->first('password');
            }
            return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
        }
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $data = $request->all();
            $password = Helper::passwordHashing($data['password']);
            $this->customerRepository->update($_customer, [
                "password" => $password,
            ]);
            $user = Auth::guard('customerApi')->user()->token();
            $user->revoke();
            return Helper::successResponseAPI(message: "Password Changed Successful");
        }
        return Helper::errorResponseAPI(message: $this->error_message);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function checkCustomerPasswordValidation($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'password' => 'required|confirmed|string|between:8,100',
        ]);
    }

    public function getCustomerAddress(): JsonResponse|array
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $_customer_return = $this->customerRepository->find($_customer->id);
            return [
                'addresses' => [
                    [
                        "type" => "primary",
                        "city" => "",
                        "country" => "",
                        "area" => "",
                        "place" => $_customer_return->address_line1 ?? "",
                    ],
                    [
                        "type" => "secondary",
                        "city" => "",
                        "country" => "",
                        "area" => "",
                        "place" => $_customer_return->address_line2 ?? "",
                    ],
                ],
                'contacts' => [
                    [
                        "type" => "primary_1",
                        "name" => "Primary_1",
                        "number" => $_customer_return->primary_contact_1 ?? "",
                    ],
                    [
                        "type" => "primary_2",
                        "name" => "Primary_2",
                        "number" => $_customer_return->primary_contact_2 ?? "",
                    ],
                    [
                        "type" => "secondary_1",
                        "name" => "Secondary_1",
                        "number" => $_customer_return->secondary_contact_1 ?? "",
                    ],
                    [
                        "type" => "secondary_2",
                        "name" => "Secondary_2",
                        "number" => $_customer_return->secondary_contact_2 ?? "",
                    ],
                ]
            ];
        }
        return Helper::errorResponseAPI(message: $this->error_message);
    }

    public function verifyUserEmail($customerId)
    {
        $customerDetail = $this->customerRepository->find($customerId);
        if ($customerDetail) {
            return $this->customerRepository->update($customerDetail, [
                "email_verified_at" => Carbon::now(),
                "is_verified" => 1
            ]);
        }
        return Helper::errorResponseAPI(message: $this->error_message);
    }

    /**
     * @throws SMException
     */
    public function handleProviderCallback($type, $token)
    {
        $fb_id = null;
        if ($type === 'google') {

            $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . trim($token);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                throw new SMException($error_msg);
            }
            curl_close($ch); // Close the connection

            $result = json_decode($response);
            $socialLiteUser_email = $result->email;
            $first_name = $result->given_name;
            $last_name = $result->family_name;
            $social_id = $result->kid;
        } elseif ($type === 'facebook'){
            $socialLiteUser = Socialite::driver($type)->userFromToken($token);
            $socialLiteUser_email = $socialLiteUser->getEmail();
            $first_name = $socialLiteUser->name;
            $last_name = '';
            $social_id = $socialLiteUser->id;
            $fb_id = $socialLiteUser->id;
        }
        else {
            $socialLiteUser = Socialite::driver($type)->userFromToken($token);
            $socialLiteUser_email = $socialLiteUser->getEmail();
            $first_name = $socialLiteUser->name;
            $last_name = '';
            $social_id = $socialLiteUser->id;
        }
        if ($socialLiteUser_email) {
            $_customer_resp = $this->customerRepository->getCustomerByEmail($socialLiteUser_email);
        } else if($type === 'facebook'){
            $_customer_resp = $this->customerRepository->getCustomerByFBId($fb_id);
        }else{
            $_customer_resp = $this->customerRepository->getCustomerBySocialId($social_id);
        }
        if ($_customer_resp) {
            $this->customerRepository->update($_customer_resp, [
                "first_name" => $first_name,
                "middle_name" => "",
                "last_name" => $last_name,
                "fb_id" => $fb_id,
                "social_id" => $social_id,
                "social_type" => $type,
                "is_verified" => true
            ]);
            auth()->guard('customer')->login($_customer_resp, true);
        } else {
            $_customer = $this->customerRepository->save([
                "first_name" => $first_name,
                "middle_name" => "",
                "last_name" => $last_name,
                "password" => "",
                "email" => $socialLiteUser_email ?? null,
                "user_type" => 'customer',
                "social_id" => $social_id,
                "social_type" => $type,
                "fb_id" => $fb_id,
                "is_verified" => true
            ]);
            auth()->guard('customer')->login($_customer, true);
        }
        $_customer = Auth::guard('customer')->user();

        $message = "Success";
        if ($socialLiteUser_email && $_customer_resp->user_type == 'customer' && !($_customer_resp->is_verified)) {
            event(new EmailVerificationEvent($_customer_resp));
            $message = "Success. Please verify your email address sent in your mail to access your account.";
        }

        $return_response =
            [
                'token' => $_customer->createToken('AppName')->accessToken,
                'first_name' => $_customer->first_name,
                'last_name' => $_customer->last_name,
                'profile_image_path' => ($_customer->profile_image) ? $_customer->profile_image_path : '',
                'user_type' => $_customer->user_type ?? "",
                'email_status' => $_customer->is_verified ?? false,
            ];
        return Helper::successResponseAPI(message: $message, data: $return_response);

    }

    public function getEmailVerification($request): JsonResponse
    {
        $data = $request->all();
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            if($data['email'] == $_customer->email){
                $_customer = $this->customerRepository->getCustomerByEmail($data['email']);
                if ($_customer) {
                    if ($_customer->user_type == 'customer' && $_customer->is_verified) {
                        return Helper::successResponseAPI(message: 'Email Already verified' ,data: ['email_status' => $_customer->is_verified ?? false]);
                    }
                    $_customer_return = $this->customerRepository->find($_customer->id);
                    event(new EmailVerificationEvent($_customer_return));
                    $message = "Successful. Please verify your email address sent in your mail to access your account.";
                    return Helper::successResponseAPI(message: $message);
                }
            }
            return Helper::errorResponseAPI(message: "Email Not Match");
        }
        return Helper::errorResponseAPI(message: $this->notFoundMessage);
    }


}
