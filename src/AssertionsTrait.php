<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace think\testing;

use PHPUnit\Framework\Assert as PHPUnit;
use think\facade\Route;
use think\facade\Session;
use think\response\View;

trait AssertionsTrait
{
    public function assertResponseOk()
    {
        $actual = $this->response->getCode();

        PHPUnit::assertTrue(200 == $actual, "Expected status code 200, got {$actual}.");
    }

    public function assertResponseStatus($code)
    {
        $actual = $this->response->getCode();

        PHPUnit::assertEquals($code, $actual, "Expected status code {$code}, got {$actual}.");
    }

    public function assertViewHas($key, $value = null)
    {
        if (is_array($key)) {
            $this->assertViewHasAll($key);
        } else {
            if (!$this->response instanceof View) {
                PHPUnit::assertTrue(false, 'The response was not a view.');
            } else {
                if (is_null($value)) {
                    PHPUnit::assertArrayHasKey($key, $this->response->getVars());
                } else {
                    PHPUnit::assertEquals($value, $this->response->getVars($key));
                }
            }
        }
    }

    public function assertViewHasAll(array $bindings)
    {
        foreach ($bindings as $key => $value) {
            if (is_int($key)) {
                $this->assertViewHas($value);
            } else {
                $this->assertViewHas($key, $value);
            }
        }
    }

    public function assertViewMissing($key)
    {
        if (!$this->response instanceof View) {
            PHPUnit::assertTrue(false, 'The response was not a view.');
        } else {
            PHPUnit::assertArrayNotHasKey($key, $this->response->getVars());
        }
    }

    public function assertRedirectedTo($uri, $params = [])
    {
        $this->assertInstanceOf('think\response\Redirect', $this->response);

        PHPUnit::assertEquals(Route::buildUrl($uri, $params), $this->response->getData());
    }

    public function assertSessionHas($key, $value = null)
    {
        if (is_array($key)) {
            $this->assertSessionHasAll($key);
        } else {
            if (is_null($value)) {
                PHPUnit::assertTrue(Session::has($key), "Session missing key: $key");
            } else {
                PHPUnit::assertEquals($value, Session::get($key));
            }
        }
    }

    public function assertSessionHasAll(array $bindings)
    {
        foreach ($bindings as $key => $value) {
            if (is_int($key)) {
                $this->assertSessionHas($value);
            } else {
                $this->assertSessionHas($key, $value);
            }
        }
    }
}
