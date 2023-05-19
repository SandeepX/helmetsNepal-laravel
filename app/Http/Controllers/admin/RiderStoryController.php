<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RiderStoryRequest;
use App\Http\Services\RiderStoryServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class RiderStoryController extends Controller


{
    private string $basePath = "admin.riderStory.";
    private string $error_message = "Oops! Something went wrong.";
    private RiderStoryServices $riderStoryServices;


    public function __construct()
    {
        $this->riderStoryServices = new RiderStoryServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_ridersStory = $this->riderStoryServices->getList();
        return view($this->basePath . "index", compact('_ridersStory'));
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
     * @param RiderStoryRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(RiderStoryRequest $request): RedirectResponse
    {
        try {
            $this->riderStoryServices->saveRiderStory($request);
            alert()->success('Success', 'Rider Story has been created successfully');
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
            $_riderStory = $this->riderStoryServices->getRiderStory($id);
            return view($this->basePath . "edit", compact('_riderStory'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RiderStoryRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(RiderStoryRequest $request, int $id): RedirectResponse
    {
        try {
            $this->riderStoryServices->updateRiderStory($id, $request);
            alert()->success('Success', 'Rider Story has been updated successfully');
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
            $this->riderStoryServices->deleteRiderStory($id);
            alert()->success('Success', 'Rider Story has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->riderStoryServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
