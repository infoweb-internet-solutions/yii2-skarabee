<?php

namespace infoweb\skarabee\console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;
use infoweb\skarabee\models\RealEstate;

/**
 * Manages communication with the Skarabee Weblink API
 */
class SkarabeeController extends Controller
{
    /**
     * Imports publications from Skarabee into the database
     * 
     * @return  int
     */   
    public function actionImport()
    {
        // Init stats
        $stats = [
            'publicationsCount'     => 0,
            'processedPublications' => 0,
            'importedPublications'  => 0,
            'existingPublications'  => []
        ];
        
        // Load the publications
        $publications = Yii::$app->skarabee->getAll();
        $stats['publicationsCount'] = count($publications);
        
        // Start progress bar
        Console::startProgress(0, $stats['publicationsCount'], 'Importing: ', false);
        
        foreach ($publications as $publication) {
            
            //if ($publication['ID'] != '4023584')
                //continue;
            
            // Add the id to the existing publications array
            $stats['existingPublications'][] = $publication['ID'];
            
            // Get the publication details
            $item = Yii::$app->skarabee->get($publication['ID']);
            
            // Try to load the real estate from the database
            $estate = RealEstate::findOne($item['Info']['ID']);
            
            // Initialize a new real estate if none was found in the database
            if (!$estate)
                $estate = new RealEstate;
            
            // The 'Info' attribute must be set
            if (isset($item['Info'])) {

                // Set real estate attributes
                $estate->id = $item['Info']['ID'];
                $estate->property_id = $item['Property']['ID'];
                $estate->street = (isset($item['Property']['Address']) && isset($item['Property']['Address']['Street'])) ? $item['Property']['Address']['Street'] : '';
                $estate->house_number = (isset($item['Property']['Address']) && isset($item['Property']['Address']['HouseNumber'])) ? $item['Property']['Address']['HouseNumber'] : '';
                $estate->house_number_extension = (isset($item['Property']['Address']) && isset($item['Property']['Address']['HouseNumberExtension'])) ? $item['Property']['Address']['HouseNumberExtension'] : '';
                $estate->mailbox = (isset($item['Property']['Address']) && isset($item['Property']['Address']['MailBox'])) ? $item['Property']['Address']['MailBox'] : '';
                $estate->zipcode = (isset($item['Property']['Address']) && isset($item['Property']['Address']['City']['ZipCode'])) ? $item['Property']['Address']['City']['ZipCode'] : '';
                $estate->city = (isset($item['Property']['Address']) && isset($item['Property']['Address']['City']) && isset($item['Property']['Address']['City']['_'])) ? $item['Property']['Address']['City']['_'] : '';
                $estate->market_type = $item['Property']['MarketType'];
                $estate->type = $item['Property']['Type'];
                $estate->status = $item['Property']['Status'];
                $estate->typo_characterisation = (isset($item['Property']['Typo'])) ? $item['Property']['Typo']['Characterisation'] : '';
                $estate->price = $item['Property']['Price'];
                $estate->reference = (isset($item['Property']['Reference'])) ? $item['Property']['Reference'] : '';
                $estate->construction_year = $item['Property']['ConstructionYear'];
                $estate->cadastrall_income = $item['Property']['CadastrallIncome'];
                $estate->flash_title = (isset($item['Property']['Flashes']) && isset($item['Property']['Flashes']['Flash']) && isset($item['Property']['Flashes']['Flash']['Title'])) ? $item['Property']['Flashes']['Flash']['Title'] : '';
                $estate->flash_text = (isset($item['Property']['Flashes']) && isset($item['Property']['Flashes']['Flash']) && isset($item['Property']['Flashes']['Flash']['Text'])) ? $item['Property']['Flashes']['Flash']['Text'] : '';
                $estate->conditional_sold = $item['Property']['ConditionalSold'];
                $estate->area = $item['Property']['Area'];
                $estate->land_area = $item['Property']['LandArea'];
                $estate->heating_type = (isset($item['Property']['HeatingTypes']) && isset($item['Property']['HeatingTypes']['HeatingType'])) ? $item['Property']['HeatingTypes']['HeatingType'] : '';
                $estate->restriction_comment = (isset($item['Property']['RestrictionComment'])) ? $item['Property']['RestrictionComment'] : '';
                $estate->communal_expenses = $item['Property']['CommunalExpenses'];
                $estate->floor_level = (isset($item['Property']['FloorLevelNL'])) ? $item['Property']['FloorLevelNL'] : '';
                $estate->available_from = (isset($item['Property']['Dates']) && isset($item['Property']['Dates']['AvailableFromText'])) ? $item['Property']['Dates']['AvailableFromText'] : '';
                $estate->has_garage = $item['Property']['HasGarage'];
                $estate->has_garden = $item['Property']['HasGarden'];
                $estate->has_terrace = $item['Property']['HasTerrace'];
                $estate->has_elevator = $item['Property']['HasElevator'];
                $estate->number_of_floors = $item['Property']['NumberOfFloors'];
                $estate->number_of_bedrooms = $item['Property']['NumberOfBedrooms'];
                $estate->number_of_bathrooms = $item['Property']['NumberOfBathrooms'];
                $estate->number_of_parking_places = $item['Property']['NumberOfParkingPlaces'];
                $estate->number_of_offices = $item['Property']['NumberOfOffices'];
                $estate->surface_living = $item['Property']['SurfaceLiving'];
                $estate->surface_garden = $item['Property']['SurfaceGarden'];
                $estate->surface_kitchen = $item['Property']['SurfaceKitchen'];
                $estate->surface_livable = $item['Property']['SurfaceLivable'];
                $estate->new_estate = $item['Property']['NewEstate'];
                $estate->special_type = $item['Property']['SpecialType'];
                $estate->urban_development_permit = (isset($item['Property']['UrbanDevelopment'])) ? $item['Property']['UrbanDevelopment']['Permit'] : '';
                $estate->urban_development_summons = (isset($item['Property']['UrbanDevelopment'])) ? $item['Property']['UrbanDevelopment']['Summons'] : '';
                $estate->urban_development_preemptive_rights = (isset($item['Property']['UrbanDevelopment'])) ? $item['Property']['UrbanDevelopment']['PreemptiveRights'] : '';
                $estate->urban_development_allotment_permit = (isset($item['Property']['UrbanDevelopment'])) ? $item['Property']['UrbanDevelopment']['AllotmentPermit'] : '';
                $estate->urban_development_area_application = (isset($item['Property']['UrbanDevelopment']) && isset($item['Property']['UrbanDevelopment']['AreaApplication'])) ? $item['Property']['UrbanDevelopment']['AreaApplication']['Code'] : '';
                $estate->urban_development_judicial_decision = (isset($item['Property']['UrbanDevelopment'])) ? $item['Property']['UrbanDevelopment']['JudicialDecision'] : '';
                $estate->energy_index = (isset($item['Property']['Energy'])) ? $item['Property']['Energy']['Index'] : 0;
                $estate->energy_class_end_date = (isset($item['Property']['Energy']) && isset($item['Property']['Energy']['ClassEndDate'])) ? $item['Property']['Energy']['ClassEndDate'] : '';
                $estate->energy_class = (isset($item['Property']['Energy'])) ? $item['Property']['Energy']['Class'] : '';
                $estate->energy_certificate_nr = (isset($item['Property']['Energy']) && isset($item['Property']['Energy']['EnergyCertificateNr'])) ? $item['Property']['Energy']['EnergyCertificateNr'] : '';
                $estate->orientation = $item['Property']['Orientation'];
                $estate->nearby_public_transport = $item['Property']['NearbyPublicTransport'];
                $estate->nearby_shops = $item['Property']['NearbyShops'];
                $estate->nearby_school = $item['Property']['NearbySchool'];
                $estate->nearby_highway = $item['Property']['NearbyHighway'];
                $estate->address_position_x = (isset($item['Property']['Address']) && isset($item['Property']['Address']['Position']) && isset($item['Property']['Address']['Position']['X'])) ? $item['Property']['Address']['Position']['X'] : '';
                $estate->address_position_y = (isset($item['Property']['Address']) && isset($item['Property']['Address']['Position']) && isset($item['Property']['Address']['Position']['Y'])) ? $item['Property']['Address']['Position']['Y'] : '';
                $estate->enabled = (int) $item['Info']['Enabled'];
                $estate->active = (int) $item['Property']['Active'];
                $estate->renovation_year = $item['Property']['RenovationYear'];
                $estate->real_estate_tax = $item['Property']['RealEstateTax'];
                $estate->created_in_skarabee_at = (isset($item['Info']['Created'])) ? $item['Info']['Created'] : 0;
                $estate->updated_in_skarabee_at = (isset($item['Info']['Modified'])) ? $item['Info']['Modified'] : 0;
                
                if (!$estate->save())
                    throw new \Exception('Error while saving');
                    
                    
                $stats['importedPublications']++;
            }

            $stats['processedPublications']++;
            
            // Update progress bar
            Console::updateProgress($stats['processedPublications'], $stats['publicationsCount']);                 
        }

        Console::endProgress();

        $imported = $this->ansiFormat($stats['importedPublications'], Console::FG_GREEN);
        $this->stdout("Imported {$imported} real estates");
        
        return Controller::EXIT_CODE_NORMAL;
    }  
}