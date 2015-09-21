<?php

namespace infoweb\skarabee\models;

use Yii;

/**
 * This is the model class for table "real_estate_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'real_estate_type';
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
}
