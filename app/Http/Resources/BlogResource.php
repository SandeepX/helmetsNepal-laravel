<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'blog_id' => $this->blog_id,
            'title' => $this->title,
            'blog_image_path' => (($this->blog_image) ? $this->blog_image_path : ""),
            'blog_created_by' => $this->blog_created_by,
            'blog_creator_image_path' => (($this->blog_creator_image) ? $this->blog_creator_image_path : ""),
            'blog_publish_date' => $this->blog_publish_date,
            'blog_read_time' => $this->blog_read_time,
            'blog_category_name' => $this->blog_category_name,
        ];
    }
}
