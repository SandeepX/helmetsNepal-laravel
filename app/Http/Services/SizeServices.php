<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\SizeRepository;
use JetBrains\PhpStorm\ArrayShape;

class SizeServices
{
    private string $notFoundMessage = "Sorry! Size not found";


    public function __construct()
    {
        $this->sizeRepository = new SizeRepository();
    }

    public function getList()
    {
        return $this->sizeRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveSize($request): void
    {
        $data = $request->all();
        $this->sizeRepository->save([
            'name' => $data['name'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getSize($size_id)
    {
        $_size = $this->sizeRepository->find($size_id);
        if ($_size) {
            return $_size;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateSize($size_id, $request)
    {
        $data = $request->all();
        $_size = $this->sizeRepository->find($size_id);
        if ($_size) {
            return $this->sizeRepository->update($_size, ['name' =>$data['name']]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteSize($size_id)
    {
        $_size = $this->sizeRepository->find($size_id);
        if ($_size) {
            $this->sizeRepository->update($_size, ['name' =>$_size->name. "-(".Helper::smTodayInYmdHis().")"]);
            return $this->sizeRepository->delete($_size);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->sizeRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_size = $this->sizeRepository->find($user_id);
        if ($_size) {
            $this->sizeRepository->update($_size, ['status' => (($_size->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
