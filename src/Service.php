<?php

namespace think\testing;

class Service extends \think\Service
{
    public function boot()
    {
        $this->commands([
            'build' => command\Test::class,
        ]);
    }
}
