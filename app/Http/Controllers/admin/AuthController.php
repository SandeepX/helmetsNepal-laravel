<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Services\UserServices;
use App\Mail\OtpVerifyMail;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * @property UserServices $userServices
 */
class AuthController extends Controller
{
    use AuthenticatesUsers;

    private string $error_message = "Oops! Something went wrong.";

    public function __construct()
    {
        $this->userServices = new UserServices();
    }


    public function login(): View|Factory|string|Application
    {
        if (Auth::check()) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return view('admin.auth.login');
    }


    public function getAuthenticate(): Redirector|Application|RedirectResponse
    {
        return redirect(route('admin.login'));
    }

    /**
     * @param $userId
     * @return Application|Factory|View
     */
    public function otpVerify()
    {
        return view('admin.auth.otp_verify');
    }


    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function authenticate(LoginRequest $request)
    {
        $return_message_array = [];
        try {
            $data = $request->all();
            DB::beginTransaction();
            $userWithUsername = $this->userServices->checkUserByUsername($data['username']);
            $userWithEmail = $this->userServices->checkUserByEmail($data['username']);

            if ($userWithUsername) {
                $user = $userWithUsername;
                $login_type = 'username';
            } elseif ($userWithEmail) {
                $user = $userWithEmail;
                $login_type = 'email';
            } else {
                return redirect()->back()->withInput()->withErrors(['username' => "Username do not match our records."]);
            }

            $check_password = Helper::checkPassword($data['password'], $user->password);
            if ($check_password) {
                $credential = [
                    $login_type => $data['username'],
                    'password' => Helper::getSaltedPassword($data['password'])
                ];

                if ($this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);
                    $this->sendLockoutResponse($request);
                }

                if (auth()->check()) {
                    return redirect()->intended(route('admin.dashboard'));
                }

                $userDetail = $login_type == 'email' ?
                    $this->userServices->checkUserByEmail($credential[$login_type]) :
                    $this->userServices->checkUserByUsername($credential[$login_type]);

                if (!$userDetail) {
                    $return_message_array = ['password' => "These credentials do not match our records."];
                }
                if (!$userDetail->two_factor_expires_at || (Carbon::now() > $userDetail->two_factor_expires_at)) {
                    $this->userServices->generateTwoFactorCodeForOtpVerification($userDetail);
                    Mail::to($userDetail->email)->send(new OtpVerifyMail($userDetail));
                }
            } else {
                $return_message_array = ['password' => "These credentials do not match our records."];
            }
            Db::commit();
            return redirect()->route('admin.otp-verify');
        } catch (Throwable $e) {
            Db::rollBack();
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->back()->withInput()->withErrors($return_message_array);
    }

    public function loginUserWithOtpVerification(Request $request)
    {
        try {
            $validated = $request->validate([
                'two_factor_code' => 'required|numeric|digits:6',
            ]);
            $userDetail = $this->userServices
                ->findUserDetailByUnexpiredOtpCode($validated['two_factor_code']);
            if (!$userDetail) {
                $this->incrementLoginAttempts($request);
                throw new Exception('Invalid/Expired OTP Code.');
            }
            Auth::login($userDetail);
            $this->clearLoginAttempts($request);
            $last_login_ipAddress = \Request::ip();
            $updateStatus = $this->userServices->updateUserLoginDetail($userDetail->id, $last_login_ipAddress);
            if($updateStatus){
                return redirect()->intended(route('admin.dashboard'));
            }
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
            return redirect()->route('admin.otp-verify')->withInput();
        }
    }


    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|void
     */
    public function logout(Request $request)
    {
        try {
            $userDetail = auth()->user();
            DB::beginTransaction();
            $resetStatus = $this->userServices->resetUserOtpDetail($userDetail);
            if ($resetStatus) {
                $this->guard()->logout();
                $request->session()->invalidate();
            }
            DB::commit();
            return redirect(route('admin.login'));
        } catch (Throwable $e) {
            DB::rollBack();
            alert()->error($this->error_message, $e->getMessage());
        }

    }
}
