<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fruits}}`.
 */
class m230305_105442_create_fruits_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fruits}}', [
            'id' => $this->primaryKey(),
            'genus' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'family' => $this->string(255)->notNull(),
            'order' => $this->string(255)->notNull(),
            'n_carbohydrates' => $this->decimal(10,2)->notNull(),
            'n_protein' => $this->decimal(10,2)->notNull(),
            'n_fat' => $this->decimal(10,2)->notNull(),
            'n_calories' => $this->integer()->notNull(),
            'n_sugar' => $this->decimal(10,2)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fruits}}');
    }
}
