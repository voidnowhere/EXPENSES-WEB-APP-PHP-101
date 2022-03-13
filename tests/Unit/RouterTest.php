<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
    }

    /** @test */
    public function register_route(): void
    {
        $this->router->register('GET', '/users', ['UsersController', 'index']);

        $expected = [
            'GET' => ['/users' => ['UsersController', 'index']]
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function register_get_route(): void
    {
        $this->router->get('/users', ['UsersController', 'index']);

        $expected = [
            "GET" => ['/users' => ['UsersController', 'index']]
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function register_post_route(): void
    {
        $this->router->post('/users', ['UsersController', 'store']);

        $expected = [
            "POST" => ['/users' => ['UsersController', 'store']]
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function new_router_empthy(): void
    {
        $this->assertEmpty((new Router())->getRoutes());
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\RouterDataProvider::routeNotFoundCases()
     */
    public function resolve_with_RouteNotFoundException(string $requestURI, string $requestMethod): void
    {
        $users = new class() {
            public function index(): bool
            {
                return true;
            }
        };

        $this->router->get('/users', [$users::class, 'index']);

        $this->expectException(RouteNotFoundException::class);

        $this->router->resolve($requestURI, $requestMethod);
    }

    /** @test */
    public function resolve_callable(): void
    {
        $this->router->get('/users', fn() => [1, 2, 3]);

        $this->assertEquals([1, 2, 3], $this->router->resolve('/users', 'GET'));
    }

    /** @test */
    public function resolve_route(): void
    {
        $users = new class() {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };

        $this->router->get('/users', [$users::class, 'index']);

        $this->assertSame([1, 2, 3], $this->router->resolve('/users', 'GET'));
    }
}
