<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YoutubeSlidingContentResource extends JsonResource
{
    public function toArray($request): array
    {
        $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        preg_match($pattern, $this->youtube_link, $matches);
        $video_id = (isset($matches[1])) ? $matches[1] : false;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_path' => $this->image_path,
            'youtube_link' => $video_id,
        ];
    }
}
