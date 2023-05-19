<?php

namespace App\Http\Enums;
enum EDeliveryStatus: string
{
    case payment_pending = "Payment Pending";
    case pending = "Pending";
    case order_confirm = "Confirmed Order";
    case order_processing = "Processing Order";
    case product_dispatched = "Product Dispatched";
    case order_delivery = "Order On Delivery";
    case product_delivered = "Product Delivered";
    case order_cancel = "Order Cancel";
    case order_pending_returned = "Order Pending Returned";
    case order_returned = "Order Returned";
}
