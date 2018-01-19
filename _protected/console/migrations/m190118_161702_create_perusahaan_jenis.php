<?php

use yii\db\Migration;

class m190118_161702_create_perusahaan_jenis extends Migration
{
    public function safeUp()
    {
        $this->createTable('perusahaan_jenis', [
            'id' => $this->primaryKey(),
            'kode' => $this->string(50)->notNull()->unique(),
            'nama' => $this->string(255)->notNull()->unique(),
        ]);

        $this->alterColumn('{{%perusahaan_jenis}}', 'id', $this->integer().' NOT NULL AUTO_INCREMENT');

        $this->batchInsert('perusahaan_jenis', 
            ['kode','nama'],
            [
                ['HD','Holding'],
                ['JS','Jasa'],
                ['TD','Penjualan'],
                ['MN','Manufaktur'],
            ]
        );

    
    }

    public function safeDown()
    {
        $this->dropTable('perusahaan_jenis');
    }
}