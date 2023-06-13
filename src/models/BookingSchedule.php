<?php

namespace swdevelopment\craftcalapi\models;

use craft\base\Model;

class BookingSchedule extends Model
{
    public $date;
    public $records_added;


    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [];
        return $rules;
    }


}
