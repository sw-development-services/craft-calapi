<?php

namespace swdevelopment\craftcalapi\migrations;

use Craft;
use craft\db\Migration;
use swdevelopment\craftcalapi\records\BookingRecord;

/**
 * m230430_040000_db_table_setup migration.
 */
class m230430_040000_db_table_setup extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->dropTableIfExists(BookingRecord::$tableName);

        // setup table
        $this->createTable(
            BookingRecord::$tableName,
            [
                'id' => $this->integer()->notNull(),
                'name' => $this->string(255)->notNull(),
                'email' => $this->string(255)->notNull(),
                'date' => $this->string(255)->null(),
                'time' => $this->string(255)->null(),
                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
                'PRIMARY KEY([[id]])',
            ]
        );


        if( Craft::$app->projectConfig->get('plugins.calapi') === null ){
            // some changes would go here

        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropTableIfExists(BookingRecord::$tableName);
        // echo "m230430_040000_db_table_setup cannot be reverted.\n";
        // return false;
    }
}
