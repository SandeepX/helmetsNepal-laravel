<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\AdBlockServices;
use Throwable;

class AdBlockController extends Controller
{
    public function __construct()
    {
        $this->adBlockServices = new AdBlockServices();
    }

    public function getShopAdBlock()
    {
        try {
            $_adBlock = $this->adBlockServices->getActiveAdBlockListArray();
            return Helper::successResponseAPI('Success', $_adBlock);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getHomeAdBlock()
    {
        try {
            $_adBlock = $this->adBlockServices->getActiveAdBlockByService('homeSectionBody');
            return Helper::successResponseAPI('Success', $_adBlock);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }
}
