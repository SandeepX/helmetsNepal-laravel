<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Http\Enums\EStatus;
use App\Http\Repositories\CustomerRepository;


class CustomerServices
{

    public function __construct()
    {
        $this->customerRepository = new CustomerRepository();
    }

    public function customerList()
    {
        return $this->customerRepository->findALl('customer');
    }
    public function vendorList()
    {
        return $this->customerRepository->findALl('vendor');
    }

    /**
     * @throws SMException
     */
    public function getCustomer($customer_id)
    {
        $_customer = $this->customerRepository->find($customer_id);
        if ($_customer) {
            return $_customer;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function changeStatus($user_id): array
    {
        $_customer = $this->customerRepository->find($user_id);
        if ($_customer) {
            $this->customerRepository->update($_customer, ['is_verified' => (($_customer->is_verified) ? 0 : 1)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException("Sorry! Customer not found");
    }
}
