<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalloutRequest;
use App\Http\Services\CalloutServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CalloutController extends Controller

{
    private string $basePath = "admin.callout.";
    private string $error_message = "Oops! Something went wrong.";
    private CalloutServices $calloutServices;


    public function __construct()
    {
        $this->calloutServices = new CalloutServices();
    }


    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $_callouts = $this->calloutServices->getList();
        return view($this->basePath . "index", compact('_callouts'));
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
     * @param CalloutRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(CalloutRequest $request): RedirectResponse
    {
        try {
            $this->calloutServices->saveCallout($request);
            alert()->success('Success', 'Core Value has been created successfully');
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
            $_callout = $this->calloutServices->getCallout($id);
            return view($this->basePath . "edit", compact('_callout'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CalloutRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CalloutRequest $request, int $id): RedirectResponse
    {
        try {
            $this->calloutServices->updateCallout($id, $request);
            alert()->success('Success', 'Core Value has been updated successfully');
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
            $this->calloutServices->deleteCallout($id);
            alert()->success('Success', 'Callout has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->calloutServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
