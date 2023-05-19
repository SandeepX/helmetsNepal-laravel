<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\FaqCategoryRepository;
use App\Http\Resources\FaqCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class FaqCategoryServices
{
    private string $notFoundMessage = "Sorry! Faq Category not found";

    public function __construct()
    {
        $this->faqCategoryRepository = new FaqCategoryRepository();
    }

    public function getList()
    {
        return $this->faqCategoryRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveFaqCategory($request): void
    {
        $data = $request->all();
        $this->faqCategoryRepository->save([
            'name' => $data['name'],
            'icons' => $data['icons'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getFaqCategory($faqCategory_id)
    {
        $_faqCategory = $this->faqCategoryRepository->find($faqCategory_id);
        if ($_faqCategory) {
            return $_faqCategory;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateFaqCategory($faqCategory_id, $request)
    {
        $data = $request->all();
        $_faqCategory = $this->faqCategoryRepository->find($faqCategory_id);
        if ($_faqCategory) {
            return $this->faqCategoryRepository->update($_faqCategory, [
                'name' => $data['name'],
                'icons' => $data['icons'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteFaqCategory($faqCategory_id)
    {
        $_faqCategory = $this->faqCategoryRepository->find($faqCategory_id);
        if ($_faqCategory) {
            $this->faqCategoryRepository->update($_faqCategory, [
                'name' =>$_faqCategory->name. "-(".Helper::smTodayInYmdHis().")",
            ]);
            return $this->faqCategoryRepository->delete($_faqCategory);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->faqCategoryRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_faqCategory = $this->faqCategoryRepository->find($user_id);
        if ($_faqCategory) {
            $this->faqCategoryRepository->update($_faqCategory, ['status' => (($_faqCategory->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getFaqCategoryList(): AnonymousResourceCollection
    {
        $_faqCategory = $this->faqCategoryRepository->getActiveList();
        return FaqCategoryResource::collection($_faqCategory);
    }


}
