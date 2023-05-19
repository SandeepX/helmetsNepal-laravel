<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EDateFormat;
use App\Http\Enums\EDeliveryStatus;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\CompanySettingRepository;
use App\Http\Repositories\NotificationRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\ReturnOrderRepository;
use App\Http\Resources\OrderListResource;
use App\Models\Order\Coupon;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class OrderServices
{
    protected CartRepository $cartRepository;
    private CouponServices $couponServices;
    private DeliveryChargeServices $deliveryChargeServices;
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->couponServices = new CouponServices();
        $this->deliveryChargeServices = new DeliveryChargeServices();
        $this->orderRepository = new OrderRepository();
        $this->cartRepository = new CartRepository();
        $this->productRepository = new ProductRepository();
        $this->returnOrderRepository = new ReturnOrderRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * @throws SMException
     */
    public function saveOrder($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            if ($_customer->user_type == 'customer' && !($_customer->is_verified)) {
                throw new SMException("Please verify your email address sent in your mail to access your account.");
            }
            $data = $request->all();
            $_customer_id = $_customer->id;
            $campaign_code = $data['campaign_code'] ?? "";
            $_orderProducts = $data['order_product'] ?? "";
            $deliveryCharge_id = null;
            $delivery_charge_amount = 0;
            if (isset($data['deliveryCharge_id'])) {
                $deliveryCharge_id = $data['deliveryCharge_id'];
                $deliveryCharge = $this->deliveryChargeServices->getDeliveryCharge($deliveryCharge_id);
                $delivery_charge_amount = $deliveryCharge->delivery_charge_amount ?? 0;
            }
            $_cart = $this->cartRepository->findByCustomerId($_customer_id);
            $_order = $this->orderRepository->save([
                'order_code' => Helper::generateOrderNumber(),
                'order_date' => Helper::smTodayInYmdHis(),
                'customer_id' => $_customer_id,
                'customer_name' => $_customer->full_name,
                'customer_phone' => $data['customer_phone'],
                'customer_address' => $data['customer_address'] ?? "-",
                'delivery_status' => EDeliveryStatus::payment_pending,
            ]);
            $_coupon = $this->couponServices->getByCampaignCode($campaign_code);
            $coupon_for = null;
            $coupon_apply_on = null;
            $product_amount_for_discount = 0;
            if ($_coupon) {
                $coupon_for = $_coupon->coupon_for;
                $coupon_apply_on = $_coupon->coupon_apply_on;
            }
            $product_price = 0;
            foreach ($_orderProducts as $orderProduct) {
                $_product = $this->productRepository->find($orderProduct['product_id']);


                $total = ((float)$orderProduct['quantity'] * (float)$_product->final_product_price);
                if ($coupon_for == "category") {
                    if ($_product->category_id == $coupon_apply_on) {
                        $product_amount_for_discount += $total;
                    } else {
                        $cat = $this->categoryRepository->find($coupon_apply_on);
                        $child_ids = $cat->getChildCategory()->pluck('id')->toArray();
                        if (in_array($_product->category_id, $child_ids)) {
                            $product_amount_for_discount += $total;
                        }
                    }
                }

                if ($coupon_for == "brand" && $_product->brand_id == $coupon_apply_on) {
                    $product_amount_for_discount += $total;
                }

                if ($coupon_for == "product" && $_product->id == $coupon_apply_on) {
                    $product_amount_for_discount += $total;
                }
                $this->orderRepository->saveOrderProductDetail([
                    'order_id' => $_order->id,
                    'product_id' => $orderProduct['product_id'],
                    'product_code' => $_product->product_code,
                    'product_price' => $_product->final_product_price,
                    'quantity' => $orderProduct['quantity'],
                    'total' => $total,
                    'product_custom_attributes' => $orderProduct['product_custom_attributes'] ?? null,
                    'product_custom_attribute_value' => $orderProduct['product_custom_attribute_value'] ?? null,
                    'product_color_id' => $orderProduct['product_color_id'] ?? null,
                    'product_size_id' => $orderProduct['product_size_id'] ?? null,
                    'product_color' => $orderProduct['product_color'] ?? null,
                    'product_size' => $orderProduct['product_size'] ?? null,
                    'status' => EDeliveryStatus::payment_pending
                ]);
                $product_price += $total;
                if ($_cart) {
                    $_cartProduct = $this->cartRepository->findCartProductWithCartID(cart_id: $_cart->id, product_id: $_product->id);
                    $this->cartRepository->deleteCartProduct($_cartProduct);
                }
            }
            if ($_cart) {
                $this->cartRepository->delete($_cart);
            }
            $_order_resp = $this->orderRepository->find($_order->id);
            $final_discount_amount = 0;
            $final_amount = $product_price;
            $coupon_code = "";

            if ($_coupon) {
                $starting_date = strtotime($_coupon->starting_date);
                $expiry_date = strtotime($_coupon->expiry_date);

                if (strtotime(now()) < $starting_date) {
                    throw new SMException("Invalid Coupon");
                }
                if ($expiry_date < strtotime(now())) {
                    throw new SMException("Coupon expired");
                }

                $coupon_type = $_coupon->coupon_type;
                $coupon_value = $_coupon->coupon_value;
                $min_amount = $_coupon->min_amount;
                $max_amount = $_coupon->max_amount;

                $coupon_for = $_coupon->coupon_for;

                if ($product_amount_for_discount !== 0) {
                    if ($min_amount > $product_price) {
                        throw new SMException("Purchase Amount must be greater than " . $min_amount);
                    }
                    if ($coupon_type == 'percentage') {
                        $discount_amount = round((($coupon_value / 100) * $product_price), 2);
                        if ($discount_amount < $max_amount) {
                            $final_amount = $product_price - $discount_amount;
                            $final_discount_amount = $discount_amount;
                        } else {
                            $final_amount = $product_price - $max_amount;
                            $final_discount_amount = $max_amount;
                        }
                    } else {
                        $final_amount = $product_price - $coupon_value;
                        $final_discount_amount = $coupon_value;
                    }
                    $coupon_code = $_coupon->campaign_code;
                } elseif ($coupon_for == "all") {
                    if ($min_amount > $product_price) {
                        throw new SMException("Purchase Amount must be greater than " . $min_amount);
                    }
                    if ($coupon_type == 'percentage') {
                        $discount_amount = round((($coupon_value / 100) * $product_price), 2);
                        if ($discount_amount < $max_amount) {
                            $final_amount = $product_price - $discount_amount;
                            $final_discount_amount = $discount_amount;
                        } else {
                            $final_amount = $product_price - $max_amount;
                            $final_discount_amount = $max_amount;
                        }
                    } else {
                        $final_amount = $product_price - $coupon_value;
                        $final_discount_amount = $coupon_value;
                    }
                    $coupon_code = $_coupon->campaign_code;
                }
            }

            $final_total_amount = $final_amount + $delivery_charge_amount;
            $this->orderRepository->updateOrder($_order_resp,
                [
                    'coupon_value' => $final_discount_amount,
                    'coupon_code' => $coupon_code,
                    'coupon_id' => $_coupon->id ?? null,
                    'deliveryCharge_id' => $deliveryCharge_id,
                    'deliveryCharge_amount' => round($delivery_charge_amount, 2),
                    'sub_total' => round($product_price, 2),
                    'discount' => round($final_discount_amount, 2),
                    'total' => round($final_total_amount, 2)
                ]);
            $notification = new NotificationRepository();
            $notification->save([
                'customer_id' => $_customer_id,
                'details' => "Order Has Been Placed . Payment is pending",
            ]);
            return ['order_code' => $_order_resp->order_code, 'amount' => $final_total_amount];
        }
        throw new SMException("Must login");
    }

    public function getOrderByCustomer($customer_id)
    {
        return $this->orderRepository->getOrderByCustomer($customer_id);
    }

    public function getAllOrderList($request)
    {
        $search = $request->all();
        return $this->orderRepository->getAllOrder(filter: $search);
    }

    /**
     * @throws SMException
     */
    public function getOrder($order_id)
    {
        $_order = $this->orderRepository->find($order_id);
        if ($_order) {
            return $_order;
        }
        throw new SMException("Sorry! Order not found");
    }

    /**
     * @throws SMException
     */
    public function changeOrderStatus($order_id, $status)
    {
        $_order = $this->orderRepository->find($order_id);
        if ($_order) {

            $delivery_status = match ($status) {
                EDeliveryStatus::order_cancel->value => EDeliveryStatus::order_cancel->value,
                EDeliveryStatus::pending->value => EDeliveryStatus::pending->value,
                EDeliveryStatus::order_confirm->value => EDeliveryStatus::order_confirm->value,
                EDeliveryStatus::order_processing->value => EDeliveryStatus::order_processing->value,
                EDeliveryStatus::product_dispatched->value => EDeliveryStatus::product_dispatched->value,
                EDeliveryStatus::order_delivery->value => EDeliveryStatus::order_delivery->value,
                EDeliveryStatus::product_delivered->value => EDeliveryStatus::product_delivered->value,
                default => null,
            };
            if ($delivery_status) {
                $_orderProductDetails = $_order->getOrderProductDetail;
                foreach ($_orderProductDetails as $orderProductDetail) {
                    if ($orderProductDetail->status !== EDeliveryStatus::order_cancel->value && $orderProductDetail->status !== EDeliveryStatus::order_returned->value && $orderProductDetail->status !== EDeliveryStatus::order_pending_returned->value) {
                        $this->orderRepository->updateOrderProductDetail($orderProductDetail, ['status' => $delivery_status]);
                    }
                }
                $notification = new NotificationRepository();
                $notification->save([
                    'customer_id' => $_order->customer_id,
                    'details' => "Order Has Been " . $delivery_status,
                ]);
                return $this->orderRepository->updateOrder($_order, ['delivery_status' => $delivery_status]);
            }
            throw new SMException("Sorry! Cannot change status");
        }
        throw new SMException("Sorry! Order not found");
    }

    /**
     * @throws SMException
     */
    public function orderPayment($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $order_code = $request->order_code;
            $_order = $this->orderRepository->findByOrderCodeCustomerID(order_code: $order_code, customer_id: $_customer->id);
            if ($_order) {
                $delivery_status = EDeliveryStatus::pending->value;
                $_orderProductDetails = $_order->getOrderProductDetail;
                foreach ($_orderProductDetails as $orderProductDetail) {
                    $this->orderRepository->updateOrderProductDetail($orderProductDetail, ['status' => $delivery_status]);
                }
                $notification = new NotificationRepository();
                $notification->save([
                    'customer_id' => $_order->customer_id,
                    'details' => "Order Has Been Placed",
                ]);
                return $this->orderRepository->updateOrder($_order, ['delivery_status' => $delivery_status]);
            }
            throw new SMException("Sorry! Order not found");
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function getPendingApiOrder()
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            if ($_customer->user_type == 'customer' && !($_customer->is_verified)) {
                throw new SMException("Please verify your email address sent in your mail to access your account.");
            }
            $customer_id = $_customer->id;
            $_orders = $this->orderRepository->getIncompleteOrderByCustomer($customer_id);
            return Helper::successResponseAPI('Success', OrderListResource::collection($_orders));
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function getCompleteApiOrder($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $customer_id = $_customer->id;
            $per_page = 10;
            if ($request->has('per_page')) {
                $per_page = $request->per_page;
            }
            $_orders = $this->orderRepository->getCompleteOrderByCustomer($customer_id, $per_page);
            $page_details = $_orders->toArray();
            unset($page_details['data']);
            return Helper::successResponseAPI('Success', ['page_details' => $page_details, 'order_list' => OrderListResource::collection($_orders)]);
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function cancelOrderProduct($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        $order_product_id = $request->order_product_id;
        $order_id = $request->order_id;

        if (is_null($order_product_id) || is_null($order_id)) {
            return Helper::errorResponseAPI('Something went wrong');
        }

        if ($_customer) {
            if ($_customer->user_type == 'customer' && !($_customer->is_verified)) {
                throw new SMException("Please verify your email address sent in your mail to access your account.");
            }
            $_order = $this->orderRepository->find($order_id);

            if ($_order) {
                if ($_order->delivery_status == EDeliveryStatus::pending->value) {
                    $_orderProduct = $_order->getOrderProductDetail()->count();
                    if ($_orderProduct == 0) {
                        throw new SMException("Order not found");
                    }

                    $sub_total = $_order->sub_total;
                    $order_total = $_order->total;
                    $_order_product_details = $this->orderRepository->findOrderProductDetail($order_product_id);
                    if ($_order_product_details) {
                        $total = $_order_product_details->total;
                        $this->orderRepository->updateOrder($_order, ['sub_total' => (float)$sub_total - (float)$total, 'total' => (float)$order_total - (float)$total,]);
                        $this->orderRepository->updateOrderProductDetail($_order_product_details, ['total' => 0, 'status' => EDeliveryStatus::order_cancel->value,]);
                        if ($_orderProduct == 1) {
                            $this->orderRepository->updateOrder($_order, ['status' => EDeliveryStatus::order_cancel->value,]);
                            $notification = new NotificationRepository();
                            $notification->save([
                                'customer_id' => $_order->customer_id,
                                'details' => "Order Has Been Canceled",
                            ]);
                        }
                        return Helper::successResponseAPI('Order Canceled ');
                    }
                    throw new SMException("Order not found");
                }
                throw new SMException("Cannot cancel this Order.");
            }
            throw new SMException("Order not found");
        }
        throw new SMException("Must login");
    }

    public function getOrderProductDetail($order_id)
    {
        return $this->orderRepository->getOrderProductDetailList($order_id);
    }


    /**
     * @throws SMException
     */
    public function getOrderDetails($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            if ($_customer->user_type == 'customer' && !($_customer->is_verified)) {
                throw new SMException("Please verify your email address sent in your mail to access your account.");
            }
            $order_code = $request->order_code;

            $_order = $this->orderRepository->findByOrderCodeCustomerID(order_code: $order_code, customer_id: $_customer->id);

            if ($_order) {
                $_order_product_details = $_order->getOrderProductDetail;
                $_orderProductDetail = [];
                foreach ($_order_product_details as $_order_product_detail) {
                    $_orderProductDetail[] = [
                        'id' => $_order_product_detail->id,
                        'name' => $_order_product_detail->getProduct->title,
                        'qty' => $_order_product_detail->quantity,
                        'product_price' => $_order_product_detail->product_price,
                        'amount' => $_order_product_detail->total,
                        'productSize' => $_order_product_detail->product_size,
                        'productColor' => $_order_product_detail->product_color
                    ];
                }
                return [
                    'deliveryType' => $_order->getDeliveryCharge?->title,
                    'shippingCharge' => $_order->deliveryCharge_amount ?? 0,
                    'cartItemPrice' => $_order->sub_total,
                    'couponApplied' => $_order->coupon_code,
                    'discount' => $_order->discount,
                    'netTotal' => $_order->total,
                    'orderId' => $_order->order_code,
                    'sub_total' => $_order->sub_total,
                    'item' => $_orderProductDetail
                ];
            }
            throw new SMException("Order not found");
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function getOderProductDetail($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $order_product_id = $request->order_product_id;
            $order_id = $request->order_id;

            $_order = $this->orderRepository->find($order_id);

            if ($_order) {
                $_companySetting = new CompanySettingRepository();
                $return_date = ($_companySetting->getReturnDays->return_days ?? 7);
                $start_date = Carbon::create($_order->order_date);
                $end_date = Carbon::now();
                $different_days = $start_date->diffInDays($end_date);
                $delivery_status = $_order->delivery_status;

                if (($delivery_status == EDeliveryStatus::product_delivered->value) && ($different_days < $return_date)) {
                    $_order_product_details = $this->orderRepository->findOrderProductDetail($order_product_id);
                    if ($_order_product_details) {
                        return Helper::successResponseAPI('Success', [
                            'id' => $_order_product_details->order_id,
                            'order_id' => $_order_product_details->order_id,
                            'amount' => $_order_product_details->total,
                            'addressLineOne' => $_order_product_details->getOrder->customer_address,
                            'addressLineTwo' => $_order_product_details->getOrder->customer_address,
                            'phone' => $_order_product_details->getOrder->customer_phone,
                            'orderStatus' => $_order_product_details->getOrder->delivery_status,
                            'item' => [
                                'order_product_id' => $_order_product_details->id,
                                'product_id' => $_order_product_details->product_id,
                                'id' => $_order_product_details->id,
                                'name' => $_order_product_details->getProduct->title,
                                'qty' => $_order_product_details->quantity,
                                'amount' => $_order_product_details->total,
                                'date' => date(EDateFormat::Ymd->value, strtotime($_order_product_details->getOrder->order_date)),
                                'image' => $_order_product_details->getProduct->product_cover_image_path
                            ]
                        ]);
                    }
                }
                throw new SMException("Return Request Denied ,Sorry, this item cannot be returned. Contact Support Team");
            }
            throw new SMException("Order not found");
        }
        throw new SMException("Must login");
    }


    /**
     * @throws SMException
     */
    public function getReturnOrderList($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $customer_id = $_customer->id;
            $per_page = 10;
            if ($request->has('per_page')) {
                $per_page = $request->per_page;
            }
            $_orders = $this->returnOrderRepository->getReturnOrderList($customer_id, $per_page);
            $page_details = $_orders->toArray();
            unset($page_details['data']);
            return Helper::successResponseAPI('Success', ['page_details' => $page_details, 'order_list' => OrderListResource::collection($_orders)]);
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function checkEsewaTransaction($request): JsonResponse
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $order_code = $request->oid;
            $order_amount = $request->amt;
            $reference_id = $request->refId;
            $order = $this->orderRepository->findByOrderCodeCustomerID(order_code: $order_code, customer_id: $_customer->id);
            if ($order) {
                $url = "https://esewa.com.np/epay/transrec";
//                $url = "https://uat.esewa.com.np/epay/transrec";

                $orderAmount = $order->total;
                if ($orderAmount == $order_amount) {
                    $data = [
                        'amt' => $order_amount,
                        'rid' => $reference_id,
                        'pid' => $order_code,
                        'scd' => 'ES-1909040034'
//                        'scd' => 'EPAYTEST'
                    ];

                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);
                    curl_close($curl);

                    if (strpos($response, "Success")) {
                        $delivery_status = EDeliveryStatus::order_confirm->value;
                        $_orderProductDetails = $order->getOrderProductDetail;
                        foreach ($_orderProductDetails as $orderProductDetail) {
                            $this->orderRepository->updateOrderProductDetail($orderProductDetail, ['status' => $delivery_status]);
                        }
                        $notification = new NotificationRepository();
                        $notification->save([
                            'customer_id' => $order->customer_id,
                            'details' => "Order Has Been Placed and Payment Successful",
                        ]);
                        $this->orderRepository->updateOrder($order,
                            [
                                'delivery_status' => $delivery_status,
                                'payment_method_name' => "esewa",
                                'payment_transaction_id' => $reference_id
                            ]
                        );
                        return Helper::successResponseAPI('Order Has Been Placed and Payment Successful');
                    }
                    throw new SMException("Something went wrong! Payment un-successful");
                }
                throw new SMException("Something went wrong! Total amount is not valid");
            }
            throw new SMException("Order Not found");
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function deleteOrder($order_id)
    {
        $_order = $this->orderRepository->find($order_id);
        if ($_order) {
            $order_id = $_order->id;
            $orderProductDetails = $this->orderRepository->getOrderProductDetail($order_id);
            $returnOrder = new ReturnOrderRepository();
            foreach ($orderProductDetails as $orderProductDetail) {
                $order_product_detail_id = $orderProductDetail->id;
                $returnOrder->deleteReturnOrderBYOrderProductId($order_product_detail_id);
                $this->orderRepository->deleteOrderProductDetail($orderProductDetail);
            }
            return $this->orderRepository->deleteOrder($_order);
        }
        throw new SMException("Sorry! Order not found");
    }


}
