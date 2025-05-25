<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;

class PostTest extends TestCase
{
    /** @test */
    public function route_key_name_is_slug()
    {
        $this->assertEquals('slug', (new Post)->getRouteKeyName());
    }
}
