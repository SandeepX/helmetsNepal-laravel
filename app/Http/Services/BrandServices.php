<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\BrandRepository;
use App\Http\Resources\BrandResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class BrandServices
{
    private string $notFoundMessage = "Sorry! Brand not found";


    public function __construct()
    {
        $this->brandRepository = new BrandRepository();
    }

    public function getList()
    {
        return $this->brandRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveBrand($request)
    {

        $data = $request->all();
        if ($request->hasFile('brand_image')) {
            $_brand_image = Helper::uploadFile(file: $request->brand_image, file_folder_name: "brand", width: 134, height: 134);
        } else {
            throw new SMException("Brand image not found");
        }
        return $this->brandRepository->save([
            'title' => $data['title'],
            'image' => $_brand_image,
            'description' => $data['description'] ?? "",
            'link' => $data['link'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getBrand($brand_id)
    {
        $_brand = $this->brandRepository->find($brand_id);
        if ($_brand) {
            return $_brand;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateBrand($brand_id, $request)
    {
        $data = $request->all();
        $_brand = $this->brandRepository->find($brand_id);
        if ($_brand) {
            $_brand_image = $_brand->image;
            if ($request->hasFile('brand_image')) {
                Helper::unlinkUploadedFile($_brand->image, "brand");
                $_brand_image = Helper::uploadFile(file: $request->brand_image, file_folder_name: "brand", width: 134, height: 134);
            }
            return $this->brandRepository->update($_brand, [
                'title' => $data['title'],
                'image' => $_brand_image,
                'description' => $data['description'] ?? "",
                'link' => $data['link'],
                'status' => EStatus::active
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteBrand($brand_id)
    {
        $_brand = $this->brandRepository->find($brand_id);
        if ($_brand) {
            Helper::unlinkUploadedFile($_brand->image, "brand");
            return $this->brandRepository->delete($_brand);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->brandRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_brand = $this->brandRepository->find($user_id);
        if ($_brand) {
            $this->brandRepository->update($_brand, ['status' => (($_brand->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


    public function getActiveBrandListArray(): AnonymousResourceCollection
    {
        $_brand = $this->brandRepository->getActiveList();
        return BrandResource::collection($_brand);
    }


}
