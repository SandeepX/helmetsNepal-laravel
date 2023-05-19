<?php

namespace App\Http\Repositories;

use App\Http\Enums\EDeliveryStatus;
use App\Models\Order\OrderProductDetail;
use App\Models\Order\ReturnOrder;
use Illuminate\Support\Facades\DB;

class ReturnOrderRepository
{

    private ReturnOrder $returnOrder;
    private OrderProductDetail $orderProductDetail;

    public function __construct()
    {
        $this->returnOrder = new ReturnOrder();
        $this->orderProductDetail = new OrderProductDetail();
    }


    public function findALl(int $paginate = 10, $filter = []): mixed
    {
        return $this->returnOrder->when(array_keys($filter, true), function ($query) use ($filter) {

            if (isset($filter['status'])) {
                $query->where('status', $filter['status'])
                    ->where(function ($q) use ($filter) {
                        if (isset($filter['search'])) {
                            $this->returnOrderSearch($q, $filter['search']);
                        }
                    });
            } else if (isset($filter['search'])) {
                $query->where(function ($q) use ($filter) {
                    $this->returnOrderSearch($q, $filter['search']);
                });
            }
        })->orderBy('id', 'desc')->paginate($paginate);
    }

    /**
     * @param $q
     * @param $search
     * @return void
     */
    private function returnOrderSearch($q, $search): void
    {
        $q->orWhere('return_order_date', 'like', '%' . $search . '%');
        $q->orWhere('customer_name', 'like', '%' . $search . '%');
        $q->orWhere('customer_phone', 'like', '%' . $search . '%');
        $q->orWhere('customer_address', 'like', '%' . $search . '%');
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->returnOrder->create($data)->fresh();
        });
    }

    /**
     * @param $returnOrder
     * @param $data
     * @return mixed
     */
    public function update($returnOrder, $data): mixed
    {
        return DB::transaction(static function () use ($returnOrder, $data) {
            return $returnOrder->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->returnOrder->findOrFail($id);
    }

    /**
     * @param ReturnOrder $returnOrder
     * @return mixed
     */
    public function delete(ReturnOrder $returnOrder): mixed
    {
        return DB::transaction(static function () use ($returnOrder) {
            return $returnOrder->delete();
        });
    }


    public function getReturnOrderList($customer_id, $per_page)
    {

        return $this->orderProductDetail->join('products', static function ($query) {
            $query->on('order_product_details.product_id', '=', 'products.id');
        })
            ->join('orders', static function ($query) {
                $query->on('order_product_details.order_id', '=', 'orders.id');
            })
            ->where('orders.customer_id', $customer_id)
            ->orWhere('orders.delivery_status', EDeliveryStatus::order_pending_returned->value)
            ->orWhere('orders.delivery_status', EDeliveryStatus::order_returned->value)
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

    public function deleteReturnOrderBYOrderProductId($order_product_detail_id)
    {
        return $this->returnOrder->where('order_product_detail_id', $order_product_detail_id)->delete();
    }


}
