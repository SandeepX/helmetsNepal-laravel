<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCategoryRequest;
use App\Http\Services\FaqCategoryServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class FaqCategoryController extends Controller

{
    private string $basePath = "admin.faq-category.";
    private string $error_message = "Oops! Something went wrong.";
    private FaqCategoryServices $faqCategoryServices;

    public function __construct()
    {
        $this->faqCategoryServices = new FaqCategoryServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_faqCategory = $this->faqCategoryServices->getList();
        return view($this->basePath . "index", compact('_faqCategory'));
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
     * @param FaqCategoryRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(FaqCategoryRequest $request): RedirectResponse
    {
        try {
            $this->faqCategoryServices->saveFaqCategory($request);
            alert()->success('Success', 'Faq Category has been created successfully');
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
            $_faqCategory = $this->faqCategoryServices->getFaqCategory($id);
            return view($this->basePath . "edit", compact('_faqCategory'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FaqCategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(FaqCategoryRequest $request, int $id): RedirectResponse
    {
        try {
            $this->faqCategoryServices->updateFaqCategory($id, $request);
            alert()->success('Success', 'Faq Category has been updated successfully');
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
            $this->faqCategoryServices->deleteFaqCategory($id);
            alert()->success('Success', 'Faq Category has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->faqCategoryServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
