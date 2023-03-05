<?php
namespace app\commands;

use yii\console\Controller;

class MyCommand extends Controller
{
    public function actionHello($name = 'World')
    {
        echo 'Hello, ' . $name . '!' . PHP_EOL;
    }
}
?>