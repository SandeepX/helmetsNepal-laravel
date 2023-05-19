<?php

namespace App\Http\Services;

use App\Events\SubscribeBySendInBlue;
use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\NewsLetterSubscriptionRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;

class NewsLetterSubscriptionServices
{
    private string $notFoundMessage = "Sorry! NewsLetter Subscription not found";
    private NewsLetterSubscriptionRepository $newsLetterSubscriptionRepository;


    public function __construct()
    {
        $this->newsLetterSubscriptionRepository = new NewsLetterSubscriptionRepository();
    }

    public function getList()
    {
        return $this->newsLetterSubscriptionRepository->findALl();
    }

    public function saveNewsLetterSubscription($request): JsonResponse
    {
        try{
            $validator_register = $this->checkNewsLetterSubscriptionValidation($request);
            if ($validator_register->fails()) {
                $validation_error = [];
                if ($validator_register->errors()->has('email')) {
                    $validation_error['error']['email'] = $validator_register->errors()->first('email');
                }
                return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
            }
            DB::beginTransaction();
            $this->newsLetterSubscriptionRepository->save([
                'email' => $request->email,
                'status' => EStatus::active,
            ]);
            event(new SubscribeBySendInBlue($request->email));
            DB::commit();
            return Helper::successResponseAPI('NewsLetter Subscription Saved');
        }catch(Exception $ex){
            DB::rollBack();
            throw $ex;
        }

    }

    private function checkNewsLetterSubscriptionValidation($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'email' => 'required|email|unique:news_letter_subscriptions|max:50',
        ]);
    }

    /**
     * @throws SMException
     */
    public function getNewsLetterSubscription($manufacture_id)
    {
        $_manufacture = $this->newsLetterSubscriptionRepository->find($manufacture_id);
        if ($_manufacture) {
            return $_manufacture;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteNewsLetterSubscription($manufacture_id)
    {
        $_manufacture = $this->newsLetterSubscriptionRepository->find($manufacture_id);
        if ($_manufacture) {
            return $this->newsLetterSubscriptionRepository->delete($_manufacture);
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_manufacture = $this->newsLetterSubscriptionRepository->find($user_id);
        if ($_manufacture) {
            $this->newsLetterSubscriptionRepository->update($_manufacture, ['status' => (($_manufacture->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }





}
