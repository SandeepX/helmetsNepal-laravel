<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Services\UserServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    private string $basePath = "admin.users.";
    private string $error_message = "Oops! Something went wrong.";
    private UserServices $userServices;

    public function __construct()
    {
        $this->userServices = new UserServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_users = $this->userServices->getList();
        return view($this->basePath . "index", compact('_users'));
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
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->userServices->saveUser($request);
            alert()->success('Success', 'User has been created successfully');
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
            $_user = $this->userServices->getUser($id);
            return view($this->basePath . "edit", compact('_user'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UserRequest $request, int $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->userServices->updateUser($id, $request);
            alert()->success('Success', 'User has been updated successfully');
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
            $this->userServices->deleteUser($id);
            alert()->success('Success', 'User has been deleted');
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
            return $this->userServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function changePassword(int $id)
    {
        try {
            $_user = $this->userServices->getUser($id);
            return view($this->basePath . "editPassword", compact('_user'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function savePassword(Request $request, int $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->userServices->updatePassword($id, $request);
            alert()->success('Success', 'User has been updated successfully');
            Db::commit();
        } catch (Throwable $e) {
            Db::rollBack();
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }
}
