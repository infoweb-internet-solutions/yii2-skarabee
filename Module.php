<?php

namespace infoweb\skarabee;

use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{   
    public function init()
    {
        parent::init();

        Yii::configure($this, require(__DIR__ . '/config.php')); 
    }
}