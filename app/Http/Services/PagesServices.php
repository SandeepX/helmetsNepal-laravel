<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\PagesRepository;
use App\Http\Resources\PagesNameResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class PagesServices
{
    private string $notFoundMessage = "Sorry! Pages not found";
    private PagesRepository $pagesRepository;


    public function __construct()
    {
        $this->pagesRepository = new PagesRepository();
    }

    public function getList()
    {
        return $this->pagesRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function savePages($request): void
    {
        $data = $request->all();
        $this->pagesRepository->save([
            'title' => $data['title'],
            'slug' => Helper::getSlugSimple($data['title']),
            'details' => $data['details'],
            'meta_title' => $data['meta_title'],
            'meta_keys' => $data['meta_keys'],
            'meta_description' => $data['meta_description'],
            'alternate_text' => $data['alternate_text'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getPages($pages_id)
    {
        $_pages = $this->pagesRepository->find($pages_id);
        if ($_pages) {
            return $_pages;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updatePages($pages_id, $request)
    {
        $data = $request->all();
        $_pages = $this->pagesRepository->find($pages_id);
        if ($_pages) {
            return $this->pagesRepository->update($_pages, [
                'title' => $data['title'],
                'slug' => Helper::getSlugSimple($data['title']),
                'details' => $data['details'],
                'meta_title' => $data['meta_title'],
                'meta_keys' => $data['meta_keys'],
                'meta_description' => $data['meta_description'],
                'alternate_text' => $data['alternate_text'],
                'status' => EStatus::active,
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deletePages($pages_id)
    {
        $_pages = $this->pagesRepository->find($pages_id);
        if ($_pages) {
            $this->pagesRepository->update($_pages, [
                'title' => $_pages->title. "-(".Helper::smTodayInYmdHis().")",
            ]);
            return $this->pagesRepository->delete($_pages);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->pagesRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_pages = $this->pagesRepository->find($user_id);
        if ($_pages) {
            $this->pagesRepository->update($_pages, ['status' => (($_pages->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getCommonPagesNames(): AnonymousResourceCollection
    {
        $_pages = $this->pagesRepository->getPageNameList();
        return PagesNameResource::collection($_pages);
    }

    /**
     * @throws SMException
     */
    public function getPageDetailsBySlug($slug)
    {
        $_pages = $this->pagesRepository->getPageBySlug($slug);
        if ($_pages) {
            return $_pages->toArray();
        }
        throw new SMException($this->notFoundMessage);
    }


}
