<?php

namespace swdevelopment\craftcalapi\models;

use Craft;
use craft\base\Model;
use craft\helpers\App;

/**
 * cal.com settings
 */
class Settings extends Model
{
    // refer to https://cal.com/docs/enterprise-features/api/types about the different data types

    /**
     * @var string user account
     */
    public $username;

    /**
     * Summary of email
     * @var string
     */
    public $email;

    /**
     * Summary of apikey
     * @var string
     */
    public $apiKey;

    /**
     * Summary of webhookSecret
     * @var string
     */
    public $webhookSecret;

    /**
     * Summary of useStripe
     * @var bool
     */
    public $useStripe = true;

    /**
     * Summary of stripeSecret
     * @var string
     */
    public $stripeSecret;

    public function defineRules() :array{
        return [
            [['email', 'username', 'apiKey'], 'required']
        ];
    }

    public function getApiKey(){
        App::parseEnv($this->apiKey);
    }

}
