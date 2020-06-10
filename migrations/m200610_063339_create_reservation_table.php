<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reservation}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m200610_063339_create_reservation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reservation}}', [
            'id' => $this->primaryKey(),
            'datatime_created' => $this->datetime()->notNull(),
            'data_arrival' => $this->date(),
            'status' => $this->boolean()->defaultValue(0)->notNull(),
            'user_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-reservation-user_id}}',
            '{{%reservation}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-reservation-user_id}}',
            '{{%reservation}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-reservation-user_id}}',
            '{{%reservation}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-reservation-user_id}}',
            '{{%reservation}}'
        );

        $this->dropTable('{{%reservation}}');
    }
}
