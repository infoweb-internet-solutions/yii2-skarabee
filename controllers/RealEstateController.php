<?php

namespace infoweb\skarabee\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\base\Model;
use yii\base\Exception;
use infoweb\skarabee\models\RealEstate;
use infoweb\skarabee\models\RealEstateSearch;

class RealEstateController extends Controller
{
    /**
     * Lists all RealEstate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RealEstateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
