<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function index_displays_all_posts()
    {
        $posts = Post::factory()->count(3)->create();

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts');
        
        foreach ($posts as $post) {
            $response->assertSeeText($post->title);
            $response->assertSeeText($post->excerpt);
        }
    }

    /** @test */
    public function index_shows_empty_state_when_no_posts()
    {
        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertViewHas('posts');
        $this->assertCount(0, $response->viewData('posts'));
    }

    /** @test */
    public function show_displays_single_post_by_slug()
    {
        $post = Post::factory()->create([
            'title' => 'Test Post Title',
            'slug' => 'test-post-slug',
            'content' => 'This is test content',
            'excerpt' => 'This is test excerpt'
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
        $response->assertSeeText($post->title);
        $response->assertSeeText($post->content);
    }

    /** @test */
    public function show_returns_404_for_nonexistent_slug()
    {
        $response = $this->get(route('posts.show', 'nonexistent-slug'));

        $response->assertStatus(404);
    }

    /** @test */
    public function create_displays_form()
    {
        $response = $this->get(route('posts.create'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
        $response->assertSeeText('New Post');
    }

    /** @test */
    public function store_creates_new_post_with_valid_data()
    {
        $file = UploadedFile::fake()->image('test-image.jpg', 600, 400);
        
        $postData = [
            'title' => 'New Test Post',
            'slug' => 'new-test-post',
            'content' => 'This is the content of the new post.',
            'excerpt' => 'This is the excerpt.',
            'image' => $file,
            'published_at' => '2025-05-25'
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post created successfully.');

        $this->assertDatabaseHas('post', [
            'title' => 'New Test Post',
            'slug' => 'new-test-post',
            'content' => 'This is the content of the new post.',
            'excerpt' => 'This is the excerpt.',
        ]);

        Storage::disk('public')->assertExists('images/' . $file->hashName());
    }

    /** @test */
    public function store_uses_current_date_when_published_at_is_empty()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        
        $postData = [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'image' => $file,
            'published_at' => '' // empty
        ];

        $this->post(route('posts.store'), $postData);

        $post = Post::where('slug', 'test-post')->first();
        $this->assertNotNull($post->published_at);
        $this->assertEquals(now()->toDateString(), $post->published_at->toDateString());
    }

    /** @test */
    public function store_fails_with_invalid_data()
    {
        $response = $this->post(route('posts.store'), []);

        $response->assertSessionHasErrors(['title', 'slug', 'content', 'excerpt', 'image']);
        $this->assertDatabaseCount('post', 0);
    }

    /** @test */
    public function store_fails_with_duplicate_slug()
    {
        Post::factory()->create(['slug' => 'duplicate-slug']);
        
        $file = UploadedFile::fake()->image('test.jpg');
        
        $response = $this->post(route('posts.store'), [
            'title' => 'Test',
            'slug' => 'duplicate-slug',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'image' => $file
        ]);

        $response->assertSessionHasErrors(['slug']);
    }

    /** @test */
    public function edit_displays_form_with_existing_post()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.edit', $post->slug));

        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
        $response->assertViewHas('post', $post);
        $response->assertSeeText('Edit Post');
    }

    /** @test */
    public function edit_returns_404_for_nonexistent_post()
    {
        $response = $this->get(route('posts.edit', 'nonexistent'));

        $response->assertStatus(404);
    }

    /** @test */
    public function update_modifies_existing_post()
    {
        $post = Post::factory()->create([
            'title' => 'Original Title',
            'slug' => 'original-slug'
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'slug' => 'updated-slug',
            'content' => 'Updated content',
            'excerpt' => 'Updated excerpt',
            'published_at' => '2025-06-01'
        ];

        $response = $this->patch(route('posts.update', $post->slug), $updateData);

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post updated successfully.');

        $this->assertDatabaseHas('post', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'slug' => 'updated-slug',
            'content' => 'Updated content',
            'excerpt' => 'Updated excerpt'
        ]);
    }

    /** @test */
    public function update_with_new_image_replaces_old_image()
    {
        $oldFile = UploadedFile::fake()->image('old.jpg');
        $post = Post::factory()->create(['image' => 'images/' . $oldFile->hashName()]);
        
        $newFile = UploadedFile::fake()->image('new.jpg');

        $updateData = [
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
            'excerpt' => $post->excerpt,
            'image' => $newFile
        ];

        $this->patch(route('posts.update', $post->slug), $updateData);

        $post->refresh();
        $this->assertStringContainsString($newFile->hashName(), $post->image);
        Storage::disk('public')->assertExists('images/' . $newFile->hashName());
    }

    /** @test */
    public function update_without_image_keeps_existing_image()
    {
        $post = Post::factory()->create(['image' => 'images/existing.jpg']);
        $originalImage = $post->image;

        $updateData = [
            'title' => 'Updated Title',
            'slug' => $post->slug,
            'content' => $post->content,
            'excerpt' => $post->excerpt
        ];

        $this->patch(route('posts.update', $post->slug), $updateData);

        $post->refresh();
        $this->assertEquals($originalImage, $post->image);
    }

    /** @test */
    public function destroy_deletes_post()
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', $post->slug));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('post', ['id' => $post->id]);
    }

    /** @test */
    public function destroy_returns_404_for_nonexistent_post()
    {
        $response = $this->delete(route('posts.destroy', 'nonexistent'));

        $response->assertStatus(404);
    }
}
