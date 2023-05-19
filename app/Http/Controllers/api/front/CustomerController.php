<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Enums\EDateFormat;
use App\Http\Services\CustomerApiServices;
use App\Http\Services\WishlistServices;
use App\Models\Customer\Customer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;

class CustomerController extends Controller
{
    private string $error_message = "Oops! Something went wrong.";
    private CustomerApiServices $customerApiServices;

    public function __construct()
    {
        $this->customerApiServices = new CustomerApiServices();
        $this->wishlistServices = new WishlistServices();
    }

    public function register(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_return = $this->customerApiServices->registerCustomer($request);
            Db::commit();
            return $_return;
        } catch (Throwable $e) {
            Db::rollBack();
            return Helper::errorResponseAPI(message: $this->error_message, data: $e->getMessage());
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_return = $this->customerApiServices->loginCustomer($request);
            Db::commit();
            return $_return;
        } catch (Throwable $e) {
            Db::rollBack();
            return Helper::errorResponseAPI(message: $this->error_message, data: $e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            if (Auth::guard('customerApi')->user()) {
                $user = Auth::guard('customerApi')->user()->token();
                $user->revoke();
                return Helper::successResponseAPI(message: "Logout successfully");
            }
            return Helper::errorResponseAPI(message: 'Unable to Logout');
        } catch (Throwable $e) {
            return Helper::errorResponseAPI(message: 'Unable to Logout', data: $e);
        }
    }

    public function updateCustomerProfile(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_return = $this->customerApiServices->updateCustomerProfile($request);
            Db::commit();
            return $_return;
        } catch (Throwable $e) {
            Db::rollBack();
            return Helper::errorResponseAPI(message: $this->error_message, data: $e);
        }
    }

    public function updateCustomerEmail(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_return = $this->customerApiServices->updateCustomerEmail($request);
            Db::commit();
            return $_return;
        } catch (Throwable $e) {
            Db::rollBack();
            return Helper::errorResponseAPI(message: $this->error_message, data: $e);
        }
    }


    public function updateCustomerImage(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_return = $this->customerApiServices->updateCustomerImage($request);
            Db::commit();
            return $_return;
        } catch (Throwable $e) {
            Db::rollBack();
            return Helper::errorResponseAPI(message: $this->error_message, data: $e);
        }
    }

    public function getCustomerDetails(): JsonResponse
    {
        try {
            return $this->customerApiServices->getCustomerDetails();
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }

    }

    public function resetPassword(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_return = $this->customerApiServices->resetPassword($request);
            Db::commit();
            return $_return;
        } catch (Throwable $e) {
            Db::rollBack();
            return Helper::errorResponseAPI(message: $this->error_message, data: $e);
        }
    }

    public function getCustomerAddress(): JsonResponse
    {
        try {
            $_customerAddress = $this->customerApiServices->getCustomerAddress();
            return Helper::successResponseAPI('Success', $_customerAddress);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function saveWishlist(Request $request): JsonResponse
    {
        try {
            $this->wishlistServices->saveWishlist($request);
            $wishlist = $this->wishlistServices->getWishlist();
            return Helper::successResponseAPI('Success', $wishlist);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getWishlist(): JsonResponse
    {
        try {
            $wishlist = $this->wishlistServices->getWishlist();
            return Helper::successResponseAPI('Success', $wishlist);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function deleteWishlist(Request $request): JsonResponse
    {
        try {
            $this->wishlistServices->deleteWishlist($request);
            $wishlist = $this->wishlistServices->getWishlist();
            return Helper::successResponseAPI('Removed From wishlist', $wishlist);
        } catch (Throwable $t) {

            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    /**
     * Redirect the user to the social provider authentication page.
     *
     * @param $type
     * @return \Illuminate\Http\RedirectResponse|RedirectResponse
     */
    public function redirectToProvider($type): \Illuminate\Http\RedirectResponse|RedirectResponse
    {
        return Socialite::driver($type)->redirect();
    }

    /**
     * Obtain the user information from social provider.
     * @param $type
     * @return JsonResponse
     */
    public function handleProviderCallback(Request $request , $type): JsonResponse
    {
        try {
           return $this->customerApiServices->handleProviderCallback($type , $request->code);
        } catch (Exception $e) {
            return Helper::errorResponseAPI(message: $e->getMessage());
        }
    }

    public function getEmailVerification(Request $request)
    {
        try {
            return $this->customerApiServices->getEmailVerification($request);
        } catch (Exception $e) {
            return Helper::errorResponseAPI(message: $e->getMessage());
        }
    }

}
