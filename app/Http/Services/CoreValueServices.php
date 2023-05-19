<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\CoreValueRepository;
use App\Http\Resources\CoreValueResource;
use JetBrains\PhpStorm\ArrayShape;

class CoreValueServices
{
    private string $notFoundMessage = "Sorry! CoreValue not found";


    public function __construct()
    {
        $this->coreValueRepository = new CoreValueRepository();
    }

    public function getList()
    {
        return $this->coreValueRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveCoreValue($request)
    {

        $data = $request->all();
        if ($request->hasFile('png_image')) {
            $_png_image = Helper::uploadFile(file: $request->png_image, file_folder_name: "coreValue", width: 134, height: 134);
        } else {
            throw new SMException("Core Value png image not found");
        }
        return $this->coreValueRepository->save([
            'title' => $data['title'],
            'png_image' => $_png_image,
            'description' => $data['description'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getCoreValue($coreValue_id)
    {
        $_coreValue = $this->coreValueRepository->find($coreValue_id);
        if ($_coreValue) {
            return $_coreValue;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateCoreValue($coreValue_id, $request)
    {
        $data = $request->all();
        $_coreValue = $this->coreValueRepository->find($coreValue_id);
        if ($_coreValue) {
            $_png_image = $_coreValue->png_image;
            if ($request->hasFile('png_image')) {
                Helper::unlinkUploadedFile($_coreValue->png_image, "coreValue");
                $_png_image = Helper::uploadFile(file: $request->png_image, file_folder_name: "coreValue", width: 134, height: 134);
            }
            return $this->coreValueRepository->update($_coreValue, [
                'title' => $data['title'],
                'png_image' => $_png_image,
                'description' => $data['description'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteCoreValue($coreValue_id)
    {
        $_coreValue = $this->coreValueRepository->find($coreValue_id);
        if ($_coreValue) {
            $this->coreValueRepository->update($_coreValue, [
                'title' =>$_coreValue->title. "-(".Helper::smTodayInYmdHis().")"
            ]);
            Helper::unlinkUploadedFile($_coreValue->png_image, "coreValue");
            return $this->coreValueRepository->delete($_coreValue);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_coreValue = $this->coreValueRepository->find($user_id);
        if ($_coreValue) {
            $this->coreValueRepository->update($_coreValue, ['status' => (($_coreValue->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getActiveList()
    {
        return CoreValueResource::collection($this->coreValueRepository->getActiveLIst());
    }


}
