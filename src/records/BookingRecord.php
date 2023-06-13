<?php

namespace swdevelopment\craftcalapi\records;

use Craft;
use craft\db\ActiveRecord;


  /**
   * Summary of BookingRecord
   * @author Tim Strawbridge
   * @copyright (c) 2023
   * @property int $id
   * @property string $email
   * @property string $name
   * @property string $date
   * @property string $time
   * @property string $description
   * @property string $title
   * @property boolean $status
   * @property int $cal_booking_id
   * 
   */


class BookingRecord extends ActiveRecord
{
    /**
     * Summary of tableName
     * @var string
     */
    public static $tableName = '{{%cal_bookings}}';

    /**
     * Summary of tableName
     * @return string
     */
    public static function tableName(): string
    {
        return self::$tableName;
    }

}
