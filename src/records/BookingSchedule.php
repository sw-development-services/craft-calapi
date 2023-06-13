<?php

namespace swdevelopment\craftcalapi\records;

use Craft;
use craft\db\ActiveRecord;



/**
 * Summary of BookingSchedule
 * @author Tim Strawbridge
 * @copyright (c) 2023
 * @property int $id
 * @property int $records_added
 * 
 */



class BookingSchedule extends ActiveRecord
{
    public static $tableName = '{{%cal_booking_schedule}}';

    /**
     * Summary of tableName
     * @return string
     */
    public static function tableName(): string
    {
        return self::$tableName;
    }
}
