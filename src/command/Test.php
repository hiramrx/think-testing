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

namespace think\testing\command;

use PHPUnit\TextUI\Command as TextUICommand;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Session;

class Test extends Command
{
    public function configure()
    {
        $this->setName('unit')->setDescription('phpunit')->ignoreValidationErrors();
    }

    public function execute(Input $input, Output $output)
    {

        Session::init();
        $argv = $_SERVER['argv'];
        array_shift($argv);
        array_shift($argv);
        array_unshift($argv, 'phpunit');

        return (new TextUICommand())->run($argv, false);
    }

}
