<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EDeliveryStatus;
use App\Http\Enums\EReturnOrderStatus;
use App\Http\Repositories\CompanySettingRepository;
use App\Http\Repositories\NotificationRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ReturnOrderRepository;
use App\Http\Resources\ReturnOrderResources;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReturnOrderServices
{
    private ReturnOrderRepository $returnOrderRepository;

    public function __construct()
    {
        $this->returnOrderRepository = new ReturnOrderRepository();
        $this->orderRepository = new OrderRepository();
        $this->companySettingRepository = new CompanySettingRepository();
    }

    /**
     * @throws SMException
     */
    public function getReturnOrderList($request)
    {
        $search = $request->all();
        return $this->returnOrderRepository->findALl(filter: $search);
    }

    /**
     * @throws SMException
     */
    public function getReturnOrder($returnOrder_id)
    {
        $_returnOrder = $this->returnOrderRepository->find($returnOrder_id);
        if ($_returnOrder) {
            return $_returnOrder;
        }
        throw new SMException("Sorry! Return Order not found");
    }

    /**
     * @throws SMException
     */
    public function returnOrderProduct($request)
    {
        $validator_register = $this->checkValidation($request);

        if ($validator_register->fails()) {
            $validation_error = [];
            if ($validator_register->errors()->has('terms_and_conditions')) {
                $validation_error['error']['terms_and_conditions'] = $validator_register->errors()->first('terms_and_conditions');
            }
            if ($validator_register->errors()->has('note')) {
                $validation_error['error']['note'] = $validator_register->errors()->first('note');
            }
            return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
        }
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
                if (($delivery_status === EDeliveryStatus::product_delivered->value) && ($different_days < $return_date)) {
                    $order_product_details = $this->orderRepository->findOrderProductDetail($order_product_id);

                    if ($order_product_details) {

                        if ($order_product_details === EDeliveryStatus::order_pending_returned->value || $order_product_details === EDeliveryStatus::order_returned->value) {
                            throw new SMException("Return Request Denied ,Sorry, this item cannot be returned. Contact Support Team");
                        }

                        $data = $request->all();
//                        $sub_total = $_order->sub_total;
//                        $order_total = $_order->total;
//                        $total = $order_product_details->total;
//                        $temp_sub_total = (float)$sub_total - (float)$total;
//                        if($temp_sub_total == 0){
//                            $this->orderRepository->updateOrder($_order, [ 'sub_total' => 0, 'total' => 0, 'status' => EDeliveryStatus::order_cancel->value]);
//                        }else{
//                            $this->orderRepository->updateOrder($_order, ['sub_total' => (float)$sub_total - (float)$total, 'total' => (float)$order_total - (float)$total]);
//                        }
                        $this->orderRepository->updateOrderProductDetail($order_product_details, ['status' => EDeliveryStatus::order_pending_returned->value,]);

                        $this->returnOrderRepository->save([
                            'order_product_detail_id' => $order_product_details->id,
                            'product_id' => $order_product_details->product_id,
                            'customer_id' => $_order->customer_id,
                            'customer_name' => $_order->customer_name,
                            'customer_phone' => $_order->customer_phone,
                            'customer_address' => $_order->customer_address,
                            'product_price' => $order_product_details->product_price,
                            'quantity' => $order_product_details->quantity,
                            'terms_and_conditions' => $data['terms_and_conditions'],
                            'note' => $data['note'],
                            'status' => EReturnOrderStatus::pending->value,
                            'return_order_date' => Carbon::now()
                        ]);
                        $notification = new NotificationRepository();
                        $notification->save([
                            'customer_id' => $_order->customer_id,
                            'details' => "Return Order Has Been Placed.",
                        ]);
                        return Helper::successResponseAPI('Order Returned ');
                    }
                    throw new SMException("Order not found");
                }
                throw new SMException("Return Request Denied ,Sorry, this item cannot be returned. Contact Support Team");
            }
            throw new SMException("Return Request Denied ,Sorry, this item cannot be returned. Contact Support Team");
        }
        throw new SMException("Must login");
    }

    private function checkValidation($request)
    {
        return Validator::make($request->all(), [
            'terms_and_conditions' => 'required',
            'note' => 'required|string',
        ]);
    }


    /**
     * @throws SMException
     */
    public function changeReturnOrderStatus($order_id, $status)
    {
        $_returnOrder = $this->returnOrderRepository->find($order_id);
        if ($_returnOrder) {

            $status = match ($status) {
                EReturnOrderStatus::pending->value => EReturnOrderStatus::pending->value,
                EReturnOrderStatus::accepted->value => EReturnOrderStatus::accepted->value,
                EReturnOrderStatus::canceled->value => EReturnOrderStatus::canceled->value,
                default => null,
            };
            if ($status) {
                $notification = new NotificationRepository();
                $notification->save([
                    'customer_id' => $_returnOrder->customer_id,
                    'details' => "Return Order Has Been " . $status,
                ]);
                $order_product_details = $this->orderRepository->findOrderProductDetail($_returnOrder->order_product_detail_id);
                if ($status == EReturnOrderStatus::accepted->value) {
                    $order_id = $_returnOrder->getOrderProductDetail->getOrder->id;
                    $_order = $this->orderRepository->find($order_id);
                    $sub_total = $_order->sub_total;
                    $order_total = $_order->total;
                    $total = $order_product_details->total;
                    $temp_sub_total = (float)$sub_total - (float)$total;
                    if ($temp_sub_total == 0) {
                        $this->orderRepository->updateOrder($_order, ['sub_total' => 0, 'total' => 0, 'status' => EDeliveryStatus::order_cancel->value]);
                    } else {
                        $this->orderRepository->updateOrder($_order, ['sub_total' => (float)$sub_total - (float)$total, 'total' => (float)$order_total - (float)$total]);
                    }
                    $this->orderRepository->updateOrderProductDetail($order_product_details, ['total' => 0, 'status' => $status]);
                } else {
                    $this->orderRepository->updateOrderProductDetail($order_product_details, ['status' => $status]);
                }
                return $this->returnOrderRepository->update($_returnOrder, ['status' => $status]);
            }
            throw new SMException("Sorry! Cannot change status");
        }
        throw new SMException("Sorry! Return Order not found");
    }

}
