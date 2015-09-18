<?php

namespace infoweb\skarabee\widgets;

use Yii;
use yii\data\ActiveDataProvider;

use infoweb\skarabee\models\RealEstate as RealEstateModel;

class Search extends RealEstateModel
{
    public $pageSize;
    public $route;

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RealEstateModel::find()->where(['active' => 1, 'enabled' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => $this->pageSize,
                'route' => $this->route,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
