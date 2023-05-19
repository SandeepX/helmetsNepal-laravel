<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ManufactureRepository;
use JetBrains\PhpStorm\ArrayShape;

class ManufactureServices
{
    private string $notFoundMessage = "Sorry! Manufacture not found";
    private ManufactureRepository $manufactureRepository;


    public function __construct()
    {
        $this->manufactureRepository = new ManufactureRepository();
    }

    public function getList()
    {
        return $this->manufactureRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveManufacture($request): void
    {
        $data = $request->all();
        $this->manufactureRepository->save([
            'name' => $data['name'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getManufacture($manufacture_id)
    {
        $_manufacture = $this->manufactureRepository->find($manufacture_id);
        if ($_manufacture) {
            return $_manufacture;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateManufacture($manufacture_id, $request)
    {
        $data = $request->all();
        $_manufacture = $this->manufactureRepository->find($manufacture_id);
        if ($_manufacture) {
            return $this->manufactureRepository->update($_manufacture, ['name' => $data['name']]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteManufacture($manufacture_id)
    {
        $_manufacture = $this->manufactureRepository->find($manufacture_id);
        if ($_manufacture) {
            $this->manufactureRepository->update($_manufacture, [
                'name' => $_manufacture->name. "-(".Helper::smTodayInYmdHis().")",
            ]);
            return $this->manufactureRepository->delete($_manufacture);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->manufactureRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_manufacture = $this->manufactureRepository->find($user_id);
        if ($_manufacture) {
            $this->manufactureRepository->update($_manufacture, ['status' => (($_manufacture->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
