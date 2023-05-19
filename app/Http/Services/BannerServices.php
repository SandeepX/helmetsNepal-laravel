<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\BannerRepository;
use App\Http\Resources\BannerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class BannerServices
{
    private string $notFoundMessage = "Sorry! Banner not found";


    public function __construct()
    {
        $this->bannerRepository = new BannerRepository();
    }

    public function getList()
    {
        return $this->bannerRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveBanner($request)
    {

        $data = $request->all();
        if ($request->hasFile('banner_image')) {
            $_banner_image = Helper::uploadFile(file: $request->banner_image, file_folder_name: "banner", width: 1725, height: 645);
        } else {
            throw new SMException("Banner image not found");
        }
        return $this->bannerRepository->save([
            'title' => $data['title'] ?? "",
            'sub_title' => $data['sub_title'] ?? "",
            'image' => $_banner_image,
            'description' => $data['description'] ?? "",
            'link' => $data['link'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getBanner($banner_id)
    {
        $_banner = $this->bannerRepository->find($banner_id);
        if ($_banner) {
            return $_banner;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateBanner($banner_id, $request)
    {
        $data = $request->all();
        $_banner = $this->bannerRepository->find($banner_id);
        if ($_banner) {
            $_banner_image = $_banner->image;
            if ($request->hasFile('banner_image')) {
                Helper::unlinkUploadedFile($_banner->image, "banner");
                $_banner_image = Helper::uploadFile(file: $request->banner_image, file_folder_name: "banner", width: 1725, height: 645);
            }
            return $this->bannerRepository->update($_banner, [
                'title' => $data['title'] ?? "",
                'sub_title' => $data['sub_title'] ?? "",
                'image' => $_banner_image,
                'description' => $data['description'] ?? "",
                'link' => $data['link'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteBanner($banner_id)
    {
        $_banner = $this->bannerRepository->find($banner_id);
        if ($_banner) {
            Helper::unlinkUploadedFile($_banner->image, "banner");
            return $this->bannerRepository->delete($_banner);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($banner_id): array
    {
        $_banner = $this->bannerRepository->find($banner_id);
        if ($_banner) {
            $this->bannerRepository->update($_banner, ['status' => (($_banner->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeFeatureStatus($banner_id): array
    {
        $_banner = $this->bannerRepository->find($banner_id);
        if ($_banner) {

            $_banner_lists = $this->bannerRepository->findALl();

            foreach ($_banner_lists as $value)
            {
                $this->bannerRepository->update($value, ['feature_status' => 0]);
            }
            $this->bannerRepository->update($_banner, ['feature_status' => 1]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getActiveBannerListArray(): AnonymousResourceCollection
    {
        $_banner = $this->bannerRepository->getActiveList();
        return BannerResource::collection($_banner);
    }


}
