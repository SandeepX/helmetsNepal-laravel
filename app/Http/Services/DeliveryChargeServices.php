<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\DeliveryChargeRepository;
use App\Http\Resources\DeliveryChargeResource;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;

class DeliveryChargeServices
{
    private string $notFoundMessage = "Sorry! Delivery Charge not found";


    public function __construct()
    {
        $this->deliveryChargeRepository = new DeliveryChargeRepository();
    }

    public function getList()
    {
        return $this->deliveryChargeRepository->findALl();
    }

    public function saveDeliveryCharge($title): void
    {
        $this->deliveryChargeRepository->save([
            'title' => $title,
            'delivery_charge_amount' => 0.0,
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getDeliveryCharge($deliveryCharge_id)
    {
        $_deliveryCharge = $this->deliveryChargeRepository->find($deliveryCharge_id);
        if ($_deliveryCharge) {
            return $_deliveryCharge;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateDeliveryCharge($deliveryCharge_id, $request)
    {
        $data = $request->all();
        $_deliveryCharge = $this->deliveryChargeRepository->find($deliveryCharge_id);
        if ($_deliveryCharge) {
            return $this->deliveryChargeRepository->update($_deliveryCharge, [
                'delivery_charge_amount' => $data['delivery_charge_amount'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteDeliveryCharge($deliveryCharge_id)
    {
        $_deliveryCharge = $this->deliveryChargeRepository->find($deliveryCharge_id);
        if ($_deliveryCharge) {
            return $this->deliveryChargeRepository->delete($_deliveryCharge);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->deliveryChargeRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_deliveryCharge = $this->deliveryChargeRepository->find($user_id);
        if ($_deliveryCharge) {
            $this->deliveryChargeRepository->update($_deliveryCharge, ['status' => (($_deliveryCharge->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


    public function getDeliveryChargeList(): \Illuminate\Http\JsonResponse
    {
        try {
            $_deliveryCharge = $this->deliveryChargeRepository->findALl();
            return Helper::successResponseAPI('Success', DeliveryChargeResource::collection($_deliveryCharge));
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
