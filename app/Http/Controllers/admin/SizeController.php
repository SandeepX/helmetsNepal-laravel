<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Http\Services\SizeServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class SizeController extends Controller
{
    private string $basePath = "admin.size.";
    private string $error_message = "Oops! Something went wrong.";

    public function __construct()
    {
        $this->sizeServices = new SizeServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_size = $this->sizeServices->getList();
        return view($this->basePath . "index", compact('_size'));
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
     * @param SizeRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(SizeRequest $request): RedirectResponse
    {
        try {
            $this->sizeServices->saveSize($request);
            alert()->success('Success', 'Size has been created successfully');
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
            $_size = $this->sizeServices->getSize($id);
            return view($this->basePath . "edit", compact('_size'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SizeRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SizeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->sizeServices->updateSize($id, $request);
            alert()->success('Success', 'Size has been updated successfully');
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
            $this->sizeServices->deleteSize($id);
            alert()->success('Success', 'Size has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->sizeServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
