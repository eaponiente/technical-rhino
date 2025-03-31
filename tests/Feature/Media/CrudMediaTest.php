<?php

use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a successful Inertia response with media data', function () {
    // Create some media records
    Media::factory()->count(3)->create();

    $response = $this->get(route('media.index'));

    // Check the response status and Inertia props
    $response->assertStatus(200)
        ->assertInertia(function ($page) {
            $page->component('media/Index') // Ensure the correct component is rendered
            ->has('medias', 3);
        });
});

it('renders the correct Inertia component', function () {
    // GET request to the endpoint
    $response = $this->get(route('media.create'));

    // Ensure the correct component is rendered
    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page->component('media/Form'));
});

it('fails validation when type is invalid', function () {
    // Simulate a request with an invalid type
    $invalidData = [
        'title' => 'Test Media',
        'description' => 'This is a test media description.',
        'author' => 'John Doe',
        'type' => 'invalid_type', // Invalid type
        'tags' => [1],
    ];

    // Make a POST request and expect validation errors
    $this->post(route('media.store'), $invalidData)
        ->assertStatus(302)
        ->assertSessionHasErrors(['type']);
});

it('fails validation when tags is not an array', function () {
    // Simulate a request with non-array tags
    $invalidData = [
        'title' => 'Test Media',
        'description' => 'This is a test media description.',
        'author' => 'John Doe',
        'type' => 'book',
        'tags' => 'not_an_array', // Invalid tags format
    ];

    // Make a POST request and expect validation errors
    $this->post(route('media.store'), $invalidData)
        ->assertStatus(302)
        ->assertSessionHasErrors(['tags']);
});

it('fails validation when tags contain non-existent IDs', function () {
    // Simulate a request with non-existent tag IDs
    $nonExistentTagId = 999; // Assume this ID does not exist in the database
    $invalidData = [
        'title' => 'Test Media',
        'description' => 'This is a test media description.',
        'author' => 'John Doe',
        'type' => 'book',
        'tags' => [$nonExistentTagId],
    ];

    // Make a POST request and expect validation errors
    $this->post(route('media.store'), $invalidData)
        ->assertStatus(302)
        ->assertSessionHasErrors(['tags.0']); // Error for the first tag
});


it('deletes an existing media item and redirects to the media index page', function () {
    $media = Media::factory()->create();

    // Make a DELETE request to delete the media item
    $response = $this->delete(route('media.destroy', ['media' => $media->id]));

    // Check redirection and database state
    $response->assertRedirect(route('media.index')); // Ensure redirection
    $this->assertDatabaseMissing('media', ['id' => $media->id]); // Ensure media is deleted
});
