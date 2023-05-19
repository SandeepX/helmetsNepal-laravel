<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Services\DesignationServices;
use App\Http\Services\TeamServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class TeamController extends Controller

{
    private string $basePath = "admin.team.";
    private string $error_message = "Oops! Something went wrong.";
    private TeamServices $teamServices;
    private DesignationServices $designationServices;


    public function __construct()
    {
        $this->teamServices = new TeamServices();
        $this->designationServices = new DesignationServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_teams = $this->teamServices->getList();
        return view($this->basePath . "index", compact('_teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $_designation = $this->designationServices->getSelectList();
        return view($this->basePath . "create", compact('_designation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(TeamRequest $request): RedirectResponse
    {
        try {
            $this->teamServices->saveTeam($request);
            alert()->success('Success', 'Team has been created successfully');
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
            $_team = $this->teamServices->getTeam($id);
            $_designation = $this->designationServices->getSelectList();
            return view($this->basePath . "edit", compact('_team', '_designation'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $this->teamServices->updateTeam($id, $request);
            alert()->success('Success', 'Team has been updated successfully');
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
            $this->teamServices->deleteTeam($id);
            alert()->success('Success', 'Team has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->teamServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function changeFeaturedStatus(int $id): array
    {
        try {
            return $this->teamServices->changeFeaturedStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
