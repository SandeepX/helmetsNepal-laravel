<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\AboutUsServices;
use App\Http\Services\CompanyDetailsServices;
use App\Http\Services\ContactUsServices;
use App\Http\Services\ShowroomServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->aboutUsServices = new AboutUsServices();
        $this->showroomServices = new ShowroomServices();
        $this->companyDetailsServices = new CompanyDetailsServices();
        $this->contactUsServices = new ContactUsServices();
    }

    public function getContactUsDetail()
    {
        try {
            $_companyDetail = $this->companyDetailsServices->geCompanyDetail();
            $showroom = $this->showroomServices->getShowInContactList();
            $contactUsDetail = $this->aboutUsServices->getContactUsSectionDetail();
            return Helper::successResponseAPI('Success', ['company_detail' => $_companyDetail, 'showroom' => $showroom, 'contactUsDetail' => $contactUsDetail]);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            return $this->contactUsServices->saveContactUs($request);
        } catch (Throwable $e) {
            Db::rollBack();
            return Helper::errorResponseAPI(message: "Error", data: $e->getMessage());
        }
    }
}
