<?php

use yii\db\Migration;

class m190118_154801_create_level_perusahaan extends Migration
{
    public function safeUp()
    {
        $this->createTable('perusahaan_level', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'level' => $this->integer()->notNull(),
        ]);

        $this->alterColumn('{{%perusahaan_level}}', 'id', $this->smallInteger(8).' NOT NULL AUTO_INCREMENT');

        $this->insert('perusahaan_level', [
            'nama' => 'Pusat',
            'level' => 1,
        ]);
    }

    public function safeDown()
    {
        $this->delete('perusahaan_level', ['id' => 1]);
        $this->dropTable('perusahaan_level');
    }
}