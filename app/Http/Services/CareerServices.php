<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ApplicationRepository;
use App\Http\Repositories\CareerRepository;
use App\Http\Resources\CareerResources;
use App\Models\Career\Career;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;

class CareerServices
{
    private string $notFoundMessage = "Sorry! Career  not found";
    private CareerRepository $careerRepository;
    private ApplicationRepository $applicationRepository;

    public function __construct()
    {
        $this->careerRepository  = new CareerRepository();
        $this->applicationRepository = new ApplicationRepository();
    }

    public function getList()
    {
        return $this->careerRepository ->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveCareer($request): void
    {
        $data = $request->all();
        $this->careerRepository ->save([
            'title' => $data['title'],
            'salary_details' => $data['salary_details'],
            'description' => $data['description'],
            'department_id' => $data['department_id'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function updateCareer($Career_id, $request)
    {
        $data = $request->all();
        $_Career = $this->careerRepository ->find($Career_id);
        if ($_Career) {
            return $this->careerRepository ->update($_Career, [
                'title' => $data['title'],
                'salary_details' => $data['salary_details'],
                'description' => $data['description'],
                'department_id' => $data['department_id'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteCareer($Career_id)
    {
        $_Career = $this->careerRepository ->find($Career_id);
        if ($_Career) {
            return $this->careerRepository ->delete($_Career);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->careerRepository ->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($Career_id): array
    {
        $_Career = $this->careerRepository ->find($Career_id);
        if ($_Career) {
            $this->careerRepository ->update($_Career, ['status' => (($_Career->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getCareerByDepartmentList($department_id): AnonymousResourceCollection
    {
        $_career = $this->careerRepository ->getCareerByDepartment($department_id);
        return CareerResources::collection($_career);
    }

    public function getCareerDetail($career_id): Career
    {
        return $this->careerRepository ->getCareer($career_id);
    }

    /**
     * @throws SMException
     */
    public function getCareer($Career_id)
    {
        $_career = $this->careerRepository ->find($Career_id);
        if ($_career) {
            return $_career;
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @param $request
     * @return JsonResponse
     */
    public function saveApplicationDetail($request): JsonResponse
    {
        $validator_register = $this->checkApplicationValidation($request);
        if ($validator_register->fails()) {
            $validation_error = [];
            if ($validator_register->errors()->has('email')) {
                $validation_error['error']['email'] = $validator_register->errors()->first('email');
            }
            if ($validator_register->errors()->has('name')) {
                $validation_error['error']['name'] = $validator_register->errors()->first('name');
            }
            if ($validator_register->errors()->has('cv_file')) {
                $validation_error['error']['cv_file'] = $validator_register->errors()->first('cv_file');
            }
            if ($validator_register->errors()->has('career_id')) {
                $validation_error['error']['career_id'] = $validator_register->errors()->first('career_id');
            }
            return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
        }

        if ($request->hasFile('cv_file')) {
            $cv_file = Helper::uploadFile(file: $request->cv_file, file_folder_name: "applications");
        } else {
            return Helper::errorResponseAPI(message: "CV File not found");
        }
        $data = $request->all();

        $_application_resp = $this->applicationRepository->save([
            'name' => $data['name'],
            'email' => $data['email'],
            'cv_file' => $cv_file,
            'career_id' => $data['career_id'],
        ]);
        if ($_application_resp) {
            return Helper::successResponseAPI(message: "Submit Successful");
        }
        return Helper::errorResponseAPI(message: "Please Try Again");

    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function checkApplicationValidation($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'career_id' => 'required',
            'email' => 'required|email',
            'name' => 'required|max:255|min:6',
            'cv_file' => 'required|file|max:10000',
        ], [
                'email.required' => 'Email is required',
                'name.required' => 'Password field is required.',
            ]
        );
    }
    public function listApplication(): mixed
    {
        return $this->applicationRepository->findALl();
    }


}
