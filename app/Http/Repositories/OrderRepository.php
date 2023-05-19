<?php

namespace App\Http\Repositories;

use App\Http\Enums\EDeliveryStatus;
use App\Models\Order\Order;
use App\Models\Order\OrderProductDetail;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    private Order $order;
    private OrderProductDetail $orderProductDetail;

    public function __construct()
    {
        $this->order = new Order();
        $this->orderProductDetail = new OrderProductDetail();
    }

    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->order->create($data)->fresh();
        });
    }

    public function findALl(array $select = ['*'], string $orderBy = 'id', string $orderByType = 'desc', bool $is_paginate = true, int $paginate = 10): mixed
    {
        $_order = $this->order->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_order->paginate($paginate);
        }
        return $_order->get();
    }

    public function getOrderByCustomer($customer_id, int $paginate = 10)
    {
        return $this->order->where('customer_id', $customer_id)->orderBy('id', 'desc')->paginate($paginate);
    }

    public function getAllOrder(int $paginate = 10, $filter = [])
    {
        return $this->order->when(array_keys($filter, true), function ($query) use ($filter) {
            if (isset($filter['delivery_status'])) {
                $query->where('delivery_status', $filter['delivery_status'])
                    ->where(function ($q) use ($filter) {
                        if (isset($filter['search'])) {
                            $q->orWhere('order_code', 'like', '%' . $filter['search'] . '%');
                            $q->orWhere('customer_name', 'like', '%' . $filter['search'] . '%');
                        }
                    });
            } else if (isset($filter['search'])) {
                $query->where(function ($q) use ($filter) {
                    $q->orWhere('order_code', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('customer_name', 'like', '%' . $filter['search'] . '%');
                });
            }
        })->orderBy('id', 'desc')->paginate($paginate);
    }


    public function saveOrderProductDetail($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->orderProductDetail->create($data)->fresh();
        });
    }

    public function findOrderProductDetail($orderProductDetail_id)
    {
        return $this->orderProductDetail->find($orderProductDetail_id);
    }

    public function find($order_id)
    {
        return $this->order->find($order_id);
    }

    public function findByOrderCodeCustomerID($order_code, $customer_id)
    {
        return $this->order->where('order_code', $order_code)->where('customer_id', $customer_id)->first();
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function deleteOrder(Order $order): mixed
    {
        return DB::transaction(static function () use ($order) {
            return $order->delete();
        });
    }

    /**
     * @param OrderProductDetail $orderProductDetail
     * @return mixed
     */
    public function deleteOrderProductDetail(OrderProductDetail $orderProductDetail): mixed
    {
        return DB::transaction(static function () use ($orderProductDetail) {
            return $orderProductDetail->delete();
        });
    }

    /**
     * @param Order $order
     * @param $data
     * @return mixed
     */
    public function updateOrder(Order $order, $data): mixed
    {
        return DB::transaction(static function () use ($order, $data) {
            return $order->update($data);
        });
    }
    /**
     * @param OrderProductDetail $orderProductDetail
     * @param $data
     * @return mixed
     */
    public function updateOrderProductDetail(OrderProductDetail $orderProductDetail, $data): mixed
    {
        return DB::transaction(static function () use ($orderProductDetail, $data) {
            return $orderProductDetail->update($data);
        });
    }

    public function getOrderProductDetail($order_id)
    {
        return $this->orderProductDetail->where('order_id', $order_id)->get();
    }

    public function getOrderProductDetailList($order_id)
    {
        return $this->orderProductDetail
            ->join('products', static function ($query) {
                $query->on('order_product_details.product_id', '=', 'products.id');

                $query->leftJoin('brands', static function ($q) {
                    $q->on('products.brand_id', '=', 'brands.id');
                });
                $query->join('categories', static function ($q) {
                    $q->on('products.category_id', '=', 'categories.id');
                });
            })
            ->select([
                DB::raw('products.title as product_title'),
                DB::raw('products.id as product_id'),
                DB::raw('products.product_code as product_code'),
                DB::raw('products.cover_image as cover_image'),
                DB::raw('products.slug as product_slug'),

                DB::raw('products.product_price as product_price'),

                DB::raw('order_product_details.quantity as quantity'),
                DB::raw('order_product_details.product_price as order_product_price'),
                DB::raw('order_product_details.total as total'),
                DB::raw('order_product_details.status as status'),

                DB::raw('order_product_details.product_color as product_color'),
                DB::raw('order_product_details.product_size as product_size'),

                DB::raw('order_product_details.product_custom_attributes as product_custom_attributes'),
                DB::raw('order_product_details.product_custom_attribute_value as product_custom_attribute_value'),

                DB::raw('brands.id as brand_id'),
                DB::raw('brands.title as brand_title'),

                DB::raw('categories.id as category_id'),
                DB::raw('categories.name as category_name'),
            ])
            ->where('order_product_details.order_id', $order_id)->get();
    }


    public function getIncompleteOrderByCustomer($customer_id)
    {
        return $this->orderProductDetail->join('products', static function ($query) {
            $query->on('order_product_details.product_id', '=', 'products.id');
        })
            ->join('orders', static function ($query) {
                $query->on('order_product_details.order_id', '=', 'orders.id');
            })
            ->where('orders.customer_id', $customer_id)
            ->Where(function ($query) {
                $query->orWhere('orders.delivery_status', '!=', EDeliveryStatus::product_delivered->value);
                $query->orWhere('orders.delivery_status', '!=', EDeliveryStatus::order_cancel->value);
                $query->orWhere('orders.delivery_status', '!=', EDeliveryStatus::order_pending_returned->value);
                $query->orWhere('orders.delivery_status', '!=', EDeliveryStatus::order_returned->value);
            })
            ->select([
                DB::raw('order_product_details.id as order_product_id'),
                DB::raw('order_product_details.order_id as order_id'),
                DB::raw('order_product_details.quantity as quantity'),
                DB::raw('order_product_details.total as total'),
                DB::raw('orders.delivery_status as delivery_status'),
                DB::raw('order_product_details.status as status'),
                DB::raw('orders.order_date as order_date'),
                DB::raw('products.title as title'),
                DB::raw('products.id as product_id'),
                DB::raw('products.cover_image as cover_image'),
            ])
            ->orderBy('order_product_details.id', 'desc')
            ->get();
    }

    public function getCompleteOrderByCustomer($customer_id, $per_page)
    {

        return $this->orderProductDetail->join('products', static function ($query) {
            $query->on('order_product_details.product_id', '=', 'products.id');
        })
            ->join('orders', static function ($query) {
                $query->on('order_product_details.order_id', '=', 'orders.id');
            })
            ->where('orders.customer_id', $customer_id)
            ->where('orders.delivery_status', EDeliveryStatus::product_delivered->value)
            ->select([
                DB::raw('order_product_details.id as order_product_id'),
                DB::raw('order_product_details.order_id as order_id'),
                DB::raw('order_product_details.quantity as quantity'),
                DB::raw('order_product_details.total as total'),
                DB::raw('orders.delivery_status as delivery_status'),
                DB::raw('order_product_details.status as status'),
                DB::raw('orders.order_date as order_date'),
                DB::raw('products.title as title'),
                DB::raw('products.id as product_id'),
                DB::raw('products.cover_image as cover_image'),
            ])
            ->orderBy('order_product_details.id', 'desc')
            ->paginate($per_page);
    }


}
