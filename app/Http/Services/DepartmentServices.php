<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\DepartmentRepository;
use App\Http\Resources\DepartmentResources;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class DepartmentServices
{
    private string $notFoundMessage = "Sorry! Department not found";


    public function __construct()
    {
        $this->departmentRepository = new DepartmentRepository();
    }

    public function getList()
    {
        return $this->departmentRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveDepartment($request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $_image = Helper::uploadFile(file: $request->image, file_folder_name: "department");
        } else {
            throw new SMException("Department  image not found");
        }
        return $this->departmentRepository->save([
            'title' => $data['title'],
            'image' => $_image,
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getDepartment($department_id)
    {
        $_department = $this->departmentRepository->find($department_id);
        if ($_department) {
            return $_department;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateDepartment($department_id, $request)
    {
        $data = $request->all();
        $_department = $this->departmentRepository->find($department_id);
        if ($_department) {
            $_image = $_department->image;
            if ($request->hasFile('image')) {
                Helper::unlinkUploadedFile($_department->image, "department");
                $_image = Helper::uploadFile(file: $request->image, file_folder_name: "department");
            }
            return $this->departmentRepository->update($_department, [
                'title' => $data['title'],
                'image' => $_image,
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteDepartment($department_id)
    {
        $_department = $this->departmentRepository->find($department_id);
        if ($_department) {
            $this->departmentRepository->update($_department, [
                'title' => $_department->title. "-(".Helper::smTodayInYmdHis().")",
            ]);
            Helper::unlinkUploadedFile($_department->image, "department");
            return $this->departmentRepository->delete($_department);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->departmentRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_department = $this->departmentRepository->find($user_id);
        if ($_department) {
            $this->departmentRepository->update($_department, ['status' => (($_department->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


    public function getCareerDepartmentList(): AnonymousResourceCollection
    {
        $_department = $this->departmentRepository->getActiveDepartment();
        return DepartmentResources::collection($_department);
    }


}
