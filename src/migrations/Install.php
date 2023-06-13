<?php

namespace swdevelopment\craftcalapi\migrations;

use Craft;
use craft\db\Migration;
use swdevelopment\craftcalapi\records\BookingSchedule;
use swdevelopment\craftcalapi\records\BookingRecord;

/**
 * Install migration.
 */
class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // create table
        $this->createTable(
            BookingRecord::$tableName,
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'email' => $this->string(255)->notNull(),
                'date' => $this->string(255)->null(),
                'time' => $this->string(255)->null(),
                'title' => $this->string(255)->null(),
                'description' => $this->string(255)->null(),
                'status' => $this->boolean()->notNull()->defaultValue(true),
                'cal_booking_id' => $this->bigInteger()->notNull(),
                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
            ]
        );

        $this->createTable(
            BookingSchedule::$tableName,
            [
                'id' => $this->primaryKey(),
                'records_added' => $this->integer()->notNull(),
                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
            ]
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        // Place uninstallation code here...

        return true;
    }
}
