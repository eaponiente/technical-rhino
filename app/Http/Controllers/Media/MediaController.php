<?php

namespace App\Http\Controllers\Media;

use App\Actions\Media\CreateMediaAction;
use App\Actions\Media\DeleteMediaAction;
use App\Actions\Media\GetMediaAction;
use App\Actions\Media\UpdateMediaAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateMediaRequest;
use App\Http\Requests\Media\DeleteMediaRequest;
use App\Http\Requests\Media\GetMediaRequest;
use App\Http\Requests\Media\UpdateMediaRequest;
use App\Http\Resources\GetMediaResource;
use App\Models\Media;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetMediaRequest $request, GetMediaAction $action)
    {
        return Inertia::render('media/Index', [
            'medias' => GetMediaResource::collection($action->execute($request->validated())),
            'success' => $request->session()->has('success'),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('media/Form', [
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMediaRequest $request, CreateMediaAction $action)
    {
        $data = $request->validated();

        $action->execute($data);

        return to_route('media.index')->with('success', __('messages.create.success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $media = Media::with('tags')->find($id);

        if( ! $media) {
            return to_route('media.index');
        }

        return Inertia::render('media/Form', [
            'tags' => Tag::all(),
            'media' => $media,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, int $id, UpdateMediaAction $action)
    {
        $data = $request->validated();

        $media = Media::find($id);

        if( ! $media) {
            return response()->json([
                'message' => 'Media not found.',
            ], 404);
        }

        $action->execute($media, $data);

        return to_route('media.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteMediaRequest $request, string $id, DeleteMediaAction $action)
    {
        $media = Media::find($id);

        if( ! $media) {
            return response()->json([
                'message' => 'Media not found.',
            ], 404);
        }

        $action->execute($media);

        return to_route('media.index');
    }
}
