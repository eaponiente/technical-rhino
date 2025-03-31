<?php

namespace App\Actions\Media;

use App\Models\Media;

class DeleteMediaAction
{
    public function execute(Media $media)
    {
        $media->delete();
    }
}
