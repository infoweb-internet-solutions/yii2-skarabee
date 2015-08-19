<?php

use yii\db\Migration;
use yii\db\Schema;

class m150819_124050_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%real_estates}}', [
            'id'                                    => Schema::TYPE_PK,
            'property_id'                           => Schema::TYPE_INTEGER . ' UNSIGNED',
            'street'                                => Schema::TYPE_STRING . '(255)',
            'house_number'                          => Schema::TYPE_STRING . '(20)',
            'house_number_extension'                => Schema::TYPE_STRING . '(20)',
            'mailbox'                               => Schema::TYPE_STRING . '(20)',
            'zipcode'                               => Schema::TYPE_STRING . '(20)',
            'city'                                  => Schema::TYPE_STRING . '(255)',
            'market_type'                           => Schema::TYPE_STRING . '(25)',
            'type'                                  => Schema::TYPE_STRING . '(25)',
            'status'                                => Schema::TYPE_STRING . '(25)',
            'type'                                  => Schema::TYPE_STRING . '(25)',
            'typo_characterisation'                 => Schema::TYPE_STRING . '(25)',
            'price'                                 => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',       
            'price_type'                            => Schema::TYPE_STRING . '(25)',
            'reference'                             => Schema::TYPE_STRING . '(255)',
            'construction_year'                     => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'cadastrall_income'                     => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'flash_title'                           => Schema::TYPE_TEXT . '',
            'flash_text'                            => Schema::TYPE_TEXT . '',
            'conditional_sold'                      => Schema::TYPE_STRING . '(25)',
            'area'                                  => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'land_area'                             => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'heating_type'                          => Schema::TYPE_STRING . '(25)',
            'restriction_comment'                   => Schema::TYPE_TEXT . '',
            'communal_expenses'                     => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'floor_level'                           => Schema::TYPE_STRING . '(25)',
            'available_from'                        => Schema::TYPE_TEXT . '',
            'has_garage'                            => Schema::TYPE_STRING . '(25)',
            'has_terrace'                           => Schema::TYPE_STRING . '(25)',
            'has_garden'                            => Schema::TYPE_STRING . '(25)',
            'has_elevator'                          => Schema::TYPE_STRING . '(25)',
            'number_of_floors'                      => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'number_of_bedrooms'                    => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'number_of_bathrooms'                   => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'number_of_parking_places'              => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'number_of_offices'                     => Schema::TYPE_SMALLINT . ' UNSIGNED DEFAULT 0',
            'surface_living'                        => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'surface_garden'                        => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'surface_kitchen'                       => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'surface_livable'                       => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'new_estate'                            => Schema::TYPE_STRING . '(25)',
            'special_type'                          => Schema::TYPE_STRING . '(25)',
            'urban_development_permit'              => Schema::TYPE_STRING . '(25)',
            'urban_development_summons'             => Schema::TYPE_STRING . '(25)',
            'urban_development_preemptive_rights'   => Schema::TYPE_STRING . '(25)',
            'urban_development_allotment_permit'    => Schema::TYPE_STRING . '(25)',
            'urban_development_area_application'    => Schema::TYPE_STRING . '(25)',
            'urban_development_judicial_decision'   => Schema::TYPE_STRING . '(25)',
            'urban_development_permit'              => Schema::TYPE_STRING . '(25)',
            'energy_index'                          => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'energy_class_end_date'                 => Schema::TYPE_STRING . '(25)',
            'energy_class'                          => Schema::TYPE_STRING . '(25)',
            'energy_certificate_nr'                 => Schema::TYPE_STRING . '(25)',
            'orientation'                           => Schema::TYPE_STRING . '(50)',
            'nearby_public_transport'               => Schema::TYPE_STRING . '(25)',
            'nearby_shops'                          => Schema::TYPE_STRING . '(25)',
            'nearby_school'                         => Schema::TYPE_STRING . '(25)',
            'nearby_highway'                        => Schema::TYPE_STRING . '(25)',
            'address_position_x'                    => Schema::TYPE_STRING . '(25)',
            'address_position_y'                    => Schema::TYPE_STRING . '(25)',
            'renovation_year'                       => Schema::TYPE_STRING . '(25)',
            'real_estate_tax'                       => Schema::TYPE_DECIMAL . '(14,4) UNSIGNED DEFAULT 0',
            'enabled'                               => Schema::TYPE_BOOLEAN . ' UNSIGNED DEFAULT 0',
            'active'                                => Schema::TYPE_BOOLEAN . ' UNSIGNED DEFAULT 0',
            'created_at'                            => Schema::TYPE_BOOLEAN . ' UNSIGNED DEFAULT 0',
            'updated_at'                            => Schema::TYPE_BOOLEAN . ' UNSIGNED DEFAULT 0',
            'disabled_at'                           => Schema::TYPE_BOOLEAN . ' UNSIGNED DEFAULT 0',
            'created_in_skarabee_at'                => Schema::TYPE_INTEGER . ' UNSIGNED DEFAULT 0',
            'updated_in_skarabee_at'                => Schema::TYPE_INTEGER . ' UNSIGNED DEFAULT 0',

        ], $tableOptions);
        
        $this->createIndex('property_id', '{{%real_estates}}', 'property_id');
        
        $this->createTable('{{%skarabee}}', [
            'last_synchronisation' => Schema::TYPE_INTEGER . ' UNSIGNED',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('real_estates');
        $this->dropTable('skarabee');    
    }
}
