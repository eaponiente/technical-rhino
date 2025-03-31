<?php

namespace App\Actions\Media;

use App\Models\Media;

class CreateMediaAction
{
    public function execute(array $data): Media
    {
        $media = Media::create($data);

        $media->tags()->sync($data['tags']);

        return $media;
    }
}
