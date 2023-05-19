<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryChargeRequest;
use App\Http\Services\DeliveryChargeServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class DeliveryChargeController extends Controller

{
    private string $basePath = "admin.deliveryCharge.";
    private string $error_message = "Oops! Something went wrong.";
    private DeliveryChargeServices $deliveryChargeServices;

    public function __construct()
    {
        $this->deliveryChargeServices = new DeliveryChargeServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_deliveryCharges = $this->deliveryChargeServices->getList();
        return view($this->basePath . "index", compact('_deliveryCharges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function edit(int $id): View|Factory|Application|RedirectResponse
    {
        try {
            $_deliveryCharge = $this->deliveryChargeServices->getDeliveryCharge($id);
            return view($this->basePath . "edit", compact('_deliveryCharge'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param DeliveryChargeRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(DeliveryChargeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->deliveryChargeServices->updateDeliveryCharge($id, $request);
            alert()->success('Success', 'DeliveryCharge has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->deliveryChargeServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
