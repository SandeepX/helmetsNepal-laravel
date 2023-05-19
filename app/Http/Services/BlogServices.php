<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\BlogRepository;
use App\Http\Resources\BlogResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class BlogServices
{
    private string $notFoundMessage = "Sorry! Blog  not found";
    private BlogRepository $blogRepository;


    public function __construct()
    {
        $this->blogRepository = new BlogRepository();
    }

    public function getList()
    {
        return $this->blogRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveBlog($request): void
    {
        $data = $request->all();
        if ($request->hasFile('blog_image')) {
            $_blog_image = Helper::uploadFile(file: $request->blog_image, file_folder_name: "blog", width: 1362, height: 911);
        } else {
            throw new SMException("Blog  image not found");
        }

        if ($request->hasFile('blog_creator_image')) {
            $_blog_creator_image = Helper::uploadFile(file: $request->blog_creator_image, file_folder_name: "blog", width: 134, height: 134);
        } else {
            throw new SMException("Blog creator image not found");
        }
        $this->blogRepository->save([
            'title' => $data['title'],
            'blog_image' => $_blog_image,
            'description' => $data['description'],
            'blog_created_by' => $data['blog_created_by'],
            'blog_creator_image' => $_blog_creator_image,
            'blog_publish_date' => $data['blog_publish_date'],
            'blog_read_time' => $data['blog_read_time'],
            'blog_category_id' => $data['blog_category_id'],
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getBlog($blog_id)
    {
        $_blog = $this->blogRepository->find($blog_id);
        if ($_blog) {
            return $_blog;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateBlog($blog_id, $request)
    {
        $data = $request->all();
        $_blog = $this->blogRepository->find($blog_id);
        if ($_blog) {

            $_blog_image = $_blog->blog_image;
            $_blog_creator_image = $_blog->blog_creator_image;
            if ($request->hasFile('blog_image')) {
                Helper::unlinkUploadedFile($_blog->blog_image, "blog");
                $_blog_image = Helper::uploadFile(file: $request->blog_image, file_folder_name: "blog", width: 1362, height: 911);
            }

            if ($request->hasFile('blog_creator_image')) {
                Helper::unlinkUploadedFile($_blog->blog_creator_image, "blog");
                $_blog_creator_image = Helper::uploadFile(file: $request->blog_creator_image, file_folder_name: "blog", width: 134, height: 134);
            }
            return $this->blogRepository->update($_blog, [
                'title' => $data['title'],
                'blog_image' => $_blog_image,
                'description' => $data['description'],
                'blog_created_by' => $data['blog_created_by'],
                'blog_creator_image' => $_blog_creator_image,
                'blog_publish_date' => $data['blog_publish_date'],
                'blog_read_time' => $data['blog_read_time'],
                'blog_category_id' => $data['blog_category_id'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteBlog($blog_id)
    {
        $_blog = $this->blogRepository->find($blog_id);
        if ($_blog) {
            return $this->blogRepository->delete($_blog);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->blogRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($blog_id): array
    {
        $_blog = $this->blogRepository->find($blog_id);
        if ($_blog) {
            $this->blogRepository->update($_blog, ['status' => (($_blog->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function changeFeaturedStatus($blog_id): array
    {
        $_blog = $this->blogRepository->find($blog_id);
        if ($_blog) {
            $this->blogRepository->update($_blog, ['is_featured' => (($_blog->is_featured) ? 0 : 1)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getFeatureBlog(): AnonymousResourceCollection
    {
        $_blog = $this->blogRepository->getFeatureBlog();
        return BlogResource::collection($_blog);
    }

    public function getBlogList($request)
    {

        $per_page = 10;
        if ($request->has('per_page')) {
            $per_page = $request->per_page;
        }
        $_blog = $this->blogRepository->getActiveBlogPaginate($per_page);

        $page_details = $_blog->toArray();
        unset($page_details['data']);
        return [
            'page_details' => $page_details,
            'blog' => BlogResource::collection($_blog),
        ];
    }

    public function getBlogByCategoryID($blog_category_id, $request)
    {

        $per_page = 10;
        if ($request->has('per_page')) {
            $per_page = $request->per_page;
        }
        $_blog = $this->blogRepository->getBlogByCategoryID($blog_category_id, $per_page);
        $page_details = $_blog->toArray();
        unset($page_details['data']);
        return [
            'page_details' => $page_details,
            'blog' => BlogResource::collection($_blog),
        ];
    }

    public function getBlogDetail($blog_id): JsonResponse
    {
        $_blog = $this->blogRepository->getBlogDetail($blog_id);
        $_related_blog = $this->blogRepository->getRelatedBlogByCategoryID(blog_category_id: $_blog['blog_category_id'], blog_id: $blog_id);
        return Helper::successResponseAPI('Success', ['blog' => $_blog, 'related_blog' => BlogResource::collection($_related_blog)]);
    }


}
