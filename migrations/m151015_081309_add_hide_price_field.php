<?php

use yii\db\Migration;
use yii\db\Schema;

class m151015_081309_add_hide_price_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%real_estates}}', 'hide_price', Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%real_estates}}', 'hide_price');
    }
}
