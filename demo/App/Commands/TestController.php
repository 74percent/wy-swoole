<?php

namespace App\Commands;

use EasySwoole\EasySwoole\Crontab\AbstractCronTask;

class TestController extends AbstractCronTask
{
    public static function getRule(): string
    {
        return '*/10 * * * *';
    }

    public static function getTaskName(): string
    {
        return 'crontab-test';
    }

    public function run(int $taskId, int $workerIndex)
    {
        echo '[' . date('Y-m-d H:i:s') . '] ' . 'The system is operating normally.' . PHP_EOL;
    }

    public function onException(\Throwable $throwable, int $taskId, int $workerIndex)
    {
    }
}
