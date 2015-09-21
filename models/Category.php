<?php

namespace infoweb\skarabee\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * This is the model class for table "real_estate_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'real_estate_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['id', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
        ];
    }

    /**
     * Returns the url of the real estate
     *
     * @param   string  $includeLanguage
     * @return  string  $url
     */
    public function getUrl($includeLanguage = true)
    {
        $url = (Yii::$app->id !== 'app-backend') ? Yii::getAlias('@baseUrl') . '/' : '';

        if ($includeLanguage)
            $url .= Yii::$app->language . '/';

        $module = Yii::$app->getModule('skarabee');

        if (isset($module->categoryUrlPrefix)) {
            $url .= Yii::t('url', $module->categoryUrlPrefix) . '/';
        }

        $url .= "{$this->id}";

        return $url;
    }

    /**
     * Returns all items formatted for usage in a Html::dropDownList widget:
     *      [
     *          'id' => 'name',
     *          'id' => 'name,
     *          ...
     *      ]
     *
     * @return  array
     */
    public function getAllForDropDownList()
    {
        $items = (new Query())
            ->select('id, name')
            ->from('real_estate_category')
            ->orderBy(['name' => SORT_ASC])
            ->all();

        return ArrayHelper::map($items, 'id', 'name');
    }
}
