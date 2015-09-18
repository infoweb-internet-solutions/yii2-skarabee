<?php

namespace infoweb\skarabee\widgets;

use Yii;
use yii\data\ActiveDataProvider;

use infoweb\skarabee\models\RealEstate as RealEstateModel;

class RealEstateSearch extends RealEstateModel
{
    public $pageSize;
    public $route;

    //public $city;

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'property_id' => $this->property_id,
            'price' => $this->price,
            'construction_year' => $this->construction_year,
            'cadastrall_income' => $this->cadastrall_income,
            'area' => $this->area,
            'land_area' => $this->land_area,
            'communal_expenses' => $this->communal_expenses,
            'number_of_floors' => $this->number_of_floors,
            'number_of_bedrooms' => $this->number_of_bedrooms,
            'number_of_bathrooms' => $this->number_of_bathrooms,
            'number_of_parking_places' => $this->number_of_parking_places,
            'number_of_offices' => $this->number_of_offices,
            'surface_living' => $this->surface_living,
            'surface_garden' => $this->surface_garden,
            'surface_kitchen' => $this->surface_kitchen,
            'surface_livable' => $this->surface_livable,
            'energy_index' => $this->energy_index,
            'real_estate_tax' => $this->real_estate_tax,
            'enabled' => $this->enabled,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'disabled_at' => $this->disabled_at,
            'created_in_skarabee_at' => $this->created_in_skarabee_at,
            'updated_in_skarabee_at' => $this->updated_in_skarabee_at,
        ]);

        $query->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'house_number', $this->house_number])
            ->andFilterWhere(['like', 'house_number_extension', $this->house_number_extension])
            ->andFilterWhere(['like', 'mailbox', $this->mailbox])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'market_type', $this->market_type])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'typo_characterisation', $this->typo_characterisation])
            ->andFilterWhere(['like', 'price_type', $this->price_type])
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'flash_title', $this->flash_title])
            ->andFilterWhere(['like', 'flash_text', $this->flash_text])
            ->andFilterWhere(['like', 'conditional_sold', $this->conditional_sold])
            ->andFilterWhere(['like', 'heating_type', $this->heating_type])
            ->andFilterWhere(['like', 'restriction_comment', $this->restriction_comment])
            ->andFilterWhere(['like', 'floor_level', $this->floor_level])
            ->andFilterWhere(['like', 'available_from', $this->available_from])
            ->andFilterWhere(['like', 'has_garage', $this->has_garage])
            ->andFilterWhere(['like', 'has_terrace', $this->has_terrace])
            ->andFilterWhere(['like', 'has_garden', $this->has_garden])
            ->andFilterWhere(['like', 'has_elevator', $this->has_elevator])
            ->andFilterWhere(['like', 'new_estate', $this->new_estate])
            ->andFilterWhere(['like', 'special_type', $this->special_type])
            ->andFilterWhere(['like', 'urban_development_permit', $this->urban_development_permit])
            ->andFilterWhere(['like', 'urban_development_summons', $this->urban_development_summons])
            ->andFilterWhere(['like', 'urban_development_preemptive_rights', $this->urban_development_preemptive_rights])
            ->andFilterWhere(['like', 'urban_development_allotment_permit', $this->urban_development_allotment_permit])
            ->andFilterWhere(['like', 'urban_development_area_application', $this->urban_development_area_application])
            ->andFilterWhere(['like', 'urban_development_judicial_decision', $this->urban_development_judicial_decision])
            ->andFilterWhere(['like', 'energy_class_end_date', $this->energy_class_end_date])
            ->andFilterWhere(['like', 'energy_class', $this->energy_class])
            ->andFilterWhere(['like', 'energy_certificate_nr', $this->energy_certificate_nr])
            ->andFilterWhere(['like', 'orientation', $this->orientation])
            ->andFilterWhere(['like', 'nearby_public_transport', $this->nearby_public_transport])
            ->andFilterWhere(['like', 'nearby_shops', $this->nearby_shops])
            ->andFilterWhere(['like', 'nearby_school', $this->nearby_school])
            ->andFilterWhere(['like', 'nearby_highway', $this->nearby_highway])
            ->andFilterWhere(['like', 'address_position_x', $this->address_position_x])
            ->andFilterWhere(['like', 'address_position_y', $this->address_position_y])
            ->andFilterWhere(['like', 'renovation_year', $this->renovation_year]);

        return $dataProvider;
    }
}
