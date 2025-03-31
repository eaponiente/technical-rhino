<?php

namespace App\Models;

use Database\Factories\MediaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'description', 'type', 'author'];

    protected static function newFactory()
    {
        return MediaFactory::new();
    }

    public function authors()
    {
        return $this->morphToMany(Author::class, 'authorable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'media_tag', 'media_id', 'tag_id');
    }
}
