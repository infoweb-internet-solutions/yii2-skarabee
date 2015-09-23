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
    // Status constants
    const STATUS_SOLD = 'SOLD';
    const STATUS_FOR_SALE = 'FOR_SALE';
    const STATUS_FOR_SALE_ORDER_ENDED = 'FOR_SALES_ORDER_ENDED';
    const STATUS_PROSPECT_FOR_SALE = 'PROSPECT_FOR_SALE';
    const STATUS_RENTED = 'RENTED';
    const STATUS_FOR_RENT = 'FOR_RENT';
    const STATUS_FOR_RENT_ORDER_ENDED = 'FOR_RENT_ORDER_ENDED';
    const STATUS_PROSPECT_FOR_RENT = 'PROSPECT_FOR_RENT';

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
    
    public static function statuses()
    {
        return [
            self::STATUS_SOLD => Yii::t('infoweb/skarabee', 'Verkocht'),
            self::STATUS_FOR_SALE => Yii::t('infoweb/skarabee', 'Te koop'),
            self::STATUS_FOR_SALE_ORDER_ENDED => Yii::t('infoweb/skarabee', 'Te koop'),
            self::STATUS_PROSPECT_FOR_SALE => Yii::t('infoweb/skarabee', 'te Koop'),
            self::STATUS_RENTED => Yii::t('infoweb/skarabee', 'Verhuurd'),
            self::STATUS_FOR_RENT => Yii::t('infoweb/skarabee', 'Te huur'),
            self::STATUS_FOR_RENT_ORDER_ENDED => Yii::t('infoweb/skarabee', 'Te huur'),
            self::STATUS_PROSPECT_FOR_RENT => Yii::t('infoweb/skarabee', 'Te huur'),
        ];
    }

    /**
     * Because Skarabee uses multiple statuses to point to the same type of estate, theses shortcuts are defined
     *
     * @return  array
     */
    public static function combinedStatuses()
    {
        return [
            'te-huur' => [self::STATUS_RENTED, self::STATUS_FOR_RENT, self::STATUS_FOR_RENT_ORDER_ENDED, self::STATUS_PROSPECT_FOR_RENT],
            'te-koop' => [self::STATUS_SOLD, self::STATUS_FOR_SALE, self::STATUS_FOR_SALE_ORDER_ENDED, self::STATUS_PROSPECT_FOR_SALE],
        ];
    }

    /**
     * Because Skarabee uses multiple types to point to the same type of estate, theses shortcuts are defined
     * 
     * @return  array
     */
    public static function combinedTypes()
    {
        return [
            'appartement' => ['APP'],
            'autostaanplaats' => ['PAR'],
            'garage' => ['GAR'],
            'grond' => ['BGH', 'BGO', 'BUT'],
            'handelspand' => ['STO', 'CAT', 'OTH'],
            'kantoor' => ['OFF'],
            'woonhuis' => ['HFH', 'FRH', 'CLH'],
        ];    
    }
    
    public static function types()
    {
        return [
            'APP'           => Yii::t('infoweb/skarabee', 'Appartement'),
            'HFH'           => Yii::t('infoweb/skarabee', 'Woonhuis'),
            'FRH'           => Yii::t('infoweb/skarabee', 'Woonhuis'),
            'CLH'           => Yii::t('infoweb/skarabee', 'Woonhuis'),
            'GAR'           => Yii::t('infoweb/skarabee', 'Garage'),
            'STO'           => Yii::t('infoweb/skarabee', 'Handelspand'),
            'CAT'           => Yii::t('infoweb/skarabee', 'Handelspand'),
            'OTH'           => Yii::t('infoweb/skarabee', 'Handelspand'),
            'OFF'           => Yii::t('infoweb/skarabee', 'Kantoor'),
            'PAR'           => Yii::t('infoweb/skarabee', 'Autostaanplaats'),
            'BGH'           => Yii::t('infoweb/skarabee', 'Grond'),
            'BGO'           => Yii::t('infoweb/skarabee', 'Grond'),
            'BUT'           => Yii::t('infoweb/skarabee', 'Grond'),
        ];
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
     * Returns the address
     * 
     * @return  string
     */
    public function getAddress()
    {
        $address = $this->street;
        
        if (!empty($this->house_number))
            $address .= " {$this->house_number}";
        
        if (!in_array($this->house_number_extension, ['', '/', '-']))
            $address .= $this->house_number_extension;
        
        if (!empty($this->mailbox))
            $address .= " bus {$this->mailbox}";
        
        return $address;
    }

    /**
     * Returns the price
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getFullPrice() {
        $price = Yii::$app->formatter->asCurrency($this->price);

        if (in_array($this->status, self::combinedStatuses()['te-huur'])) {
            $price .= ' / maand';
        }

        return $price;
    }

    /**
     * Returns the full address
     * 
     * @return  string
     */
    public function getFullAddress()
    {
        $address = $this->getAddress();
        
        $address .= ", {$this->zipcode} {$this->city}";
        
        return $address;
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
