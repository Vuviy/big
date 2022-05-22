<?php

namespace WezomCms\Menu\Tests\Unit;

use Illuminate\Http\Request;
use LaravelLocalization;
use Mockery;
use Tests\TestCase;
use WezomCms\Menu\Models\Menu;

class MenuActiveModeTest extends TestCase
{
    public function testCurrentLocale()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/uk/sale']);

        $this->mockRequest('/uk/sale');

        $this->assertEquals(Menu::MODE_SPAN, $menu->activeMode());
    }

    public function testDefaultLocale()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/' . LaravelLocalization::getDefaultLocale() . '/sale']);

        $this->mockRequest('/sale');

        $this->assertEquals(Menu::MODE_SPAN, $menu->activeMode());
    }

    public function testHyperonym()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/services']);

        $this->mockRequest('/services/slug');

        $this->assertEquals(Menu::MODE_LINK, $menu->activeMode());
    }

    public function testHyperonymWithCurrentLocale()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/uk/services']);

        $this->mockRequest('/uk/services/slug');

        $this->assertEquals(Menu::MODE_LINK, $menu->activeMode());
    }

    public function testHyperonymWithDefaultLocale()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/' . LaravelLocalization::getDefaultLocale() . '/services']);

        $this->mockRequest('/services/slug');

        $this->assertEquals(Menu::MODE_LINK, $menu->activeMode());
    }

    public function testHyponym()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/services/slug']);

        $this->mockRequest('/services');

        $this->assertNull($menu->activeMode());
    }

    public function testHyponymWithCurrentLocale()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/uk/services/slug']);

        $this->mockRequest('/uk/services');

        $this->assertNull($menu->activeMode());
    }

    public function testHyponymWithDefaultLocale()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/' . LaravelLocalization::getDefaultLocale() . '/services/slug']);

        $this->mockRequest('/services');

        $this->assertNull($menu->activeMode());
    }

    public function testDifferentLocales()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/ru/services']);

        $this->mockRequest('/en/services');

        $this->assertNull($menu->activeMode());
    }

    public function testParonym()
    {
        /** @var Menu $menu */
        $menu = Menu::factory()->make(['url' => '/sale']);

        $this->mockRequest('/sales');

        $this->assertNull($menu->activeMode());
    }

    /**
     * @param  string  $path
     */
    protected function mockRequest(string $path): void
    {
        $requestMock = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('getPathInfo')
            ->once()
            ->andReturn($path);

        app()->instance('request', $requestMock->getMock());
    }
}
