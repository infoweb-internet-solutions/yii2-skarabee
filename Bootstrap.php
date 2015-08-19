<?php
namespace infoweb\skarabee;

use Yii;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use infoweb\skarabee\console\controllers\SkarabeeController;

class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('skarabee') && ($module = $app->getModule('skarabee')) instanceof Module) {            

            // Set controller map to allow execution of console commands
            if ($app instanceof ConsoleApplication) {
                if (!isset($app->controllerMap['skarabee'])) {
                    $app->controllerMap['skarabee'] = SkarabeeController::className();
                }
            }
        }
    }
}