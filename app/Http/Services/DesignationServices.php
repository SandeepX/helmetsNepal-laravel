<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\DesignationRepository;
use JetBrains\PhpStorm\ArrayShape;

class DesignationServices
{
    private string $notFoundMessage = "Sorry! Designation not found";
    private DesignationRepository $designationRepository;


    public function __construct()
    {
        $this->designationRepository = new DesignationRepository();
    }

    public function getList()
    {
        return $this->designationRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveDesignation($request): void
    {
        $data = $request->all();
        $this->designationRepository->save([
            'name' => $data['name'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getDesignation($designation_id)
    {
        $_designation = $this->designationRepository->find($designation_id);
        if ($_designation) {
            return $_designation;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateDesignation($designation_id, $request)
    {
        $data = $request->all();
        $_designation = $this->designationRepository->find($designation_id);
        if ($_designation) {
            return $this->designationRepository->update($_designation, [
                'name' => $data['name']
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteDesignation($designation_id)
    {
        $_designation = $this->designationRepository->find($designation_id);
        if ($_designation) {
            $this->designationRepository->update($_designation, [
                'name' => $_designation->name. "-(".Helper::smTodayInYmdHis().")",
            ]);
            return $this->designationRepository->delete($_designation);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->designationRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_designation = $this->designationRepository->find($user_id);
        if ($_designation) {
            $this->designationRepository->update($_designation, ['status' => (($_designation->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
