<?php

namespace App\Actions\Media;

use App\Models\Media;

class GetMediaAction
{
    public function execute(array $data)
    {
        return Media::query()
            ->with('tags')
            ->paginate($data['limit'] ?? 10);
    }
}
