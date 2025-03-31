<?php

namespace App\Actions\Media;

use App\Models\Media;

class UpdateMediaAction
{
    public function execute(Media $media, array $data): Media
    {
        $media->update($data);

        $media->tags()->sync($data['tags']);

        return $media->fresh();
    }
}
