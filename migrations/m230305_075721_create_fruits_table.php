<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fruits}}`.
 */
class m230305_075721_create_fruits_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('fruits', [
            'id' => $this->primaryKey(),
            'genus' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'family' => $this->string()->notNull(),
            'order' => $this->string()->notNull(),
            'n_carbohydrates' => $this->decimal(10, 2)->notNull(),
            'n_protein' => $this->decimal(10, 2)->notNull(),
            'n_fat' => $this->decimal(10, 2)->notNull(),
            'n_calories' => $this->integer()->notNull(),
            'n_sugar' => $this->decimal(10, 2)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('fruits');
    }
}
?>