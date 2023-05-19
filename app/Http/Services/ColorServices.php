<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ColorRepository;
use JetBrains\PhpStorm\ArrayShape;

class ColorServices
{
    private string $notFoundMessage = "Sorry! Color not found";


    public function __construct()
    {
        $this->colorRepository = new ColorRepository();
    }

    public function getList()
    {
        return $this->colorRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveColor($request): void
    {
        $data = $request->all();
        $this->colorRepository->save([
            'name' => $data['name'],
            'color_value' => $data['color_value'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getColor($color_id)
    {
        $_color = $this->colorRepository->find($color_id);
        if ($_color) {
            return $_color;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateColor($color_id, $request)
    {
        $data = $request->all();
        $_color = $this->colorRepository->find($color_id);
        if ($_color) {
            return $this->colorRepository->update($_color, [
                'name' => $data['name'],
                'color_value' => $data['color_value'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteColor($color_id)
    {
        $_color = $this->colorRepository->find($color_id);
        if ($_color) {
            $this->colorRepository->update($_color, [
                'name' => $_color->name. "-(".Helper::smTodayInYmdHis().")"
                ]);
            return $this->colorRepository->delete($_color);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->colorRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_color = $this->colorRepository->find($user_id);
        if ($_color) {
            $this->colorRepository->update($_color, ['status' => (($_color->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
