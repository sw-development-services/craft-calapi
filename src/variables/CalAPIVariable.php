<?php
    namespace swdevelopment\craftcalapi\variables;


    use Craft;
    use craft\helpers\App;
    use craft\helpers\UrlHelper;

    use swdevelopment\craftcalapi\CalApi;

    use yii\di\ServiceLocator;          // used for determining service or component : https://www.yiiframework.com/doc/guide/2.0/en/concept-service-locator



/**
 * More info about Variables...
 *
 * https://doublesecretagency.github.io/craft-businesslogic/variables
 */

/**
 * Craft Variable
 *
 * Variables are the easy stuff, the "low hanging fruit". This file gives you an easy way to
 * spit data out into your Twig templates. That data can take basically any form... whether it's
 * an array, a string, an integer, or even an object. Any type of PHP variable can be passed
 * through a Variable method back to your Twig template.
 *
 * While it's not always necessary, it is common practice to simply use your variables as a
 * wrapper for corresponding Service methods. Especially if you need to interact with the
 * database at all... don't do that here!
 */

class CalAPIVariable
{

    /**
     * Whatever you want to output to a Twig template
     * can go into a Variable method.
     *
     * HOW TO USE IT
     * From any Twig template, call it like this:
     *
     *     {{ craft.businessLogic.exampleVariable }}
     *
     * Or, if your variable requires input from Twig:
     *
     *     {{ craft.businessLogic.exampleVariable(twigValue) }}
     *
     */

    public $config;    

    public function init(){
        
        // parent::init();

        $configSettings = CalApi::getInstance()->getSettings();

        $this->config = $configSettings;    

    } 
    public function exampleVariable( $optional = null )
    {
        return "And away we go to the Twig template...";
    }

    public function getAPIKey()
    {
        if (strpos(CalApi::getInstance()->getSettings()->apiKey, '$') !== false) {
            return getenv( substr( CalApi::getInstance()->getSettings()->apiKey, 1 ) );
        }
        return CalApi::getInstance()->getSettings()->apiKey;
    }

    public function getSettings(){
        return CalApi::getInstance()->getSettings();
    }

    public function getPluginName(){
        return CalApi::$plugin->name;
    }

    /**
     * These are used for accessing data in the twig templates
     * @return mixed
     */
 
    public function getBookings()
    {
        // this will get all the bookings from the Cal.com API. This may take a while to process
        // call the service
        $bookings =  CalApi::getInstance()->cal->GetBookings();
        return json_decode($bookings, true);
    }

    public function getLastBookingSync(){
        $data = CalApi::getInstance()->booking->getLastSync();
        return $data;
    }

    /**
     * 
     * Get all the bookings in Craft
     * @return mixed
     */
    public function getAllBookings(){
        return CalApi::getInstance()->booking->getAllBookings();
    }

    public function getSyncedBookings(){
        return CalApi::getInstance()->booking->getSyncedBookings();
    }

    public function getBookingsPastDaysCount($days)
    {
        return CalApi::getInstance()->booking->getBookingsLastDays($days);
    }

    public function getEventTypes()
    {
        return CalApi::getInstance()->cal->GetEventTypes();
    }

}
