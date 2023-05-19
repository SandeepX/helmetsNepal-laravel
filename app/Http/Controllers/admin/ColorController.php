<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Http\Services\ColorServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ColorController extends Controller
{
    private string $basePath = "admin.colors.";
    private string $error_message = "Oops! Something went wrong.";
    private ColorServices $colorServices;

    public function __construct()
    {
        $this->colorServices = new ColorServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_colors = $this->colorServices->getList();
        return view($this->basePath . "index", compact('_colors'));
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
     * @param ColorRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(ColorRequest $request): RedirectResponse
    {
        try {
            $this->colorServices->saveColor($request);
            alert()->success('Success', 'Color has been created successfully');
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
            $_color = $this->colorServices->getColor($id);
            return view($this->basePath . "edit", compact('_color'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param ColorRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ColorRequest $request, int $id): RedirectResponse
    {
        try {
            $this->colorServices->updateColor($id, $request);
            alert()->success('Success', 'Color has been updated successfully');
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
            $this->colorServices->deleteColor($id);
            alert()->success('Success', 'Color has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->colorServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
