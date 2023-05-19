<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Http\Services\FaqCategoryServices;
use App\Http\Services\FaqServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class FaqController extends Controller
{
    private string $basePath = "admin.faq.";
    private string $error_message = "Oops! Something went wrong.";
    private FaqServices $faqServices;
    private FaqCategoryServices $faqCategoryServices;

    public function __construct()
    {
        $this->faqServices = new FaqServices();
        $this->faqCategoryServices = new FaqCategoryServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_faq = $this->faqServices->getList();
        return view($this->basePath . "index", compact('_faq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $_faqCategory = $this->faqCategoryServices->getSelectList();
        return view($this->basePath . "create", compact('_faqCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FaqRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(FaqRequest $request): RedirectResponse
    {
        try {
            $this->faqServices->saveFaq($request);
            alert()->success('Success', 'Faq  has been created successfully');
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
            $_faqCategory = $this->faqCategoryServices->getSelectList();
            $_faq = $this->faqServices->getFaq($id);
            return view($this->basePath . "edit", compact('_faq', '_faqCategory'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FaqRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(FaqRequest $request, int $id): RedirectResponse
    {
        try {
            $this->faqServices->updateFaq($id, $request);
            alert()->success('Success', 'Faq  has been updated successfully');
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
            $this->faqServices->deleteFaq($id);
            alert()->success('Success', 'Faq  has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->faqServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
