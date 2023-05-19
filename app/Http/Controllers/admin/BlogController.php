<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Services\BlogCategoryServices;
use App\Http\Services\BlogServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class BlogController extends Controller

{
    private string $basePath = "admin.blog.";
    private string $error_message = "Oops! Something went wrong.";
    private BlogServices $blogServices;
    private BlogCategoryServices $blogCategoryServices;

    public function __construct()
    {
        $this->blogServices = new BlogServices();
        $this->blogCategoryServices = new BlogCategoryServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_blog = $this->blogServices->getList();
        return view($this->basePath . "index", compact('_blog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $_blogCategory = $this->blogCategoryServices->getSelectList();
        return view($this->basePath . "create", compact('_blogCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(BlogRequest $request): RedirectResponse
    {
        try {
            $this->blogServices->saveBlog($request);
            alert()->success('Success', 'Blog  has been created successfully');
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
            $_blogCategory = $this->blogCategoryServices->getSelectList();
            $_blog = $this->blogServices->getBlog($id);
            return view($this->basePath . "edit", compact('_blog', '_blogCategory'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BlogRequest $request, int $id): RedirectResponse
    {
        try {
            $this->blogServices->updateBlog($id, $request);
            alert()->success('Success', 'Blog  has been updated successfully');
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
            $this->blogServices->deleteBlog($id);
            alert()->success('Success', 'Blog  has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->blogServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function changeFeaturedStatus(int $id): array
    {
        try {
            return $this->blogServices->changeFeaturedStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
