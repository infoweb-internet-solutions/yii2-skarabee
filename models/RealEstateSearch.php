<?php

namespace infoweb\skarabee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use infoweb\skarabee\models\RealEstate;

class RealEstateSearch extends RealEstate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['street', 'zipcode'], 'safe'],
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
        $query = RealEstate::find();
        
        $query->andFilterWhere(['enabled' => 1, 'active' => 1]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['street' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'street', $this->street]);
        $query->andFilterWhere(['like', 'zipcode', $this->zipcode]);
        $query->orFilterWhere(['like', 'city', $this->zipcode]);

        return $dataProvider;
    }
}
