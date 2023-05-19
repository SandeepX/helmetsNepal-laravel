<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyDetailRequest;
use App\Http\Services\CompanyDetailsServices;
use App\Http\Services\CompanySettingServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class CompanySettingController extends Controller
{
    private string $error_message = "Oops! Something went wrong.";
    private CompanyDetailsServices $companyDetailServices;
    private CompanySettingServices $companySettingServices;


    public function __construct()
    {
        $this->companyDetailServices = new CompanyDetailsServices();
        $this->companySettingServices = new CompanySettingServices();
    }

    public function companyDetailCreate(): Application|Factory|View
    {
        $_companyDetail = $this->companyDetailServices->getCompanyDetail();
        return view("admin.companyDetail.create", compact('_companyDetail'));
    }

    public function companyDetailSave(CompanyDetailRequest $request): RedirectResponse
    {
        try {
            $this->companyDetailServices->saveCompanyDetail($request);
            alert()->success('Success', 'Company Detail has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route("admin.companyDetail.companyDetailCreate");
    }

    public function companySettingCreate(): Application|Factory|View
    {
        $_companySetting = $this->companySettingServices->getDetails();
        return view("admin.companySetting.create", compact('_companySetting'));
    }

    public function companySettingSave(Request $request): RedirectResponse
    {
        try {
            $this->companySettingServices->saveCompanySetting($request);
            alert()->success('Success', 'Company Setting has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route("admin.companySetting.companySettingCreate");
    }
}
