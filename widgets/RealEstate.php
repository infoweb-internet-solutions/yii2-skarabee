<?php
namespace infoweb\skarabee\widgets;


use Yii;
use yii\bootstrap\Widget;

class RealEstate extends Widget
{
    public $template = '_realEstate';
    public $pageSize = 20;
    public $layout = "{items}\n{pager}";
    public $route = '';

    public function init()
    {
        parent::init();
    }

    /**
     * @return null|string
     */
    public function run()
    {
        $searchModel = new Search([
            'pageSize' => $this->pageSize,
            'route' => $this->route,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('realEstate', ['dataProvider' => $dataProvider, 'template' => $this->template, 'layout' => $this->layout]);
    }
}
