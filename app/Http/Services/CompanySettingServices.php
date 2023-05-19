<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanySettingRepository;

class CompanySettingServices
{
    private CompanySettingRepository $companySetting;

    public function __construct()
    {
        $this->companySetting = new CompanySettingRepository();
    }

    public function getDetails()
    {
        return $this->companySetting->find();
    }

    public function saveCompanySetting($request)
    {
        $_companySetting = $this->companySetting->find();
        if ($_companySetting) {
            return $this->updateCompanySetting($_companySetting, $request);
        }
        return $this->storeCompanySetting($request);
    }

    private function updateCompanySetting($_companySetting, $request)
    {
        $data = $request->all();
        return $this->companySetting->update($_companySetting,
            [
                'return_days' => $data['return_days'],
            ]);
    }

    private function storeCompanySetting($request)
    {
        $data = $request->all();
        return $this->companySetting->save([
            'return_days' => $data['return_days'],
        ]);
    }


}
