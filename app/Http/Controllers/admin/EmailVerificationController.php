<?php

namespace App\Http\Controllers\admin;

use App\Events\EmailVerificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Services\CustomerApiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class EmailVerificationController extends Controller
{
    private CustomerApiServices $customerApiServices;

    public function __construct()
    {
        $this->customerApiServices = new CustomerApiServices();
    }

    public function verifyCustomerEmailAddress(Request $request)
    {
        try {
            if (! $request->hasValidSignature()) {
                $this->resendEmailVerificationLink($request->id);
                return response("This verification link is expired. New Verification link is sent in your mail for email verification.", 403);
            }
            $redirectUrl = config('app.site_url').'/login';
            $this->customerApiServices->verifyUserEmail($request->id);
            return Redirect::to($redirectUrl);
        } catch (Throwable $t) {
            return response($t->getMessage(), 400);
        }
    }

    public function resendEmailVerificationLink($customerId)
    {
        $customerDetail = $this->customerApiServices->getCustomerDetailById($customerId);
        event(new EmailVerificationEvent($customerDetail));
    }
}
