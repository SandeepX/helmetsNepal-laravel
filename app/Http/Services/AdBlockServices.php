<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\AdBlockRepository;
use JetBrains\PhpStorm\ArrayShape;

class AdBlockServices
{
    private string $notFoundMessage = "Sorry! AdBlock not found";


    public function __construct()
    {
        $this->adBlockRepository = new AdBlockRepository();
    }

    public function getList(): mixed
    {
        return $this->adBlockRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function getAdBlock($adBlock_id): mixed
    {
        $_adBlock = $this->adBlockRepository->find($adBlock_id);
        if ($_adBlock) {
            return $_adBlock;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateAdBlock($adBlock_id, $request): mixed
    {
        $data = $request->all();
        $_adBlock = $this->adBlockRepository->find($adBlock_id);
        if ($_adBlock) {
            $_image = $_adBlock->image;
            if ($request->hasFile('image')) {
                if ($_adBlock->image) {
                    Helper::unlinkUploadedFile($_adBlock->image, "adBlock");
                }
                $_image = Helper::uploadFile(file: $request->image, file_folder_name: "adBlock", width: 570, height: 165);
            }
            return $this->adBlockRepository->update($_adBlock, [
                'title' => $data['title'],
                'sub_title' => $data['sub_title'],
                'image' => $_image,
                'description' => $data['description'],
                'link' => $data['link'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_adBlock = $this->adBlockRepository->find($user_id);
        if ($_adBlock) {
            $this->adBlockRepository->update($_adBlock, ['status' => (($_adBlock->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getActiveAdBlockListArray(): array
    {
        $return_array = [];
        $_adBlock = $this->adBlockRepository->getActiveList();
        foreach ($_adBlock as $value) {
            $return_array[$value->section] = [
                'title' => $value->title,
                'sub_title' => $value->sub_title,
                'image_path' => $value->image_path,
                'description' => $value->description,
                'link' => $value->link,
            ];
        }
        return $return_array;

    }

    public function getActiveAdBlockByService($section): array
    {
        $return_array = [];
        $_adBlock = $this->adBlockRepository->getActiveAdBlockBySection($section);
        foreach ($_adBlock as $value) {
            $return_array[$value->section] = [
                'title' => $value->title,
                'sub_title' => $value->sub_title,
                'image_path' => $value->image_path,
                'description' => $value->description,
                'link' => $value->link,
            ];
        }
        return $return_array;
    }


}
