<?php
use yii\db\Migration;

class m200118_200003_create_ak_transaksi_harian extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ak_transaksi_harian}}', [
            'id' => $this->primaryKey(),
            
            'nama_transaksi' => $this->string()->notNull(),
            'debet' => $this->double()->defaultValue(0),
            'kredit' => $this->double()->defaultValue(0),
            'updated_at' => 'timestamp on update current_timestamp',
            'created_at' => $this->dateTime() . ' DEFAULT NOW()',      
            
            
        ], $tableOptions);

        $this->createIndex(
            'idx-jenis_pid',
            'perusahaan',
            'jenis'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-jenis_pid',
            'perusahaan',
            'jenis',
            'perusahaan_jenis',
            'id',
            'CASCADE'
        );

        $this->batchInsert('perusahaan', 
            ['nama','email','alamat','telp','jenis','level'],
            [
                ['PT Trisna Group','trisna.group@gmail.com','Jl Soekarno Hatta 1 Katang, Kediri','0354 123456',1,1],
            ]
        );

    }

    public function down()
    {
        $this->dropTable('{{%perusahaan}}');
    }
}
