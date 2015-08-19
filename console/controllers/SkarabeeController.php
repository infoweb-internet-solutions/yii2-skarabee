<?php

namespace infoweb\skarabee\console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;

class SkarabeeController extends Controller
{   
    public function actionImport()
    {
        foreach (Yii::$app->skarabee->getAll() as $publication) {
            $this->stdout($publication['ID']);        
        }
        
        return Controller::EXIT_CODE_NORMAL;
    }  
}