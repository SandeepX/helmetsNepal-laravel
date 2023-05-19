<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderServices;
use App\Http\Services\CouponServices;
use App\Http\Services\ReturnOrderServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    private CouponServices $couponServices;
    private OrderServices $orderServices;

    public function __construct()
    {
        $this->orderServices = new OrderServices();
        $this->returnOrderServices = new ReturnOrderServices();
        $this->couponServices = new CouponServices();
    }

    public function saveOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderServices->saveOrder($request);
            Db::commit();
            return Helper::successResponseAPI('Order Saved',data: $order);
        } catch (Throwable $t) {
            Db::rollBack();
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function checkCoupon(Request $request)
    {
        try {
            $_coupon = $this->couponServices->getByCampaignCode($request->campaign_code);
            if ($_coupon) {
                return $this->couponServices->checkCoupon($_coupon);
            }
            return Helper::errorResponseAPI("Coupon not found");
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getOrderList()
    {
        try {
            return $this->orderServices->getPendingApiOrder();
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getPastOrder(Request $request)
    {
        try {
            return $this->orderServices->getCompleteApiOrder($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function cancelOrderProduct(Request $request)
    {
        try {
            return $this->orderServices->cancelOrderProduct($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function orderPayment(Request $request)
    {
        try {
            $this->orderServices->orderPayment($request);
            return Helper::successResponseAPI('Order has been placed');
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function returnOrderProduct(Request $request)
    {
        try {
            return $this->returnOrderServices->returnOrderProduct($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getReturnOrderList(Request $request)
    {
        try {
            return $this->orderServices->getReturnOrderList($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getOderDetail(Request $request)
    {
        try {
            $order =  $this->orderServices->getOrderDetails($request);
            return Helper::successResponseAPI('Success' , $order);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getOderProductDetail(Request $request)
    {
        try {
            return $this->orderServices->getOderProductDetail($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function checkEsewaTransaction(Request $request)
    {
        try {
            return $this->orderServices->checkEsewaTransaction($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }
}
