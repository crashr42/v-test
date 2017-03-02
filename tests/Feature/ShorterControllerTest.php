<?php

namespace Tests\Feature;

use App\Libs\UrlHasher;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShorterControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_should_get_root_path()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('URL SHORTER');
        $response->assertDontSee('Url invalid.');
    }

    /**
     * @test
     */
    public function it_should_get_root_path_with_long_url()
    {
        $response = $this->get('/?long_url=http://test');

        $response->assertStatus(200);

        $response->assertSee('http://test');
    }

    /**
     * @test
     */
    public function it_should_get_root_path_with_invalid_long_url()
    {
        $response = $this->get('/?long_url=http://test'.str_repeat('z', UrlHasher::MAX_URL_LENGTH));

        $response->assertStatus(200);

        $response->assertDontSee('http://test');
        $response->assertSee('Url invalid.');
    }

    /**
     * @test
     */
    public function it_should_get_root_path_with_long_url_xhr()
    {
        $response = $this->get('/?long_url=http://test', [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);

        static::assertRegExp('/{"url":"http:.*localhost.*[a-zA-Z0-9]{6,6}"}/', $response->baseResponse->content());
    }

    /**
     * @test
     */
    public function it_should_get_root_path_with_invalid_long_url_xhr()
    {
        $response = $this->get('/?long_url=http://test'.str_repeat('z', UrlHasher::MAX_URL_LENGTH), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(422);

        static::assertRegExp('{"error":"Url invalid."}', $response->baseResponse->content());
    }

    /**
     * @test
     */
    public function it_should_get_root_path_with_empty_long_url()
    {
        $response = $this->get('/?long_url=%20');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_should_get_root_path_with_empty_long_url_xhr()
    {
        $response = $this->get('/?long_url=%20', [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(422);

        static::assertRegExp('{"error":"Url invalid."}', $response->baseResponse->content());
    }
}
