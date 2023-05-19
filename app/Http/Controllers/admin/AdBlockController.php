<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdBlockRequest;
use App\Http\Services\AdBlockServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class AdBlockController extends Controller

{
    private string $basePath = "admin.adBlock.";
    private string $error_message = "Oops! Something went wrong.";
    private AdBlockServices $adBlockServices;


    public function __construct()
    {
        $this->adBlockServices = new AdBlockServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_adBlock = $this->adBlockServices->getList();
        return view($this->basePath . "index", compact('_adBlock'));
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
            $_adBlock = $this->adBlockServices->getAdBlock($id);
            return view($this->basePath . "edit", compact('_adBlock'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(AdBlockRequest $request, int $id): RedirectResponse
    {
        try {
            $this->adBlockServices->updateAdBlock($id, $request);
            alert()->success('Success', 'AdBlock has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->adBlockServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
