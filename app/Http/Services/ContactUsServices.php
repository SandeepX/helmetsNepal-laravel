<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ContactUsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;

class ContactUsServices
{
    private string $notFoundMessage = "Sorry! Contact Us not found";
    private string $error_message = "Oops! Something went wrong.";
    private ContactUsRepository $contactUsRepository;


    public function __construct()
    {
        $this->contactUsRepository = new ContactUsRepository();
    }

    public function getList()
    {
        return $this->contactUsRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveContactUs($request): JsonResponse
    {
        $data = $request->all();

        $validator_register = $this->checkMessageValidation($request);

        if ($validator_register->fails()) {
            $validation_error = [];
            if ($validator_register->errors()->has('first_name')) {
                $validation_error['error']['first_name'] = $validator_register->errors()->first('first_name');
            }
            if ($validator_register->errors()->has('last_name')) {
                $validation_error['error']['last_name'] = $validator_register->errors()->first('last_name');
            }
            if ($validator_register->errors()->has('email')) {
                $validation_error['error']['email'] = $validator_register->errors()->first('email');
            }
            if ($validator_register->errors()->has('phone')) {
                $validation_error['error']['phone'] = $validator_register->errors()->first('phone');
            }
            if ($validator_register->errors()->has('message')) {
                $validation_error['error']['message'] = $validator_register->errors()->first('message');
            }

            return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
        }
        $message = $this->contactUsRepository->save([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],
            'status' => EStatus::inactive,
        ]);

        if ($message) {
            return Helper::successResponseAPI(message: "Message Sent");
        }
        return Helper::errorResponseAPI(message: $this->error_message);
    }


    private function checkMessageValidation($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|email|max:50',
            'phone' => 'required|digits:10',
            'message' => 'required|string|between:8,2000',
        ]);
    }


    /**
     * @throws SMException
     */
    public function getContactUs($contactUs_id)
    {
        $_contactUs = $this->contactUsRepository->find($contactUs_id);
        if ($_contactUs) {
            return $_contactUs;
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @throws SMException
     */
    public function deleteContactUs($contactUs_id)
    {
        $_contactUs = $this->contactUsRepository->find($contactUs_id);
        if ($_contactUs) {
            return $this->contactUsRepository->delete($_contactUs);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_contactUs = $this->contactUsRepository->find($user_id);
        if ($_contactUs) {
            $this->contactUsRepository->update($_contactUs, ['status' => (($_contactUs->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


}
