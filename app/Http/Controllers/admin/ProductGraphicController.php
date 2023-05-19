<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGraphicRequest;
use App\Http\Services\ProductGraphicServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ProductGraphicController extends Controller

{
    private string $basePath = "admin.productGraphic.";
    private string $error_message = "Oops! Something went wrong.";
    private ProductGraphicServices $productGraphicServices;

    public function __construct()
    {
        $this->productGraphicServices = new ProductGraphicServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_productGraphic = $this->productGraphicServices->getList();
        return view($this->basePath . "index", compact('_productGraphic'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view($this->basePath . "create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductGraphicRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(ProductGraphicRequest $request): RedirectResponse
    {
        try {
            $this->productGraphicServices->saveProductGraphic($request);
            alert()->success('Success', 'ProductGraphic has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
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
            $_productGraphic = $this->productGraphicServices->getProductGraphic($id);
            return view($this->basePath . "edit", compact('_productGraphic'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductGraphicRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ProductGraphicRequest $request, int $id): RedirectResponse
    {
        try {
            $this->productGraphicServices->updateProductGraphic($id, $request);
            alert()->success('Success', 'ProductGraphic has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->productGraphicServices->deleteProductGraphic($id);
            alert()->success('Success', 'ProductGraphic has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->productGraphicServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
