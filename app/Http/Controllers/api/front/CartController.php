<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\CartServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CartController extends Controller
{
    public function __construct()
    {
        $this->cartServices = new CartServices();
    }

    public function addToCart(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_cart = $this->cartServices->addToCart_2($request);
             DB::commit();
            return Helper::successResponseAPI('Success', $_cart);
        } catch (Throwable $t) {
            DB::rollBack();
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getCartDetail(Request $request): JsonResponse
    {
        try {
            $_cart = $this->cartServices->getCartDetail();
            return Helper::successResponseAPI('Success', $_cart);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function deleteCartItem(Request $request)
    {
        try {
            return $this->cartServices->deleteCartItem($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function updateCartItem(Request $request): JsonResponse
    {
        try {
            $_cart = $this->cartServices->updateCart($request);
            return Helper::successResponseAPI('Success', $_cart);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }
}
