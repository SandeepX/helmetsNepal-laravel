<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\RiderStoryRepository;
use App\Http\Resources\RiderStoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class RiderStoryServices
{
    private string $notFoundMessage = "Sorry! Rider Story not found";
    private RiderStoryRepository $riderStoryRepository;


    public function __construct()
    {
        $this->riderStoryRepository = new RiderStoryRepository();
    }

    public function getList()
    {
        return $this->riderStoryRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveRiderStory($request)
    {

        $data = $request->all();
        if ($request->hasFile('riderStory_image')) {
            $_riderStory_image = Helper::uploadFile(file: $request->riderStory_image, file_folder_name: "riderStory", width: 128, height: 128);
        } else {
            throw new SMException("Rider Story image not found");
        }
        return $this->riderStoryRepository->save([
            'name' => $data['name'],
            'designation' => $data['designation'],
            'quote' => $data['quote'],
            'image' => $_riderStory_image,
            'description' => $data['description'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getRiderStory($riderStory_id)
    {
        $_riderStory = $this->riderStoryRepository->find($riderStory_id);
        if ($_riderStory) {
            return $_riderStory;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateRiderStory($riderStory_id, $request)
    {
        $data = $request->all();
        $_riderStory = $this->riderStoryRepository->find($riderStory_id);
        if ($_riderStory) {
            if ($request->hasFile('riderStory_image')) {
                Helper::unlinkUploadedFile($_riderStory->image, "riderStory");
                $_riderStory_image = Helper::uploadFile(file: $request->riderStory_image, file_folder_name: "riderStory", width: 128, height: 128);
            } else {
                $_riderStory_image = $_riderStory->image;
            }
            return $this->riderStoryRepository->update($_riderStory, [
                'name' => $data['name'],
                'designation' => $data['designation'],
                'quote' => $data['quote'],
                'image' => $_riderStory_image,
                'description' => $data['description'],
                'status' => EStatus::active
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteRiderStory($riderStory_id)
    {
        $_riderStory = $this->riderStoryRepository->find($riderStory_id);
        if ($_riderStory) {
            Helper::unlinkUploadedFile($_riderStory->image, "riderStory");
            return $this->riderStoryRepository->delete($_riderStory);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->riderStoryRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_riderStory = $this->riderStoryRepository->find($user_id);
        if ($_riderStory) {
            $this->riderStoryRepository->update($_riderStory, ['status' => (($_riderStory->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


    public function getRiderStoryList(): AnonymousResourceCollection
    {
        $_riderStory = $this->riderStoryRepository->getActiveRiderStoryList();
        return RiderStoryResource::collection($_riderStory);
    }

    /**
     * @throws SMException
     */
    public function getRiderStoryDetails($riderStory_id): array
    {
        $_riderStory = $this->riderStoryRepository->getActiveRiderStoryDetail($riderStory_id);
        if ($_riderStory) {
            return [
                'name' => $_riderStory->name,
                'image_path' => $_riderStory->image_path,
                'designation' => $_riderStory->designation,
                'quote' => $_riderStory->quote,
                'description' => $_riderStory->description,
            ];
        }
        throw new SMException($this->notFoundMessage);
    }


}
