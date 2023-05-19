<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Http\Enums\EStatus;
use App\Http\Repositories\FaqCategoryRepository;
use App\Http\Repositories\FaqRepository;
use App\Http\Resources\FaqCategoryResource;
use App\Http\Resources\FaqResource;
use JetBrains\PhpStorm\ArrayShape;

class FaqServices
{
    private string $notFoundMessage = "Sorry! Faq  not found";
    private FaqRepository $faqRepository;


    public function __construct()
    {
        $this->faqRepository = new FaqRepository();
        $this->faqCategoryRepository = new FaqCategoryRepository();
    }

    public function getList()
    {
        return $this->faqRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveFaq($request): void
    {
        $data = $request->all();
        $this->faqRepository->save([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'faq_category_id' => $data['faq_category_id'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getFaq($faq_id)
    {
        $_faq = $this->faqRepository->find($faq_id);
        if ($_faq) {
            return $_faq;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateFaq($faq_id, $request)
    {
        $data = $request->all();
        $_faq = $this->faqRepository->find($faq_id);
        if ($_faq) {
            return $this->faqRepository->update($_faq, [
                'question' => $data['question'],
                'answer' => $data['answer'],
                'faq_category_id' => $data['faq_category_id']
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteFaq($faq_id)
    {
        $_faq = $this->faqRepository->find($faq_id);
        if ($_faq) {
            return $this->faqRepository->delete($_faq);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->faqRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_faq = $this->faqRepository->find($user_id);
        if ($_faq) {
            $this->faqRepository->update($_faq, ['status' => (($_faq->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getFaqList(): array
    {
        $_faqCategory = $this->faqCategoryRepository->getActiveList();
        $return_array = [];
        foreach ($_faqCategory as $faqCategory) {
            $faqs = $this->faqRepository->getRelatedFaqByCategoryID($faqCategory->id);
            $return_array[] = [
                'id' => $faqCategory->id,
                'category' => $faqCategory->name,
                'qna' => FaqResource::collection($faqs)
            ];
        }
        return [
            'faqsCategories' => FaqCategoryResource::collection($_faqCategory),
            'faqsData' => $return_array
        ];
    }


}
