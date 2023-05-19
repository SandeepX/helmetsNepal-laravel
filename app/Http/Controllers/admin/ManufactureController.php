<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManufactureRequest;
use App\Http\Services\ManufactureServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ManufactureController extends Controller

{
    private string $basePath = "admin.manufacture.";
    private string $error_message = "Oops! Something went wrong.";
    private ManufactureServices $manufactureServices;

    public function __construct()
    {
        $this->manufactureServices = new ManufactureServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_manufactures = $this->manufactureServices->getList();
        return view($this->basePath . "index", compact('_manufactures'));
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
     * @param ManufactureRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(ManufactureRequest $request): RedirectResponse
    {
        try {
            $this->manufactureServices->saveManufacture($request);
            alert()->success('Success', 'Manufacture has been created successfully');
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
            $_manufacture = $this->manufactureServices->getManufacture($id);
            return view($this->basePath . "edit", compact('_manufacture'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ManufactureRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ManufactureRequest $request, int $id): RedirectResponse
    {
        try {
            $this->manufactureServices->updateManufacture($id, $request);
            alert()->success('Success', 'Manufacture has been updated successfully');
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
            $this->manufactureServices->deleteManufacture($id);
            alert()->success('Success', 'Manufacture has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->manufactureServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
