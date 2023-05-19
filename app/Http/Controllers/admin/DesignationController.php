<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationRequest;
use App\Http\Services\DesignationServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class DesignationController extends Controller

{
    private string $basePath = "admin.designation.";
    private string $error_message = "Oops! Something went wrong.";
    private DesignationServices $designationServices;

    public function __construct()
    {
        $this->designationServices = new DesignationServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_designation = $this->designationServices->getList();
        return view($this->basePath . "index", compact('_designation'));
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
     * @param DesignationRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(DesignationRequest $request): RedirectResponse
    {
        try {
            $this->designationServices->saveDesignation($request);
            alert()->success('Success', 'Designation has been created successfully');
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
            $_designation = $this->designationServices->getDesignation($id);
            return view($this->basePath . "edit", compact('_designation'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DesignationRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(DesignationRequest $request, int $id): RedirectResponse
    {
        try {
            $this->designationServices->updateDesignation($id, $request);
            alert()->success('Success', 'Designation has been updated successfully');
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
            $this->designationServices->deleteDesignation($id);
            alert()->success('Success', 'Designation has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->designationServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
