<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageBannerRequest;
use App\Http\Services\PageBannerServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class PageBannerController extends Controller
{
    private string $basePath = "admin.pageBanner.";
    private string $error_message = "Oops! Something went wrong.";
    private PageBannerServices $pageBannerServices;

    public function __construct()
    {
        $this->pageBannerServices = new PageBannerServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_pageBanners = $this->pageBannerServices->getList();
        return view($this->basePath . "index", compact('_pageBanners'));
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
            $_pageBanner = $this->pageBannerServices->getPageBanner($id);
            return view($this->basePath . "edit", compact('_pageBanner'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PageBannerRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(PageBannerRequest $request, int $id): RedirectResponse
    {
        try {
            $this->pageBannerServices->updatePageBanner($id, $request);
            alert()->success('Success', 'PageBanner has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route($this->basePath . "index");
    }

}
