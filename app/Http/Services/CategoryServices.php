<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\CategoryRepository;
use App\Http\Resources\ChildCategoryResource;
use JetBrains\PhpStorm\ArrayShape;

class CategoryServices
{
    private string $notFoundMessage = "Sorry! Category not found";
    private CategoryRepository $categoryRepository;


    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function getList()
    {
        return $this->categoryRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveCategory($request): void
    {
        $data = $request->all();
        if ($data['parent_id']) {
            $parent_id = $data['parent_id'];
        }
        $_category_image = "";
        if ($request->hasFile('category_image')) {
            $_category_image = Helper::uploadFile(file: $request->category_image, file_folder_name: "category", width: 207, height: 180);
        }
        $this->categoryRepository->save([
            'name' => $data['name'],
            'image' => $_category_image,
            'slug' => Helper::getSlug($data['name']),
            'parent_id' => $parent_id ?? null,
            'status' => EStatus::active,
        ]);

    }

    /**
     * @throws SMException
     */

    #[ArrayShape(['category' => "mixed", 'parent_category_id' => "mixed", 'subParentCategory_id' => "mixed", 'subCategory_list' => "array|mixed"])]
    public function getCategoryWithDetails($category_id): array
    {
        $_category = $this->categoryRepository->find($category_id);
        if ($_category) {
            $parent_category = $_category->getParentCategory;
            if ($parent_category) {
                $parent_category_id = $parent_category->id;
            }
            return [
                'category' => $_category,
                'parent_category_id' => $parent_category_id ?? null,
            ];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateCategory($category_id, $request)
    {
        $data = $request->all();
        $_category = $this->categoryRepository->find($category_id);
        if ($_category) {
            if ($data['parent_id'] ?? '') {
                $parent_id = $data['parent_id'];
            }
            $_category_image = $_category->image;
            if ($request->hasFile('category_image')) {
                if ($_category_image) {
                    Helper::unlinkUploadedFile($_category->image, "category");
                }
                $_category_image = Helper::uploadFile(file: $request->category_image, file_folder_name: "category", width: 207, height: 180);
            }
            if($_category->name == $data['name']){
                return $this->categoryRepository->update($_category, [
                    'name' => $data['name'],
                    'image' => $_category_image,
                    'parent_id' => $parent_id ?? null,
                ]);
            }
            return $this->categoryRepository->update($_category, [
                'name' => $data['name'],
                'image' => $_category_image,
                'slug' => Helper::getSlug($data['name']),
                'parent_id' => $parent_id ?? null,
            ]);

        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteCategory($category_id)
    {
        $_category = $this->categoryRepository->find($category_id);
        if ($_category) {
            Helper::unlinkUploadedFile($_category->image, "category");
            return $this->categoryRepository->delete($_category);
        }
        throw new SMException($this->notFoundMessage);
    }


    public function getSelectList()
    {
        return $this->categoryRepository->getSelectList();
    }

    public function getSelectSubCatList()
    {
        return $this->categoryRepository->getSelectSubCatList();
    }

    public function getParentCategoryList()
    {
        return $this->categoryRepository->getParentCategorySlugList();
    }

    public function getChildCategory($parent_id)
    {
        $_cat = $this->categoryRepository->find($parent_id);
        if ($_cat) {
            return $this->categoryRepository->getChildCategory($_cat->id);
        }
        return [];
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_cat = $this->categoryRepository->find($user_id);
        if ($_cat) {
            $this->categoryRepository->update($_cat, ['status' => (($_cat->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }


    public function getParentChildCategoryList()
    {
        $_cat_parent_array = [];
        $_cat_parents = $this->categoryRepository->getActiveParentCategoryList_2();


        foreach ($_cat_parents as $_cat_parent) {
            $child_category = $this->categoryRepository->getActiveChildCategoryList_2($_cat_parent->id);
            ChildCategoryResource::collection($child_category);
            $_push_array = [
                'name' => $_cat_parent->name,
                'slug' => $_cat_parent->slug,
                'image_path' => $_cat_parent->image_path,
                'child_category' => ChildCategoryResource::collection($child_category),
            ];
            $_cat_parent_array[] = $_push_array;

        }
        return $_cat_parent_array;

    }


}
