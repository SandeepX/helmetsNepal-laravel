<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Services\HomePageSectionServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class HomePageSectionController extends Controller

{
    private string $basePath = "admin.homePageSection.";
    private string $error_message = "Oops! Something went wrong.";

    public function __construct()
    {
        $this->homePageSectionServices = new HomePageSectionServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_homePageSection = $this->homePageSectionServices->getList();
        return view($this->basePath . "index", compact('_homePageSection'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $this->homePageSectionServices->updateHomePageSection($request);
            alert()->success('Success', 'HomePageSection has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->homePageSectionServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
