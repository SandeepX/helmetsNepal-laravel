<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ProductDiscountRepository;
use App\Http\Repositories\ProductRepository;
use JetBrains\PhpStorm\ArrayShape;

class ProductDiscountServices
{
    private string $notFoundMessage = "Sorry! ProductDiscount  not found";
    private ProductDiscountRepository $productDiscountRepository;


    public function __construct()
    {
        $this->productDiscountRepository = new ProductDiscountRepository();
        $this->productRepository = new ProductRepository();
    }

    public function getList()
    {
        return $this->productDiscountRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveProductDiscount($request, $product_id): void
    {
        $data = $request->all();
        $starting_date = $data['discount_start_date'];
        $expiry_date = $data['discount_end_date'];
        $d1 = strtotime($starting_date);
        $d2 = strtotime($expiry_date);
        if ($d1 >= $d2) {
            throw new SMException("End date cannot be greater than Starting date");
        }
        $this->productDiscountRepository->save([
            'discount_percent' => $data['discount_percent'],
            'discount_amount' => $data['discount_amount'],
            'discount_start_date' => $data['discount_start_date'],
            'discount_end_date' => $data['discount_end_date'],
            'product_id' => $product_id,
            'status' => EStatus::inactive,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getProductDiscount($productDiscount_id)
    {
        $_productModel = $this->productDiscountRepository->find($productDiscount_id);
        if ($_productModel) {
            return $_productModel;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateProductDiscount($productDiscount_id, $request)
    {
        $_productDiscount = $this->productDiscountRepository->find($productDiscount_id);
        if ($_productDiscount) {
            $data = $request->all();
            $starting_date = $data['discount_start_date'];
            $expiry_date = $data['discount_end_date'];
            $d1 = strtotime($starting_date);
            $d2 = strtotime($expiry_date);
            if ($d1 >= $d2) {
                throw new SMException("End date cannot be greater than Starting date");
            }
            $this->productDiscountRepository->update($_productDiscount, [
                'discount_percent' => $data['discount_percent'],
                'discount_amount' => $data['discount_amount'],
                'discount_start_date' => $data['discount_start_date'],
                'discount_end_date' => $data['discount_end_date']
            ]);
            return $_productDiscount->product_id;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteProductDiscount($productDiscount_id)
    {
        $_productDiscount = $this->productDiscountRepository->find($productDiscount_id);
        if ($_productDiscount) {
            $this->productDiscountRepository->delete($_productDiscount);
            return $_productDiscount->product_id;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($productDiscount_id): array
    {
        $_productDiscount = $this->productDiscountRepository->find($productDiscount_id);
        $_productDiscount_list = $this->productDiscountRepository->productDiscountList($_productDiscount->product_id);
        foreach ($_productDiscount_list as $value) {
            $this->productDiscountRepository->update($value, [
                'status' => EStatus::inactive
            ]);
        }
        if ($_productDiscount) {
            $this->productDiscountRepository->update($_productDiscount, [
                'status' => (($_productDiscount->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)
            ]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
