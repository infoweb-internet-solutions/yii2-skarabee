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
        try {
            // Init stats
            $stats = [
                'publicationsCount'     => 0,
                'processedPublications' => 0,
                'importedPublications'  => 0,
                'createdPublications'   => 0,
                'updatedPublications'   => 0,
                'deletedPublications'   => 0,
                'sentPublications'      => []
            ];
            
            // Load the publications
            $publications = Yii::$app->skarabee->getAll();
            $stats['publicationsCount'] = count($publications);
            
            // Start progress bar
            Console::startProgress(0, $stats['publicationsCount'], 'Importing: ', false);
            
            foreach ($publications as $publication) {
                
                // Process only 5 publications for testing
                if ($stats['processedPublications'] >= 1)
                    continue;
                
                // Add the id to the sent publications array
                $stats['sentPublications'][] = $publication['ID'];
                
                // Get the publication details
                $item = Yii::$app->skarabee->get($publication['ID']);
                
                // Try to load the real estate from the database
                $estate = RealEstate::findOne($item['Info']['ID']);
                
                // Initialize a new real estate if none was found in the database
                if (!$estate)
                    $estate = new RealEstate;
                
                // The 'Info' attribute must be set
                if (isset($item['Info'])) {
    
                    // Set real estate attributes and save
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
                    $estate->created_in_skarabee_at = (isset($item['Info']['Created'])) ? strtotime($item['Info']['Created']) : 0;
                    $estate->updated_in_skarabee_at = (isset($item['Info']['Modified'])) ? strtotime($item['Info']['Modified']) : 0;
                    
                    if (!$estate->save())
                        throw new \Exception("Error while saving publication #{$item['Property']['ID']}");
                    
                    // Only import pictures for publications that are enabled
                    if ((int) $item['Info']['Enabled'] == 1) {           
                        // Pictures are provided
                        if (isset($item['Pictures']) && isset($item['Pictures']['Picture'])) {
                            
                            // Remove the current images
                            $estate->removeImages();
                            
                            // There is only one picture provided
                            if (is_array($item['Pictures']['Picture']) && isset($item['Pictures']['Picture']['Index'])) {
    
                                $picture = $item['Pictures']['Picture'];
                                
                                if (!$estate->attachSkarabeeImage($picture, true))
                                    throw new \Exception("Error while saving image #{$item['Pictures']['Picture']['Index']} of publication #{$item['Property']['ID']}");
                                
                            // Multiple pictures are provided        
                            } else {
    
                                // Add the pictures
                                foreach ($item['Pictures']['Picture'] as $k => $picture) {
                                    if (!$estate->attachSkarabeeImage($picture, ($k == 0) ? true : false))
                                        throw new \Exception("Error while saving image #{$k} of publication #{$item['Property']['ID']}");
                                }    
                            }    
                        }
                    }
      
                    $stats['importedPublications']++;
                }
    
                $stats['processedPublications']++;
                
                // Update progress bar
                Console::updateProgress($stats['processedPublications'], $stats['publicationsCount']);                 
            }
    
            Console::endProgress();
            
            // Delete publications that are no longer sent
            $estates = RealEstate::find()->all();
            
            foreach ($estates as $estate) {
                if (!in_array($estate->id, $stats['sentPublications'])) {
                    $estate->delete();
                    $stats['deletedPublications']++;
                }
            }       
    
            // Display info
            $imported = $this->ansiFormat($stats['importedPublications'], Console::FG_GREEN);
            $created = $this->ansiFormat($stats['createdPublications'], Console::FG_YELLOW);
            $updated = $this->ansiFormat($stats['updatedPublications'], Console::FG_GREY);
            $deleted = $this->ansiFormat($stats['deletedPublications'], Console::FG_CYAN);
            $this->stdout("{$imported} real estates were imported".PHP_EOL);
            $this->stdout("{$created} real estates were created".PHP_EOL);
            $this->stdout("{$updated} real estates were updated".PHP_EOL);
            $this->stdout("{$deleted} real estates were deleted".PHP_EOL);
            
            // Log info
            Yii::info("{$stats['importedPublications']} real estates were imported", 'skarabee');
            Yii::info("{$stats['createdPublications']} real estates were created", 'skarabee');
            Yii::info("{$stats['updatedPublications']} real estates were updated", 'skarabee');
            Yii::info("{$stats['deletedPublications']} real estates were deleted", 'skarabee');
            
            return Controller::EXIT_CODE_NORMAL;    
        } catch (\Exception $e) {
            $msg = $this->ansiFormat($e->getMessage(), Console::FG_RED, Console::BOLD);
            Yii::error($e->getMessage(), 'skarabee');
            return Controller::EXIT_CODE_ERROR;    
        }
    }  
}