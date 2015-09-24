<?php

use yii\db\Schema;
use yii\db\Migration;

class m150924_114509_correct_timestamps extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%real_estates}}', 'created_at', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn('{{%real_estates}}', 'updated_at', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn('{{%real_estates}}', 'disabled_at', Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0');    
    }

    public function safeDown()
    {
        return false;    
    }
}
