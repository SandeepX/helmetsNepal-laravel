<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ProductModelRepository;
use JetBrains\PhpStorm\ArrayShape;

class ProductModelServices
{
    private string $notFoundMessage = "Sorry! ProductModel not found";
    private ProductModelRepository $productModelRepository;


    public function __construct()
    {
        $this->productModelRepository = new ProductModelRepository();
    }

    public function getList()
    {
        return $this->productModelRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveProductModel($request): void
    {
        $data = $request->all();
        $this->productModelRepository->save([
            'name' => $data['name'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getProductModel($productModel_id)
    {
        $_productModel = $this->productModelRepository->find($productModel_id);
        if ($_productModel) {
            return $_productModel;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateProductModel($productModel_id, $request)
    {
        $data = $request->all();
        $_productModel = $this->productModelRepository->find($productModel_id);
        if ($_productModel) {
            return $this->productModelRepository->update($_productModel, ['name' => $data['name']]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteProductModel($productModel_id)
    {
        $_productModel = $this->productModelRepository->find($productModel_id);
        if ($_productModel) {
            $this->productModelRepository->update($_productModel, [
                'name' => $_productModel->name. "-(".Helper::smTodayInYmdHis().")"
            ]);
            return $this->productModelRepository->delete($_productModel);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->productModelRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_productModel = $this->productModelRepository->find($user_id);
        if ($_productModel) {
            $this->productModelRepository->update($_productModel, ['status' => (($_productModel->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
