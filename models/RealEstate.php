<?php

namespace infoweb\skarabee\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\helpers\BaseFileHelper;

class RealEstate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'real_estates';
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function() { return time(); },
            ],
            'image' => [
                'class' => 'infoweb\cms\behaviors\ImageBehave',
            ],
        ]);
    }
    
    /**
     * Deletes the attached images
     * 
     * @return  boolean
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->removeImages();
            return true;
        } else {
            return false;
        }    
    }
    
    /**
     * Attaches an image provided by Skarabee to the model
     * 
     * @param   array   $img        An information array for the image
     * @param   boolean $isMain     A flag to set the image as the main image
     * @return  boolean
     */
    public function attachSkarabeeImage($img, $isMain = false)
    {
        // The image from Skarabee is first donwloaded
        if ($this->downloadSkarabeeImage("{$img['URL']}&width=800&height=600", $img['Name'])) {
            // This image is then attached to the model
            if ($this->attachImage(Yii::getAlias('@uploadsBasePath/img') . DIRECTORY_SEPARATOR . 'RealEstates' . DIRECTORY_SEPARATOR . $img['Name']))
                return true;   
        }

        return false;   
    }
    
    /**
     * Downloads an image from the Skarabee server
     * 
     * @param   string  $url    The image url
     * @param   string  $name   The name of the image
     * @return  boolean
     */
    protected function downloadSkarabeeImage($url, $name)
    {
        $dir = Yii::getAlias('@uploadsBasePath/img');
        
        // Download the file
        $file = file_get_contents($url);
        
        // Create the real estate dir if does not exist
        BaseFileHelper::createDirectory($dir . DIRECTORY_SEPARATOR . 'RealEstates', 0775, true);
        
        // Store in the filesystem.
        $fp = fopen($dir . DIRECTORY_SEPARATOR . 'RealEstates' . DIRECTORY_SEPARATOR . $name, 'w');
        $r = fwrite($fp, $file);
        fclose($fp);
        
        return $r;
    }
}
