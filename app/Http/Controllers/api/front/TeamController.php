<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\DesignationServices;
use App\Http\Services\TeamServices;
use Illuminate\Http\JsonResponse;
use Throwable;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->teamServices = new TeamServices();
        $this->designationServices = new DesignationServices();
    }

    public function getFeatureTeam(): JsonResponse
    {
        try {
            $_team = $this->teamServices->featuredTeamList();
            return Helper::successResponseAPI('Success', $_team);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getActiveTeamList(): JsonResponse
    {
        try {
            $_team = $this->teamServices->getActiveTeamList();
            return Helper::successResponseAPI('Success', $_team);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getTeamDetail($slug): JsonResponse
    {
        try {
            $_team = $this->teamServices->getTeamDetail($slug);
            return Helper::successResponseAPI('Success', $_team);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
