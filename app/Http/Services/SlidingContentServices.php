<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\SlidingContentRepository;
use App\Http\Resources\ImageTypeSlidingContentResource;
use App\Http\Resources\YoutubeSlidingContentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class SlidingContentServices
{
    private string $notFoundMessage = "Sorry! data not found";


    public function __construct()
    {
        $this->slidingContentRepository = new SlidingContentRepository();
    }

    /**
     * @return mixed
     */
    public function getListSlidingContentImageType(): mixed
    {
        return $this->slidingContentRepository->findALlImageType();
    }

    /**
     * @throws SMException
     */
    public function saveSlidingContentImageType($request): mixed
    {
        $data = $request->all();
        $_sliding_content_image = "";
        if ($request->hasFile('sliding_content_image')) {
            $_sliding_content_image = Helper::uploadFile(file: $request->sliding_content_image, file_folder_name: "sliding_content", width: 550, height: 550);
        } else {
            throw new SMException("Image not found");
        }
        return $this->slidingContentRepository->save([
            'type' => 'image_type',
            'title' => $data['title'],
            'sub_title' => $data['title'],
            'image' => $_sliding_content_image,
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getSlidingContentImageType($slidingContent_id): mixed
    {
        $_slidingContent = $this->slidingContentRepository->findImageType($slidingContent_id);
        if ($_slidingContent) {
            return $_slidingContent;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateSlidingContentImageType($slidingContent_id, $request): mixed
    {
        $data = $request->all();
        $_slidingContent = $this->slidingContentRepository->findImageType($slidingContent_id);
        if ($_slidingContent) {
            $_sliding_content_image = $_slidingContent->image;
            if ($request->hasFile('sliding_content_image')) {
                Helper::unlinkUploadedFile($_slidingContent->image, "sliding_content");
                $_sliding_content_image = Helper::uploadFile(file: $request->sliding_content_image, file_folder_name: "sliding_content", width: 550, height: 550);
            }
            return $this->slidingContentRepository->update($_slidingContent, [
                'type' => 'image_type',
                'title' => $data['title'],
                'sub_title' => $data['sub_title'],
                'image' => $_sliding_content_image,
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @return mixed
     */
    public function getListSlidingContentYoutubeType(): mixed
    {
        return $this->slidingContentRepository->findALlYoutubeType();
    }

    /**
     * @param $request
     * @return mixed
     * @throws SMException
     */
    public function saveSlidingContentYoutubeType($request): mixed
    {
        $data = $request->all();
        if ($request->hasFile('sliding_content_image')) {
            $_sliding_content_image = Helper::uploadFile(file: $request->sliding_content_image, file_folder_name: "sliding_content", width: 400, height: 300);
        } else {
            throw new SMException("Image not found");
        }
        return $this->slidingContentRepository->save([
            'type' => 'youtube_type',
            'title' => $data['title'],
            'image' => $_sliding_content_image,
            'youtube_link' => $data['youtube_link'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getSlidingContentYoutubeType($slidingContent_id)
    {
        $_slidingContent = $this->slidingContentRepository->findYoutubeType($slidingContent_id);
        if ($_slidingContent) {
            return $_slidingContent;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @param $slidingContent_id
     * @param $request
     * @return mixed
     * @throws SMException
     */
    public function updateSlidingContentYoutubeType($slidingContent_id, $request): mixed
    {
        $data = $request->all();
        $_slidingContent = $this->slidingContentRepository->findYoutubeType($slidingContent_id);
        if ($_slidingContent) {
            $_sliding_content_image = $_slidingContent->image;
            if ($request->hasFile('sliding_content_image')) {
                Helper::unlinkUploadedFile($_slidingContent->image, "sliding_content");
                $_sliding_content_image = Helper::uploadFile(file: $request->sliding_content_image, file_folder_name: "sliding_content", width: 400, height: 300);
            }
            return $this->slidingContentRepository->update($_slidingContent, [
                'type' => 'youtube_type',
                'title' => $data['title'],
                'image' => $_sliding_content_image,
                'youtube_link' => $data['youtube_link'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @throws SMException
     */
    public function deleteSlidingContent($slidingContent_id): mixed
    {
        $_slidingContent = $this->slidingContentRepository->find($slidingContent_id);
        if ($_slidingContent) {
            if ($_slidingContent->image) {
                Helper::unlinkUploadedFile($_slidingContent->image, "slidingContent");
            }
            return $this->slidingContentRepository->delete($_slidingContent);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_slidingContent = $this->slidingContentRepository->find($user_id);
        if ($_slidingContent) {
            $this->slidingContentRepository->update($_slidingContent, ['status' => (($_slidingContent->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getImageTypeSlidingContent(): AnonymousResourceCollection
    {
        $_imageTypeSlidingContent = $this->slidingContentRepository->getImageTypeSlidingContent();
        return ImageTypeSlidingContentResource::collection($_imageTypeSlidingContent);
    }

    public function getYoutubeSlidingContent(): AnonymousResourceCollection
    {
        $_imageTypeSlidingContent = $this->slidingContentRepository->getYoutubeSlidingContent();
        return YoutubeSlidingContentResource::collection($_imageTypeSlidingContent);
    }


}
