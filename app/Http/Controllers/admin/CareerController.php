<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CareerRequest;
use App\Http\Services\CareerServices;
use App\Http\Services\DepartmentServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CareerController extends Controller


{
    private string $basePath = "admin.career.";
    private string $error_message = "Oops! Something went wrong.";
    private CareerServices $careerServices;
    private DepartmentServices $departmentServices;

    public function __construct()
    {
        $this->careerServices = new CareerServices();
        $this->departmentServices = new DepartmentServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_career = $this->careerServices->getList();
        return view($this->basePath . "index", compact('_career'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $_department = $this->departmentServices->getSelectList();
        return view($this->basePath . "create", compact('_department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CareerRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(CareerRequest $request): RedirectResponse
    {
        try {
            $this->careerServices->saveCareer($request);
            alert()->success('Success', 'Career  has been created successfully');
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
            $_department = $this->departmentServices->getSelectList();
            $_career = $this->careerServices->getCareer($id);
            return view($this->basePath . "edit", compact('_career', '_department'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CareerRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CareerRequest $request, int $id): RedirectResponse
    {
        try {
            $this->careerServices->updateCareer($id, $request);
            alert()->success('Success', 'Career  has been updated successfully');
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
            $this->careerServices->deleteCareer($id);
            alert()->success('Success', 'Career  has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->careerServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function applicationList()
    {
        try {
            $_application = $this->careerServices->listApplication();
            return view($this->basePath . "indexApplication", compact('_application'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }
}
