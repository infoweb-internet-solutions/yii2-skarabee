<?php

namespace infoweb\skarabee\widgets;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use infoweb\skarabee\models\RealEstate as RealEstateModel;

class RealEstateSearch extends RealEstateModel
{
    public $pageSize;
    public $route;
    public $minPrice;
    public $maxPrice;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['minPrice', 'maxPrice'], 'integer'],
            [['city'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city' => Yii::t('frontend', 'Gemeente'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RealEstateModel::find()->andFilterWhere(['active' => 1, 'enabled' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => $this->pageSize,
                'route' => $this->route,
                'forcePageParam' => false,
            ],
        ]);

        // Default values hack
        $get = Yii::$app->request->get();
        if ($get && !($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $category = Yii::$app->request->get('realEstateCategory', null);

        if ($category) {
            $query->andFilterWhere(['in', 'status', RealEstateModel::combinedStatuses()[$category]]);
        }

        $type = Yii::$app->request->get('realEstateType', null);

        if ($type) {
            $query->andFilterWhere(['in', 'type', RealEstateModel::combinedTypes()[$type]]);
        }

        $query->andFilterWhere(['like', 'city', $this->city]);

        if ($this->minPrice) {
            $query->andFilterWhere(['>', 'price', $this->minPrice]);
        }

        if ($this->maxPrice) {
            $query->andFilterWhere(['<', 'price', $this->maxPrice]);
        }

        return $dataProvider;
    }
}
