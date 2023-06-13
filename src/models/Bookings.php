<?php

namespace swdevelopment\craftcalapi\models;

use craft\base\Model;

class Bookings extends Model
{
    public $email;

    public $name;

    public $date;

    public $time;

    public $status;

    public $description;

    public $title;
    


    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [
            ['email, name'],
            'string',
            'required'
        ];
        return $rules;
    }


}
