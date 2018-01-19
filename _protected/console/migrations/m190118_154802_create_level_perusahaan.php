<?php

use yii\db\Migration;

class m190118_154802_create_level_perusahaan extends Migration
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
            'nama' => 'Holding',
            'level' => 1,
        ]);

        $this->insert('perusahaan_level', [
            'nama' => 'Pusat',
            'level' => 2,
        ]);

        $this->insert('perusahaan_level', [
            'nama' => 'Cabang',
            'level' => 3,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('perusahaan_level');
    }
}