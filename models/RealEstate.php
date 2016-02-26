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
            'pdf' => [
                'class' => 'infoweb\skarabee\behaviors\PdfBehave'
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['downloads'], 'string'],
        ];
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

    public static function getUrbanDevelopmentAreaApplications() {
        return [
            'Ag'        => 'Agrarisch gebied',
            'Bg'        => 'Bosgebied',
            'Gdr'       => 'Dagrecreatie',
            'Gvr'       => 'Verblijfrecreatie',
            'Iab'       => 'Industriegebied voor ambachtelijke bedrijven of gebieden voor kleine en middelgrote ondernemingen',
            'Igb'       => 'Industriegebied',
            'Lwag'      => 'Landschappelijk waardevolle agrarisch gebied',
            'Ng'        => 'Natuurgebied',
            'Nr'        => 'Natuurreservaat',
            'OTHER'     => 'Andere',
            'Pg'        => 'Landelijk parkgebied',
            'UNDEFINED' => 'Nee',
            'Wche'      => 'Woongebied met culturele, historische en/of esthetische waarde',
            'Wg'        => 'Woongebied',
            'Wglk'      => 'Woongebied met landelijk karakter',
            'Wp'        => 'Woonpark',
            'Wug'       => 'Woonuitbreidingsgebied'
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
            'AND'           => Yii::t('infoweb/skarabee', 'Woonhuis'),
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
     * Orientations
     */
    public static function getOrientations () {
        return [
            'NORTH'         => Yii::t('infoweb/skarabee', 'Noord'),
            'NORTH_EAST'    => Yii::t('infoweb/skarabee', 'Noord-Oost'),
            'NORTH_WEST'    => Yii::t('infoweb/skarabee', 'Noord-West'),
            'EAST'          => Yii::t('infoweb/skarabee', 'Oost'),'Oost',
            'WEST'          => Yii::t('infoweb/skarabee', 'West'),'West',
            'SOUTH'         => Yii::t('infoweb/skarabee', 'Zuid'),'Zuid',
            'SOUTH_EAST'    => Yii::t('infoweb/skarabee', 'Zuid-Oost'),
            'SOUTH_WEST'    => Yii::t('infoweb/skarabee', 'Zuid-West'),
            'UNDEFINED'     => '-',
        ];
    }

    public static function getHeatingTypes () {
        return [
            'ELECTRICITY'           => Yii::t('infoweb/skarabee', 'Electrisch'),
            'HEATING_OIL'           => Yii::t('infoweb/skarabee', 'Stookolie'),
            'NATURAL_GAS'           => Yii::t('infoweb/skarabee', 'Gas'),
            'INDIVIDUAL'            => Yii::t('infoweb/skarabee', 'Individueel'),
            'CENTRALLY_HEATED'      => Yii::t('infoweb/skarabee', 'Centrale verwarming'),
            'OTHER'                 => Yii::t('infoweb/skarabee', 'Andere'),
        ];
    }

    public static function getTypoCharacterisations() {
        return [
            'Dwelling_Corner'               => Yii::t('infoweb/skarabee', 'Hoekwoning'),
            'Dwelling_Detached'             => Yii::t('infoweb/skarabee', 'Open bebouwing'),
            'Dwelling_Linked'               => Yii::t('infoweb/skarabee', 'Schakelwoning'),
            'Dwelling_Quadrant'             => Yii::t('infoweb/skarabee', 'Kwadrantwoning'),
            'Dwelling_SemiDetached'         => Yii::t('infoweb/skarabee', 'Half open bebouwing'),
            'Dwelling_Terraced'             => Yii::t('infoweb/skarabee', 'Rijwoning'),

            'Flat_Corridor'                 => Yii::t('infoweb/skarabee', 'Corridorflat'),
            'Flat_Gallery'                  => Yii::t('infoweb/skarabee', 'Galerij'),
            'Flat_Highrise'                 => Yii::t('infoweb/skarabee', 'Hoogbouw'),
            'Flat_Porch'                    => Yii::t('infoweb/skarabee', 'Portiekflat'),
            'Flat_Condominium'              => Yii::t('infoweb/skarabee', 'Condominium'),
            'Flat_Villa'                    => Yii::t('infoweb/skarabee', 'Villa-appartement'),
            'Flat_Townhouse'                => Yii::t('infoweb/skarabee', 'In stadswoning'),
            'Flat_Haussmann'                => Yii::t('infoweb/skarabee', 'Architecture haussmannienne'),

            'Land_Corner'                   => Yii::t('infoweb/skarabee', 'Hoekwoning'),
            'Land_Detached'                 => Yii::t('infoweb/skarabee', 'Open bebouwing'),
            'Land_Linked'                   => Yii::t('infoweb/skarabee', 'Schakelwoning'),
            'Land_SemiDetached'             => Yii::t('infoweb/skarabee', 'Half open bebouwing'),
            'Land_Terraced'                 => Yii::t('infoweb/skarabee', 'Rijwoning'),

            'ServiceFlat_Corridor'          => Yii::t('infoweb/skarabee', 'Corridorflat'),
            'ServiceFlat_Gallery'           => Yii::t('infoweb/skarabee', 'Galerij'),
            'ServiceFlat_Highrise'          => Yii::t('infoweb/skarabee', 'Hoogbouw'),
            'ServiceFlat_Porch'             => Yii::t('infoweb/skarabee', 'Portiekflat'),
            'ServiceFlat_Condominium'       => Yii::t('infoweb/skarabee', 'Condominium'),
            'ServiceFlat_Villa'             => Yii::t('infoweb/skarabee', 'Villa-appartement'),
            'ServiceFlat_Townhouse'         => Yii::t('infoweb/skarabee', 'In stadswoning'),
            'ServiceFlat_Haussmann'         => Yii::t('infoweb/skarabee', 'Architecture haussmannienne'),

            'Room_InComplex'                => Yii::t('infoweb/skarabee', 'In complex-kamergebouw'),
            'Room_InDwelling'               => Yii::t('infoweb/skarabee', 'In woonhuis'),
            'Room_InFlat'                   => Yii::t('infoweb/skarabee', 'In appartement'),
            'Room_Townhouse'                => Yii::t('infoweb/skarabee', 'In stadswoning'),

            'Parking_Annex'                 => Yii::t('infoweb/skarabee', 'Aangebouwd'),
            'Parking_Inbuilt'               => Yii::t('infoweb/skarabee', 'Inpandig'),
            'Parking_Detached'              => Yii::t('infoweb/skarabee', 'Vrijstaand'),

            'Other_Corner'                  => Yii::t('infoweb/skarabee', 'Hoekwoning'),
            'Other_Detached'                => Yii::t('infoweb/skarabee', 'Open bebouwing'),
            'Other_Linked'                  => Yii::t('infoweb/skarabee', 'Schakelwoning'),
            'Other_Quadrant'                => Yii::t('infoweb/skarabee', 'Kwadrantwoning'),
            'Other_SemiDetached'            => Yii::t('infoweb/skarabee', 'Half open bebouwing'),
            'Other_Terraced'                => Yii::t('infoweb/skarabee', 'Rijwoning'),
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
        if ($this->hide_price == 1) {
            return Yii::t('infoweb/skarabee', 'Prijs op aanvraag');
        }

        $price = Yii::$app->formatter->asCurrency($this->price);

        if (in_array($this->status, self::combinedStatuses()['te-huur'])) {
            $price .= ' / maand';
        }

        return $price;
    }

    /**
     * Returns the surface
     *
     * @param $property
     * @return string
     */
    public function getSurface($property) {

        if (!isset($this->{$property}) || $this->{$property} == 0) {
            return '-';
        }

        return Yii::$app->formatter->asDecimal($this->{$property}, 0) . '&nbsp;m<sup>2</sup>';
    }

    /**
     * Convert database boolean to string
     *
     * @param $property
     * @return string
     */
    public function getBoolean($property) {
        return (isset($this->{$property}) && $this->{$property} === 'TRUE') ? 'Ja' : 'Nee';
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
     * Returns available from
     *
     * @return mixed
     */
    public function getAvailableFrom() {

        if (!isset($this->available_from)) {
            return '-';
        }

        if (strpos($this->available_from, '20') !== false) {
            $this->available_from = Yii::$app->formatter->asDate($this->available_from);
        }

        return $this->available_from;
    }

    /**
     * Returns the url of the real-estate
     *
     * @return  string  $url
     */
    public function getUrl()
    {
        $url = Yii::getAlias('@baseUrl') . '/';

        if (Yii::$app->hasModule('skarabee')) {
            $module = Yii::$app->getModule('skarabee');
    
            if ($module->realEstateUrlPrefix) {
                $url .= Yii::t('url', $module->realEstateUrlPrefix) . '/';
            }
        }

        $url .= "{$this->id}";

        return $url;
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
