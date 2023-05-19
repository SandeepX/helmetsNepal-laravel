<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ShowroomRepository;
use App\Http\Resources\ShowroomResources;
use JetBrains\PhpStorm\ArrayShape;

class ShowroomServices
{
    private string $notFoundMessage = "Sorry! Showroom not found";


    public function __construct()
    {
        $this->showroomRepository = new ShowroomRepository();
    }

    public function getList()
    {
        return $this->showroomRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveShowroom($request)
    {
        $data = $request->all();
        if ($request->hasFile('showroom_image')) {
            $_showroom_image = Helper::uploadFile(file: $request->showroom_image, file_folder_name: "showroom", width: 400, height: 400);
        } else {
            throw new SMException("Showroom image not found");
        }
        return $this->showroomRepository->save([
            'name' => $data['name'],
            'address' => $data['address'],
            'google_map_link' => $data['google_map_link'],
            'youtube_link' => $data['youtube_link'],
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'contact_person' => $data['contact_person'],
            'showroom_image' => $_showroom_image,
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getShowroom($showroom_id)
    {
        $_showroom = $this->showroomRepository->find($showroom_id);
        if ($_showroom) {
            return $_showroom;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateShowroom($showroom_id, $request)
    {
        $data = $request->all();
        $_showroom = $this->showroomRepository->find($showroom_id);
        if ($_showroom) {
            $_showroom_image = $_showroom->showroom_image;
            if ($request->hasFile('showroom_image')) {
                Helper::unlinkUploadedFile($_showroom->showroom_image, "showroom");
                $_showroom_image = Helper::uploadFile(file: $request->showroom_image, file_folder_name: "showroom", width: 400, height: 400);
            }
            return $this->showroomRepository->update($_showroom, [
                'name' => $data['name'],
                'address' => $data['address'],
                'google_map_link' => $data['google_map_link'],
                'youtube_link' => $data['youtube_link'],
                'email' => $data['email'],
                'contact_no' => $data['contact_no'],
                'contact_person' => $data['contact_person'],
                'showroom_image' => $_showroom_image,
                'status' => EStatus::active
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteShowroom($showroom_id)
    {
        $_showroom = $this->showroomRepository->find($showroom_id);
        if ($_showroom) {
            Helper::unlinkUploadedFile($_showroom->showroom_image, "showroom");
            return $this->showroomRepository->delete($_showroom);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_showroom = $this->showroomRepository->find($user_id);
        if ($_showroom) {
            $this->showroomRepository->update($_showroom, ['status' => (($_showroom->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function changeIsFeature($user_id): array
    {
        $_showroom = $this->showroomRepository->find($user_id);
        if ($_showroom) {
            $this->showroomRepository->update($_showroom, ['is_feature' => (($_showroom->is_feature == 1) ? 0 : 1)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function changeShowInContactUs($user_id): array
    {
        $_showroom = $this->showroomRepository->find($user_id);
        if ($_showroom) {
            $this->showroomRepository->update($_showroom, ['show_in_contactUs' => (($_showroom->show_in_contactUs == 1) ? 0 : 1)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getShowroomList($request)
    {
        $per_page = 2;
        if ($request->has('per_page')) {
            $per_page = $request->per_page;
        }
        $_showroom = $this->showroomRepository->getActiveListWithPaginate(paginate: $per_page);
        $page_details = $_showroom->toArray();
        unset($page_details['data']);
        return [
            'page_details' => $page_details,
            'showroom' => ShowroomResources::collection($_showroom),
        ];

    }

    public function getFeaturedShowroom()
    {
        return $this->showroomRepository->getFeaturedShowroomList();
    }

    public function getShowInContactList()
    {
        return $this->showroomRepository->getShowInContactList();
    }


}
