<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductModelRequest;
use App\Http\Services\ProductModelServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ProductModelController extends Controller
{
    private string $basePath = "admin.productModel.";
    private string $error_message = "Oops! Something went wrong.";
    private ProductModelServices $productModelServices;

    public function __construct()
    {
        $this->productModelServices = new ProductModelServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_productModel = $this->productModelServices->getList();
        return view($this->basePath . "index", compact('_productModel'));
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
     * @param ProductModelRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(ProductModelRequest $request): RedirectResponse
    {
        try {
            $this->productModelServices->saveProductModel($request);
            alert()->success('Success', 'ProductModel has been created successfully');
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
            $_productModel = $this->productModelServices->getProductModel($id);
            return view($this->basePath . "edit", compact('_productModel'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductModelRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ProductModelRequest $request, int $id): RedirectResponse
    {
        try {
            $this->productModelServices->updateProductModel($id, $request);
            alert()->success('Success', 'ProductModel has been updated successfully');
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
            $this->productModelServices->deleteProductModel($id);
            alert()->success('Success', 'ProductModel has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->productModelServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
