<?php

use yii\db\Schema;
use yii\db\Migration;

class m150925_114446_add_pdf_path_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%real_estates}}', 'pdf_path', Schema::TYPE_STRING.'(255) NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%real_estates}}', 'pdf_path');
    }
}
