<?php
use yii\db\Migration;

class m141022_116001_create_perusahaan_table extends Migration
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
            'jenis' => $this->string()->notNull(),
            'level' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%perusahaan}}');
    }
}
