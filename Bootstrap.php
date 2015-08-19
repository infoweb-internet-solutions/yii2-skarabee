<?php
namespace infoweb\social;

use Yii;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('skarabee') && ($module = $app->getModule('skarabee')) instanceof Module) {            

            // Set controller namespace to allow execution of console commands
            if ($app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'infoweb\skarabee\console\controllers';
            }
        }
    }
}