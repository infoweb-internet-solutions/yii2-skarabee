<?php

use yii\db\Migration;
use yii\db\Schema;

class m150921_124050_add_real_estate_type extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%real_estate_type}}', [
            'id'                                    => Schema::TYPE_STRING . '(255) NOT NULL',
            'name'                                  => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_at'                            => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at'                            => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',

        ], $tableOptions);

        $this->addPrimaryKey('id', '{{%real_estate_type}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('real_estate_type');
    }
}
