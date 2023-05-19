<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Services\BrandServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class BrandController extends Controller
{
    private string $basePath = "admin.brands.";
    private string $error_message = "Oops! Something went wrong.";
    private BrandServices $brandServices;


    public function __construct()
    {
        $this->brandServices = new BrandServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_brands = $this->brandServices->getList();
        return view($this->basePath . "index", compact('_brands'));
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
     * @param BrandRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(BrandRequest $request): RedirectResponse
    {
        try {
            $this->brandServices->saveBrand($request);
            alert()->success('Success', 'Brand has been created successfully');
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
            $_brand = $this->brandServices->getBrand($id);
            return view($this->basePath . "edit", compact('_brand'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BrandRequest $request, int $id): RedirectResponse
    {
        try {
            $this->brandServices->updateBrand($id, $request);
            alert()->success('Success', 'Brand has been updated successfully');
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
            $this->brandServices->deleteBrand($id);
            alert()->success('Success', 'Brand has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->brandServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
