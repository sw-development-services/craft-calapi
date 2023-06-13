<?php

namespace swdevelopment\craftcalapi\migrations;

use Craft;
use craft\db\Migration;
use swdevelopment\craftcalapi\records\BookingRecord;

/**
 * m230509_000440_alter_cal_bookings_add_cols_1 migration.
 */
class m230509_000440_alter_cal_bookings_add_cols_1 extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->addColumn( BookingRecord::$tableName, 'title', $this->string(255)->null() );
        $this->addColumn( BookingRecord::$tableName, 'description', $this->string(255)->null() );
        $this->addColumn( BookingRecord::$tableName, 'status', $this->boolean()->notNull()->defaultValue(true) );
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m230509_000440_alter_cal_bookings_add_cols_1 cannot be reverted.\n";
        return false;
    }
}
