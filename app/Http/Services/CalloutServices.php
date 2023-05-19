<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\CalloutRepository;
use App\Http\Resources\CalloutResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class CalloutServices
{
    private string $notFoundMessage = "Sorry! Callout not found";


    public function __construct()
    {
        $this->calloutRepository = new CalloutRepository();
    }

    public function getList()
    {
        return $this->calloutRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveCallout($request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $_image = Helper::uploadFile(file: $request->image, file_folder_name: "callout", width: 134, height: 134);
        } else {
            throw new SMException("Callout image not found");
        }
        return $this->calloutRepository->save([
            'title' => $data['title'],
            'image' => $_image,
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getCallout($callout_id)
    {
        $_callout = $this->calloutRepository->find($callout_id);
        if ($_callout) {
            return $_callout;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateCallout($callout_id, $request)
    {
        $data = $request->all();
        $_callout = $this->calloutRepository->find($callout_id);
        if ($_callout) {
            $_image = $_callout->image;
            if ($request->hasFile('image')) {
                Helper::unlinkUploadedFile($_callout->image, "callout");
                $_image = Helper::uploadFile(file: $request->image, file_folder_name: "callout", width: 134, height: 134);
            }
            return $this->calloutRepository->update($_callout, [
                'title' => $data['title'],
                'image' => $_image,
                'description' => $data['description'],
                'type' => $data['type'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteCallout($callout_id)
    {
        $_callout = $this->calloutRepository->find($callout_id);
        if ($_callout) {
            $this->calloutRepository->update($_callout, [
                'title' => $_callout->title. "-(".Helper::smTodayInYmdHis().")",
            ]);
            Helper::unlinkUploadedFile($_callout->image, "callout");
            return $this->calloutRepository->delete($_callout);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_callout = $this->calloutRepository->find($user_id);
        if ($_callout) {
            $this->calloutRepository->update($_callout, ['status' => (($_callout->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getActiveList($type): AnonymousResourceCollection
    {
        return CalloutResource::collection($this->calloutRepository->getActiveLIst($type));
    }


}
