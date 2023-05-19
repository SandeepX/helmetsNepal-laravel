<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\TeamRepository;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class TeamServices
{
    private string $notFoundMessage = "Sorry! Team not found";
    private TeamRepository $teamRepository;


    public function __construct()
    {
        $this->teamRepository = new TeamRepository();
    }

    public function getList()
    {
        return $this->teamRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveTeam($request)
    {
        $data = $request->all();
        if ($request->hasFile('team_image')) {
            $_team_image = Helper::uploadFile(file: $request->team_image, file_folder_name: "team", width: 300, height: 300);
        } else {
            throw new SMException("Team image not found");
        }
        return $this->teamRepository->save([
            'name' => $data['name'],
            'designation_id' => $data['designation_id'],
            'image' => $_team_image,
            'slug' => Helper::getSlugSimple($data['name']),
            'description' => $data['description'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getTeam($team_id)
    {
        $_team = $this->teamRepository->find($team_id);
        if ($_team) {
            return $_team;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateTeam($team_id, $request)
    {
        $data = $request->all();
        $_team = $this->teamRepository->find($team_id);
        if ($_team) {
            if ($request->hasFile('team_image')) {
                Helper::unlinkUploadedFile($_team->image, "team");
                $_team_image = Helper::uploadFile(file: $request->team_image, file_folder_name: "team", width: 300, height: 300);
            } else {
                $_team_image = $_team->image;
            }
            return $this->teamRepository->update($_team, [
                'name' => $data['name'],
                'designation_id' => $data['designation_id'],
                'image' => $_team_image,
                'slug' => Helper::getSlugSimple($data['name']),
                'description' => $data['description'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteTeam($team_id)
    {
        $_team = $this->teamRepository->find($team_id);
        if ($_team) {
            Helper::unlinkUploadedFile($_team->image, "team");
            return $this->teamRepository->delete($_team);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->teamRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($team_id): array
    {
        $_team = $this->teamRepository->find($team_id);
        if ($_team) {
            $this->teamRepository->update($_team, ['status' => (($_team->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @throws SMException
     */
    public function changeFeaturedStatus($team_id): array
    {
        $_team = $this->teamRepository->find($team_id);
        if ($_team) {
            $this->teamRepository->update($_team, ['is_featured' => (($_team->is_featured) ? 0 : 1)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


    public function featuredTeamList(): AnonymousResourceCollection
    {
        $_team = $this->teamRepository->getFeatureTeamList();
        return TeamResource::collection($_team);
    }

    public function getActiveTeamList(): AnonymousResourceCollection
    {
        $_team = $this->teamRepository->getActiveTeamList();
        return TeamResource::collection($_team);
    }

    /**
     * @throws SMException
     */
    public function getTeamDetail($slug): array
    {
        $_team = $this->teamRepository->getActiveTeamBySlug($slug);
        if ($_team) {
            return [
                'name' => $_team->name,
                'slug' => $_team->slug,
                'image_path' => $_team->image_path,
                'designation_name' => $_team->designation_name,
                'description' => $_team->description,
            ];
        }
        throw new SMException($this->notFoundMessage);
    }


}
