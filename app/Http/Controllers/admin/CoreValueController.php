<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoreValueRequest;
use App\Http\Services\CoreValueServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CoreValueController extends Controller
{
    private string $basePath = "admin.coreValue.";
    private string $error_message = "Oops! Something went wrong.";
    private CoreValueServices $coreValueServices;


    public function __construct()
    {
        $this->coreValueServices = new CoreValueServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_coreValues = $this->coreValueServices->getList();
        return view($this->basePath . "index", compact('_coreValues'));
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
     * @param CoreValueRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(CoreValueRequest $request): RedirectResponse
    {
        try {
            $this->coreValueServices->saveCoreValue($request);
            alert()->success('Success', 'Core Value has been created successfully');
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
            $_coreValue = $this->coreValueServices->getCoreValue($id);
            return view($this->basePath . "edit", compact('_coreValue'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CoreValueRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CoreValueRequest $request, int $id): RedirectResponse
    {
        try {
            $this->coreValueServices->updateCoreValue($id, $request);
            alert()->success('Success', 'Core Value has been updated successfully');
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
            $this->coreValueServices->deleteCoreValue($id);
            alert()->success('Success', 'CoreValue has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->coreValueServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
