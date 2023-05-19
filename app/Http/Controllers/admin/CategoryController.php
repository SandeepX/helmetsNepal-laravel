<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Services\CategoryServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CategoryController extends Controller
{
    private string $basePath = "admin.category.";
    private string $error_message = "Oops! Something went wrong.";
    private CategoryServices $categoryServices;

    public function __construct()
    {
        $this->categoryServices = new CategoryServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_category = $this->categoryServices->getList();
        return view($this->basePath . "index", compact('_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $_categorySelectList = $this->categoryServices->getParentCategoryList();
        return view($this->basePath . "create", compact('_categorySelectList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $this->categoryServices->saveCategory($request);
            alert()->success('Success', 'Category has been created successfully');
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
            $_category = $this->categoryServices->getCategoryWithDetails($id);
            $_categorySelectList = $this->categoryServices->getParentCategoryList();
            return view($this->basePath . "edit", compact('_category', '_categorySelectList'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        try {
            $this->categoryServices->updateCategory($id, $request);
            alert()->success('Success', 'Category has been updated successfully');
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
            $this->categoryServices->deleteCategory($id);
            alert()->success('Success', 'Category has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function getChildCategory(int $id): View|Factory|bool|Application
    {
        $_categories = $this->categoryServices->getChildCategory($id);
        if ($_categories) {
            return view($this->basePath . "childCategorySearch", compact('_categories'));
        }
        return false;
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->categoryServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
