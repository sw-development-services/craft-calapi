<?php
namespace swdevelopment\craftcalapi\services;

use craft\base\Component;
use craft\web\Response;

use craft\events\ExceptionEvent;
use craft\helpers\ArrayHelper;
use craft\helpers\UrlHelper;

use craft\helpers\Json;

use swdevelopment\craftcalapi\CalApi;
use swdevelopment\craftcalapi\models\Settings;
use swdevelopment\craftcalapi\records\BookingRecord;


class Cal extends Component
{

    /**
     * This function can literally be anything you want.
     *
     * HOW TO USE IT
     * From any other plugin or module file, call it like this:
     *
     *     BusinessLogic::$instance->example->exampleService()
     *
     */
 
    public $target_url;
    public $api_version;
    public $endpoint;

    private $parameter_term;


     public function __construct()
     {
        $config = include(__DIR__ . '/../config.php');

        $this->target_url = $config['target_endpoint_url'];
        $this->api_version = $config['api_version'];
        $this->parameter_term = 'apiKey';

     }

    public function GetBookings()
    {
        $type = 'bookings';
        // grab api key
        $apiKey = $this->getAPIKey();
        $endpoint = $this->target_url . $this->api_version . '/'.$type.'/?'. $this->parameter_term . '='.$apiKey;
        
        $curl = curl_init();
        $curlRequest = $this->sendRequest($curl, $endpoint);

        if (!curl_errno($curl) && curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
            $json = json_decode($curlRequest);
            if(count($json->bookings) > 0){
                curl_close($curl);
                return Json::encode($json);        
            }
        }

        curl_close($curl);
        // print_r(json_decode($response));
        return 'No Results';
    }

    public function sendRequest($curl, $endpoint)
    {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

       return curl_exec($curl);
    }

    public function sendPost($curl, $endpoint, $data)
    {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));

       return curl_exec($curl);
    }

    public function GetSchedule()
    {
        // 
    }

    public function GetAttendees()
    {
        // 
    }

    private function addKeyToUrl()
    {
        
    }

    /**
     * Summary of GetEventTypes
     * This will get the Cal.com events
     * 
     * @return void
     */
    public function GetEventTypes()
    {
        $type = 'event-types';
        // grab api key
        $apiKey = $this->getAPIKey();
        $endpoint = $this->target_url . $this->api_version . '/'.$type.'/?'. $this->parameter_term . '='.$apiKey;
        
        $curl = curl_init();
        $curlRequest = $this->sendRequest($curl, $endpoint);

        if (!curl_errno($curl) && curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
            $json = json_decode($curlRequest); 
            if(!empty($json)){
                curl_close($curl);
                return $json->event_types;  
            }
            // return $json;
        }

        curl_close($curl);
        // print_r(json_decode($response));
        return 'No Results';
    }

    public function getEventTypeById( $id )
    {
        $type = 'event-types';
        $apiKey = $this->getAPIKey();
        $endpoint = $this->target_url . $this->api_version . '/'.$type.'/'.$id.'/?'. $this->parameter_term . '='.$apiKey;
        
        $curl = curl_init();
        $curlRequest = $this->sendRequest($curl, $endpoint);

        if (!curl_errno($curl) && curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
            $json = json_decode($curlRequest);            
            if(!empty($json)){
                curl_close($curl);
                return $json->event_type;  
            }
        }

        curl_close($curl);
        // print_r(json_decode($response));
        return 'No Results';
    }


    public function createBooking($data)
    {
        $type = 'bookings';
        $apiKey = $this->getAPIKey();
        $endpoint = $this->target_url . $this->api_version . '/'.$type.'/?'. $this->parameter_term . '='.$apiKey;
        
        $curl = curl_init();
        $curlRequest = $this->sendPost($curl, $endpoint, $data);

        if (!curl_errno($curl) && curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
            $json = json_decode($curlRequest);            
            if(!empty($json)){
                curl_close($curl);
                print_r($json);
                // return $json;  
            }
        }

        curl_close($curl);
        return 'No Results';
    }

    public function getAPIKey()
    {
        if (strpos(CalApi::getInstance()->getSettings()->apiKey, '$') !== false) {
            return getenv( substr( CalApi::getInstance()->getSettings()->apiKey, 1 ) );
        }
        return CalApi::getInstance()->getSettings()->apiKey;
    }

    public function getSettingsModel(): Settings{
        return CalApi::getInstance()->getSettings();
    }

}
