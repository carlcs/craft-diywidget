<?php

namespace carlcs\diywidget\migrations;

use craft\db\Migration;

class m180529_000000_craft3 extends Migration
{
    public function safeUp(): bool
    {
        $this->delete('{{%widgets}}', ['type' => ['DiyWidget']]);
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180529_000000_craft3 cannot be reverted.\n";
        return false;
    }
}
