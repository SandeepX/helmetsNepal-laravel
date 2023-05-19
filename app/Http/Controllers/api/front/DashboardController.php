<?php

namespace App\Http\Controllers\api\front;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->customerApiServices = new CustomerApiServices();
    }
}
