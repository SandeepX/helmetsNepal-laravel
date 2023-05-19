<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Http\Enums\EStatus;
use App\Http\Repositories\RoleRepository;
use JetBrains\PhpStorm\ArrayShape;

class RoleServices
{
    private string $notFoundMessage = "Sorry! Role not found";


    public function __construct()
    {
        $this->roleRepository = new RoleRepository();
    }

    public function getList()
    {
        return $this->roleRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveRole($request)
    {
        $data = $request->all();
        return $this->roleRepository->save([
            'name' => $data['name'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getRole($role_id)
    {
        $_role = $this->roleRepository->find($role_id);
        if ($_role) {
            return $_role;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateRole($role_id, $request)
    {
        $data = $request->all();
        $_role = $this->roleRepository->find($role_id);
        if ($_role) {
            return $this->roleRepository->update($_role, $data);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteRole($role_id)
    {
        $_role = $this->roleRepository->find($role_id);
        if ($_role) {
            return $this->roleRepository->delete($_role);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_role = $this->roleRepository->find($user_id);
        if ($_role) {
            $this->roleRepository->update($_role, ['status' => (($_role->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
