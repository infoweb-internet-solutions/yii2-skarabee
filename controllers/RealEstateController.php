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
        $timestamp = Yii::$app->db->createCommand('SELECT `last_synchronisation` FROM `skarabee`')->queryOne();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'timestamp' => $timestamp
        ]);
    }
    
    /**
     * Updates the downloads attribute of  an existing RealEstate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionDownloads($id)
    {
        $model = $this->findModel($id);
        
        if (Yii::$app->request->getIsPost()) {
            
            $post = Yii::$app->request->post();
            
            // Ajax request, validate the models
            if (Yii::$app->request->isAjax) {
                               
                // Populate the model with the POST data
                $model->load($post);

                // Validate the model
                $response = ActiveForm::validate($model);
                
                // Return validation in JSON format
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $response;
            
            // Normal request, save models
            } else {
                // Save the main model
                if (!$model->load($post) || !$model->save()) {
                    return $this->render('downloads', [
                        'model' => $model,
                    ]);
                }
                
                // Set flash message
                Yii::$app->getSession()->setFlash('agenda', Yii::t('app', '"{item}" has been updated', ['item' => $model->fullAddress]));
              
                // Take appropriate action based on the pushed button
                if (isset($post['close'])) {                    
                    return $this->redirect(['index']);                    
                } else {
                    return $this->redirect(['downloads', 'id' => $model->id]);
                }    
            }    
        }

        return $this->render('downloads', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the RealEstate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RealEstate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested item does not exist'));
        }
    }
}