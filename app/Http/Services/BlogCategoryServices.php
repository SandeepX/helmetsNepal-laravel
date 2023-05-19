<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\BlogCategoryRepository;
use App\Http\Resources\BlogCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class BlogCategoryServices
{
    private string $notFoundMessage = "Sorry! Blog Category not found";
    private BlogCategoryRepository $blogCategoryRepository;


    public function __construct()
    {
        $this->blogCategoryRepository = new BlogCategoryRepository();
    }

    public function getList()
    {
        return $this->blogCategoryRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveBlogCategory($request): void
    {
        $data = $request->all();
        $this->blogCategoryRepository->save([
            'name' => $data['name'],
            'is_feature' => EStatus::inactive,
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getBlogCategory($blogCategory_id)
    {
        $_blogCategory = $this->blogCategoryRepository->find($blogCategory_id);
        if ($_blogCategory) {
            return $_blogCategory;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateBlogCategory($blogCategory_id, $request)
    {
        $data = $request->all();
        $_blogCategory = $this->blogCategoryRepository->find($blogCategory_id);
        if ($_blogCategory) {
            return $this->blogCategoryRepository->update($_blogCategory, [
                'name' => $data['name'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteBlogCategory($blogCategory_id)
    {
        $_blogCategory = $this->blogCategoryRepository->find($blogCategory_id);
        if ($_blogCategory) {
            $this->blogCategoryRepository->update($_blogCategory, [
                'name' => $_blogCategory->name. "-(".Helper::smTodayInYmdHis().")",
            ]);
            return $this->blogCategoryRepository->delete($_blogCategory);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->blogCategoryRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_blogCategory = $this->blogCategoryRepository->find($user_id);
        if ($_blogCategory) {
            $this->blogCategoryRepository->update($_blogCategory, ['status' => (($_blogCategory->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getBlogCategoryList(): AnonymousResourceCollection
    {
        $_blogCategory = $this->blogCategoryRepository->getActiveList();
        return BlogCategoryResource::collection($_blogCategory);
    }


}
