<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ProductGraphicRepository;
use JetBrains\PhpStorm\ArrayShape;

class ProductGraphicServices
{
    private string $notFoundMessage = "Sorry! Product Graphic not found";
    private ProductGraphicRepository $productGraphicRepository;


    public function __construct()
    {
        $this->productGraphicRepository = new ProductGraphicRepository();
    }

    public function getList()
    {
        return $this->productGraphicRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveProductGraphic($request): void
    {
        $data = $request->all();
        $this->productGraphicRepository->save([
            'name' => $data['name'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getProductGraphic($productGraphic_id)
    {
        $_productGraphic = $this->productGraphicRepository->find($productGraphic_id);
        if ($_productGraphic) {
            return $_productGraphic;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateProductGraphic($productGraphic_id, $request)
    {
        $data = $request->all();
        $_productGraphic = $this->productGraphicRepository->find($productGraphic_id);
        if ($_productGraphic) {
            return $this->productGraphicRepository->update($_productGraphic, ['name' => $data['name']]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteProductGraphic($productGraphic_id)
    {
        $_productGraphic = $this->productGraphicRepository->find($productGraphic_id);
        if ($_productGraphic) {
            $this->productGraphicRepository->update($_productGraphic, [
                'name' => $_productGraphic->name. "-(".Helper::smTodayInYmdHis().")"
                ]);
            return $this->productGraphicRepository->delete($_productGraphic);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->productGraphicRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_productGraphic = $this->productGraphicRepository->find($user_id);
        if ($_productGraphic) {
            $this->productGraphicRepository->update($_productGraphic, ['status' => (($_productGraphic->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
