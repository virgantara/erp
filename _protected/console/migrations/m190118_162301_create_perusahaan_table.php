<?php
use yii\db\Migration;

class m190118_162301_create_perusahaan_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%perusahaan}}', [
            'id_perusahaan' => $this->primaryKey(),
            'nama' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull(),
            'alamat' => $this->string()->notNull(),
            'telp' => $this->string()->notNull(),
            'jenis' => $this->integer()->notNull(),
            'level' => $this->integer()->notNull(),
            
            
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
