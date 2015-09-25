<?php

use yii\db\Schema;
use yii\db\Migration;

class m150924_114445_add_downloads_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%real_estates}}', 'downloads', Schema::TYPE_TEXT.' NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%real_estates}}', 'downloads');
    }
}
