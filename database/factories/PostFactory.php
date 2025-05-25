<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title   = $this->faker->sentence;
        return [
            'title'        => $title,
            'slug'         => Str::slug($title).'-'.Str::random(5),
            'content'      => $this->faker->paragraphs(3, true),
            'excerpt'      => $this->faker->sentence,
            'image'        => 'images/'.$this->faker->image('storage/app/public/images', 400, 300, null, false),
            'published_at' => now()->subDay(),
        ];
    }
}
