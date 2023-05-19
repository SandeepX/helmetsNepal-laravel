<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PagesRequest;
use App\Http\Services\CompanyDetailsServices;
use App\Http\Services\PagesServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class PagesController extends Controller

{
    private string $basePath = "admin.pages.";
    private string $error_message = "Oops! Something went wrong.";
    private PagesServices $pagesServices;

    public function __construct()
    {
        $this->companyDetailServices = new CompanyDetailsServices();
        $this->pagesServices = new PagesServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_pages = $this->pagesServices->getList();
        $fe_link = $this->companyDetailServices->getFELink();
        return view($this->basePath . "index", compact('_pages' , 'fe_link'));
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
     * @param PagesRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(PagesRequest $request): RedirectResponse
    {
        try {
            $this->pagesServices->savePages($request);
            alert()->success('Success', 'Pages has been created successfully');
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
            $_pages = $this->pagesServices->getPages($id);
            return view($this->basePath . "edit", compact('_pages'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PagesRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(PagesRequest $request, int $id): RedirectResponse
    {
        try {
            $this->pagesServices->updatePages($id, $request);
            alert()->success('Success', 'Pages has been updated successfully');
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
            $this->pagesServices->deletePages($id);
            alert()->success('Success', 'Pages has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->pagesServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
