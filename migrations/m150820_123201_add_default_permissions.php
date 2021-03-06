<?php

use yii\db\Migration;

class m150820_123201_add_default_permissions extends Migration
{
    public function up()
    {
        // Create the auth items
        $this->insert('{{%auth_item}}', [
            'name'          => 'showSkarabeeModule',
            'type'          => 2,
            'description'   => 'Show Skarabee module in main-menu',
            'created_at'    => time(),
            'updated_at'    => time()
        ]);
        
        // Create the auth item relation
        $this->insert('{{%auth_item_child}}', [
            'parent'        => 'Superadmin',
            'child'         => 'showSkarabeeModule'
        ]);
    }

    public function down()
    {
        // Delete the auth item relation
        
        $this->delete('{{%auth_item_child}}', [
            'parent'        => 'Superadmin',
            'child'         => 'showSkarabeeModule'
        ]);

        // Delete the auth items
        $this->delete('{{%auth_item}}', [
            'name'          => 'showSkarabeeModule',
            'type'          => 2,
        ]);
    }
}
