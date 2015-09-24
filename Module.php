<?php

namespace infoweb\skarabee;

use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    /**
     * The prefix that is used in RealEstate::getUrl()
     * @var string
     */
    public $realEstateUrlPrefix = '';
       
    public function init()
    {
        parent::init();

        Yii::configure($this, require(__DIR__ . '/config.php')); 
    }
}