<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShowroomRequest;
use App\Http\Services\ShowroomServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class ShowroomController extends Controller
{
    private string $basePath = "admin.showroom.";
    private string $error_message = "Oops! Something went wrong.";
    private ShowroomServices $showroomServices;


    public function __construct()
    {
        $this->showroomServices = new ShowroomServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_showrooms = $this->showroomServices->getList();
        return view($this->basePath . "index", compact('_showrooms'));
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
     * @param ShowroomRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(ShowroomRequest $request): RedirectResponse
    {
        try {
            $this->showroomServices->saveShowroom($request);
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
            $_showroom = $this->showroomServices->getShowroom($id);
            return view($this->basePath . "edit", compact('_showroom'));
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
    public function update(ShowroomRequest $request, int $id): RedirectResponse
    {
        try {
            $this->showroomServices->updateShowroom($id, $request);
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
            $this->showroomServices->deleteShowroom($id);
            alert()->success('Success', 'Showroom has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->showroomServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function changeIsFeature(int $id): array
    {
        try {
            return $this->showroomServices->changeIsFeature($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function changeShowInContactUs(int $id): array
    {
        try {
            return $this->showroomServices->changeShowInContactUs($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
