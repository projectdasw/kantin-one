<?php

namespace Tests\Unit;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Http\Request;
use Illuminate\Session\ArraySessionHandler;
use Illuminate\Session\Store;
use Illuminate\Session\TokenMismatchException;
use Mockery;
use Tests\TestCase;

class PreventRequestForgeryTest extends TestCase
{
    public function test_post_request_without_csrf_token_is_rejected(): void
    {
        $app = Mockery::mock(Application::class);
        $app->shouldReceive('runningInConsole')->andReturn(false);

        $middleware = new PreventRequestForgery(
            $app,
            app(Encrypter::class)
        );

        $session = new Store('test', new ArraySessionHandler(120));
        $session->start();

        $request = Request::create('/csrf-probe', 'POST');
        $request->setLaravelSession($session);

        $this->expectException(TokenMismatchException::class);

        $middleware->handle($request, fn ($request) => response('OK'));
    }

    public function test_post_request_with_valid_csrf_token_is_accepted(): void
    {
        $app = Mockery::mock(Application::class);
        $app->shouldReceive('runningInConsole')->andReturn(false);

        $middleware = new PreventRequestForgery(
            $app,
            app(Encrypter::class)
        );

        $session = new Store('test', new ArraySessionHandler(120));
        $session->start();

        $request = Request::create('/csrf-probe', 'POST');
        $request->setLaravelSession($session);
        $request->request->set('_token', $session->token());

        $response = $middleware->handle(
            $request,
            fn ($request) => response('OK')
        );

        $this->assertSame('OK', $response->getContent());
    }
}
