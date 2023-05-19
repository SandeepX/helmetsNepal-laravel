<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Repositories\CompanyDetailRepository;
use App\Models\Setting\CompanyDetails;


class CompanyDetailsServices
{
    public function __construct()
    {
        $this->companyDetailRepository = new CompanyDetailRepository();
    }

    /**
     * @throws SMException
     */
    public function saveCompanyDetail($request)
    {
        $data = $request->all();
        $_CompanyDetail = $this->companyDetailRepository->find();

        if ($request->hasFile('logo')) {
            if ($_CompanyDetail?->logo) {
                Helper::unlinkUploadedFile($_CompanyDetail->logo, "companyDetail");
            }
            $_logo = Helper::uploadFile(file: $request->logo, file_folder_name: "companyDetail", width: 255, height: 255);
        } else {
            $_logo = $_CompanyDetail->logo ?? '';
        }
        if ($_CompanyDetail) {
            return $this->updateCompanyDetail($_CompanyDetail, [
                'logo' => $_logo,
                'address' => $data['address'],
                'email' => $data['email'],
                'contact_no' => $data['contact_no'],
                'contact_person' => $data['contact_person'],
                'google_map_link' => $data['google_map_link'],
                'facebook_link' => $data['facebook_link'],
                'instagram_link' => $data['instagram_link'],
                'twitter_link' => $data['twitter_link'],
                'youtube_link' => $data['youtube_link'],
                'frontend_link' => $data['frontend_link']
            ]);
        }
        return $this->storeCompanyDetail([
            'logo' => $_logo,
            'address' => $data['address'],
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'contact_person' => $data['contact_person'],
            'google_map_link' => $data['google_map_link'],
            'facebook_link' => $data['facebook_link'],
            'instagram_link' => $data['instagram_link'],
            'twitter_link' => $data['twitter_link'],
            'youtube_link' => $data['youtube_link'],
            'frontend_link' => $data['frontend_link']
        ]);
    }

    public function updateCompanyDetail(CompanyDetails $_CompanyDetail, $data)
    {
        return $this->companyDetailRepository->update($_CompanyDetail, $data);
    }

    public function storeCompanyDetail($data): mixed
    {
        return $this->companyDetailRepository->save($data);
    }

    public function getCompanyDetail(): mixed
    {
        return $this->companyDetailRepository->find();
    }

    public function geCompanyDetail(): array
    {
        $_companyDetail = $this->companyDetailRepository->find();
        return [
            'logo_image_path' => $_companyDetail->logo_image_path ?? '',
            'address' => $_companyDetail->address ?? '',
            'email' => $_companyDetail->email ?? '',
            'contact_no' => $_companyDetail->contact_no ?? '',
            'contact_person' => $_companyDetail->contact_person ?? '',
            'google_map_link' => $_companyDetail->google_map_link ?? '',
            'facebook_link' => $_companyDetail->facebook_link ?? '',
            'instagram_link' => $_companyDetail->instagram_link ?? '',
            'twitter_link' => $_companyDetail->twitter_link ?? '',
            'youtube_link' => $_companyDetail->youtube_link ?? '',
        ];
    }

    public function getFELink(): string
    {
        return $this->companyDetailRepository->find()->frontend_link ?? '';

    }

}
