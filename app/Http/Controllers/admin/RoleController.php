<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Services\RoleServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class RoleController extends Controller
{
    private string $basePath = "admin.roles.";
    private string $error_message = "Oops! Something went wrong.";
    private RoleServices $roleServices;

    public function __construct()
    {
        $this->roleServices = new RoleServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_roles = $this->roleServices->getList();
        return view($this->basePath . "index", compact('_roles'));
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
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->roleServices->saveRole($request);
            alert()->success('Success', 'Role has been created successfully');
            Db::commit();
        } catch (Throwable $e) {
            Db::rollBack();
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
            $_user = $this->roleServices->getRole($id);
            return view($this->basePath . "edit", compact('_user'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, int $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->roleServices->updateRole($id, $request);
            alert()->success('Success', 'Role has been updated successfully');
            Db::commit();
        } catch (Throwable $e) {
            Db::rollBack();
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
            DB::beginTransaction();
            $this->roleServices->deleteRole($id);
            alert()->success('Success', 'Role has been deleted');
            Db::commit();
        } catch (Throwable $e) {
            Db::rollBack();
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->roleServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
