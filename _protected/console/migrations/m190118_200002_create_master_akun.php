<?php

use yii\db\Migration;

class m190118_200002_create_master_akun extends Migration
{
    public function safeUp()
    {
        $this->createTable('master_akun', [
            'kode_akun' => $this->string(8)->notNull(),
            'uraian_akun' => $this->string(50)->notNull()->unique(),
        ]);

        $this->alterColumn('{{%master_akun}}', 'kode_akun', $this->string(8).' PRIMARY KEY');

        $this->batchInsert('master_akun', 
            ['kode_akun','uraian_akun'],
            [
                ['10000000','Aset Lancar'],
                ['20000000','Aset Tidak Lancar'],
                ['30000000','Hutang Lancar'],
                ['40000000','Hutang Tidak Lancar'],
                ['50000000','Modal'],
                ['60000000','Pendapatan & HPP'],
                ['70000000','Biaya Operasional'],
                ['80000000','Pendapatan & Biaya, Pajak'],
            ]
        );

    
    }

    public function safeDown()
    {
        $this->dropTable('master_akun');
    }
}