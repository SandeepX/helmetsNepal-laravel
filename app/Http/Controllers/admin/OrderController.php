<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Enums\EDeliveryStatus;
use App\Http\Enums\EReturnOrderStatus;
use App\Http\Services\CustomerServices;
use App\Http\Services\OrderServices;
use App\Http\Services\ReturnOrderServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller
{
    private string $basePath = "admin.order.";
    private string $error_message = "Oops! Something went wrong.";

    public function __construct()
    {
        $this->orderServices = new OrderServices();
        $this->returnOrderServices = new ReturnOrderServices();
        $this->customerServices = new CustomerServices();
    }


    public function orderList(Request $request): Application|Factory|View
    {
        $_order = $this->orderServices->getAllOrderList($request);
        $_delivery_status = [
            EDeliveryStatus::order_cancel->value => EDeliveryStatus::order_cancel->value,
            EDeliveryStatus::pending->value => EDeliveryStatus::pending->value,
            EDeliveryStatus::order_confirm->value => EDeliveryStatus::order_confirm->value,
            EDeliveryStatus::order_processing->value => EDeliveryStatus::order_processing->value,
            EDeliveryStatus::product_dispatched->value => EDeliveryStatus::product_dispatched->value,
            EDeliveryStatus::order_delivery->value => EDeliveryStatus::order_delivery->value,
            EDeliveryStatus::product_delivered->value => EDeliveryStatus::product_delivered->value];
        return view($this->basePath . "orderList", compact('_order', '_delivery_status'));
    }

    public function orderDetail($order_id)
    {
        try {
            $_order = $this->orderServices->getOrder($order_id);
            $_orderProductDetails = $this->orderServices->getOrderProductDetail($_order->id);
            $_customer = $this->customerServices->getCustomer($_order->customer_id);
            $_delivery_status = [
                EDeliveryStatus::order_cancel->value => EDeliveryStatus::order_cancel->value,
                EDeliveryStatus::pending->value => EDeliveryStatus::pending->value,
                EDeliveryStatus::order_confirm->value => EDeliveryStatus::order_confirm->value,
                EDeliveryStatus::order_processing->value => EDeliveryStatus::order_processing->value,
                EDeliveryStatus::product_dispatched->value => EDeliveryStatus::product_dispatched->value,
                EDeliveryStatus::order_delivery->value => EDeliveryStatus::order_delivery->value,
                EDeliveryStatus::product_delivered->value => EDeliveryStatus::product_delivered->value];

            return view($this->basePath . "orderDetail", compact('_order', '_orderProductDetails', '_customer', '_delivery_status'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.order.orderList');
    }

    public function orderInvoice(): Application|Factory|View
    {
        return view($this->basePath . "orderInvoice");
    }

    public function changeOrderStatus(int $id, Request $request)
    {
        try {
            $this->orderServices->changeOrderStatus($id, $request->delivery_status);
            alert()->success('Success', 'Update successfully');
            return redirect()->route('admin.order.orderDetail', ['order_id' => $id]);
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->back();
    }



    /**
     * @throws SMException
     */
    public function returnOrderList(Request $request): View|Factory|RedirectResponse|Application
    {

        try {
            $_order = $this->returnOrderServices->getReturnOrderList($request);
            $_status = [
                EReturnOrderStatus::pending->value => EReturnOrderStatus::pending->value,
                EReturnOrderStatus::accepted->value => EReturnOrderStatus::accepted->value,
                EReturnOrderStatus::canceled->value => EReturnOrderStatus::canceled->value,
                ];
            return view($this->basePath . "returnOrderList", compact('_order', '_status'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.order.orderList');
    }

    /**
     * @throws SMException
     */
    public function returnOrderDetail($return_order_id): View|Factory|RedirectResponse|Application
    {

        try {
            $_returnOrder = $this->returnOrderServices->getReturnOrder($return_order_id);
            $_status = [
                EReturnOrderStatus::pending->value => EReturnOrderStatus::pending->value,
                EReturnOrderStatus::accepted->value => EReturnOrderStatus::accepted->value,
                EReturnOrderStatus::canceled->value => EReturnOrderStatus::canceled->value,
            ];
            $_customer = $this->customerServices->getCustomer($_returnOrder->customer_id);
            return view($this->basePath . "returnOrderDetail", compact('_returnOrder', '_status' , '_customer'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.order.orderList');
    }

    public function changeReturnOrderStatus(int $return_order_id, Request $request)
    {
        try {
            $this->returnOrderServices->changeReturnOrderStatus($return_order_id, $request->status);
            alert()->success('Success', 'Update successfully');
            return redirect()->route('admin.order.returnOrderDetail', ['return_order_id' => $return_order_id]);
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->back();
    }

    public function deleteOrder(int $id)
    {
        try {
            $this->orderServices->deleteOrder($id);
            alert()->success('Success', 'Deleted successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.order.orderList');
    }




}
