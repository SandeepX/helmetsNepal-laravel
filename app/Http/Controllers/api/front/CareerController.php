<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\CareerServices;
use App\Http\Services\DepartmentServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CareerController extends Controller
{
    public function __construct()
    {
        $this->careerServices = new CareerServices();
        $this->departmentServices = new DepartmentServices();
    }

    public function getCareerDepartmentList()
    {
        try {
            $_department = $this->departmentServices->getCareerDepartmentList();
            return Helper::successResponseAPI('Success', $_department);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getCareerByDepartment($department_id)
    {
        try {
            $_careers = $this->careerServices->getCareerByDepartmentList($department_id);
            return Helper::successResponseAPI('Success', $_careers);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getCareerDetail($career_id)
    {
        try {
            $_careers = $this->careerServices->getCareerDetail($career_id);
            return Helper::successResponseAPI('Success', $_careers);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveApplicationDetail(Request $request): JsonResponse
    {
        try {
            return $this->careerServices->saveApplicationDetail($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

}
