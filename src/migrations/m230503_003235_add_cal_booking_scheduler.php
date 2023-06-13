<?php

namespace swdevelopment\craftcalapi\migrations;

use Craft;
use craft\db\Migration;

use swdevelopment\craftcalapi\records\BookingSchedule;

/**
 * m230503_003235_add_cal_booking_scheduler migration.
 */
class m230503_003235_add_cal_booking_scheduler extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->dropTableIfExists(BookingSchedule::$tableName);

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
        echo "m230503_003235_add_cal_booking_scheduler cannot be reverted.\n";
        return false;
    }
}
