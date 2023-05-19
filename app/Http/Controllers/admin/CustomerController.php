<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Services\CustomerServices;
use App\Http\Services\OrderServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Throwable;

class CustomerController extends Controller
{
    private string $basePath = "admin.customer.";
    private string $error_message = "Oops! Something went wrong.";

    public function __construct()
    {
        $this->customerServices = new CustomerServices();
    }


    public function customerList(): Application|Factory|View
    {
        $_customers = $this->customerServices->customerList();
        return view($this->basePath . "customerList", compact('_customers'));
    }

    public function vendorList(): Application|Factory|View
    {
        $_customers = $this->customerServices->vendorList();
        return view($this->basePath . "customerList", compact('_customers'));
    }

    public function customerDetail($customer_id)
    {
        try {
            $_customer = $this->customerServices->getCustomer($customer_id);
            return view($this->basePath . "customerDetail", compact('_customer'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.customer.customerList');


    }

    public function customerOrderDetail(): Application|Factory|View
    {
        return view($this->basePath . "customerOrderDetail");
    }

    /**
     * @throws SMException
     */
    public function customerOrderHistory($customer_id): Application|Factory|View
    {
        $orderServices = new OrderServices();
        $_customer = $this->customerServices->getCustomer($customer_id);
        $_order = $orderServices->getOrderByCustomer($_customer->id);
        return view($this->basePath . "customerOrderHistory", compact('_customer', '_order'));
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->customerServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


}
