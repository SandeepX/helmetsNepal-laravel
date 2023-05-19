<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Http\Services\BlogCategoryServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class BlogCategoryController extends Controller


{
    private string $basePath = "admin.blogCategory.";
    private string $error_message = "Oops! Something went wrong.";
    private BlogCategoryServices $blogCategoryServices;

    public function __construct()
    {
        $this->blogCategoryServices = new BlogCategoryServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_blogCategory = $this->blogCategoryServices->getList();
        return view($this->basePath . "index", compact('_blogCategory'));
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
     * @param BlogCategoryRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        try {
            $this->blogCategoryServices->saveBlogCategory($request);
            alert()->success('Success', 'Blog Category has been created successfully');
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
            $_blogCategory = $this->blogCategoryServices->getBlogCategory($id);
            return view($this->basePath . "edit", compact('_blogCategory'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BlogCategoryRequest $request, int $id): RedirectResponse
    {
        try {
            $this->blogCategoryServices->updateBlogCategory($id, $request);
            alert()->success('Success', 'Blog Category has been updated successfully');
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
            $this->blogCategoryServices->deleteBlogCategory($id);
            alert()->success('Success', 'Blog Category has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->blogCategoryServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
