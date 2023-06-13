<?php
namespace swdevelopment\craftcalapi\controllers;

use Craft;
use craft\web\Controller;
use swdevelopment\craftcalapi\CalApi;
use craft\helpers\Json;
use Carbon\Carbon;

/**
 * More info about Controllers...
 *
 * https://doublesecretagency.github.io/craft-businesslogic/controllers
 */

/**
 * Business Logic Controller
 *
 * Controller methods get a little more complicated... There are several ways to access them:
 *
 *     1. Submitting a form can trigger a controller action.
 *     2. Using an AJAX request can trigger a controller action.
 *     3. Routing to an action URL will trigger a controller action.
 *
 * A controller can do many things, but be wary... If your logic gets too complex, you may want
 * to off-load much of it to the Service file.
 */

class CalController extends Controller
{

  
    protected array|bool|int $allowAnonymous = true;


    public function init(): void 
    {
        parent::init();
    }   

    public function beforeAction($action): bool
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [EVENT_BEFORE_ACTION](https://www.yiiframework.com/doc/api/2.0/yii-base-controller#EVENT_BEFORE_ACTION-detail) event, e.g. PageCache or AccessControl
        $this->enableCsrfValidation = false;
        // action = calapi

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }


    /**
     * Summary of actionCreateCustomer
     * this is part of a webhook that is recieved from cal.com
     * this will send out another webhook to trigger the creation of a strip customer
     * @return \yii\web\Response
     */
    public function actionCreateCustomer(){
        // $this->enableCsrfValidation = false;
        $this->requirePostRequest();
        
        // get json data - payload
        // $payload = $this->asJson( Craft::$app->request->getBodyParam('payload') );
        $payload = Craft::$app->request->getBodyParam('payload');

        $type = $payload['type'];
        $startTime = $payload['startTime'];
        $endTime = $payload['endTime'];
        $email = $payload['attendees'][0]['email'];
        $name = $payload['attendees'][0]['name'];
        $address = "";
        
        // attendees
        /*$attends = [];
        foreach($attendees as $attendee){
            $attends[] = $attendee['email'];
        }*/

        $data = [
            "type" => $type,
            "email" => $email,
            "name" => $name

        ];
        // pass data to stripe to create customer, save entry in database
        $calResponse = CalAPI::getInstance()->stripe->createCustomer($data);
    
        // print_r( $calResponse );
        // return 'true';
        return $this->asJson(['response' => 'Round trip via AJAX!']);
        // return as success
        // return $this->asSuccess()
    }

    /**
     * When you need AJAX, this is how to do it.
     *
     * HOW TO USE IT
     * In your front-end JavaScript, POST your AJAX call like this:
     *
     *     // example uses jQuery
     *     $.post('actions/business-logic/example/example-ajax' ...
     *
     * Or if your module is doing something within the control panel,
     * you've got a built-in function available which Craft provides:
     *
     *     Craft.postActionRequest('business-logic/example/example-ajax' ...
     *
     */
    public function actionExampleAjax()
    {
        $this->requirePostRequest();
        $this->requireAcceptsJson();
        $request = Craft::$app->getRequest();
        $lorem = $request->getBodyParam('lorem');
        $ipsum = $request->getBodyParam('ipsum');
        // ... whatever your AJAX does...
        $response = ['response' => 'Round trip via AJAX!'];
        return $this->asJson($response);
    }

    /**
     * Routing lets you set extra variables when you load a Twig template.
     *
     * HOW TO USE IT
     * Put this in your config/routes.php file:
     *
     *     'your/route' => 'business-logic/example/example-route'
     *
     * Optionally, you can specify dynamic parameters as part of the route:
     *
     *     'your/route/<lorem:\d+>/<ipsum:\d+>' => 'business-logic/example/example-route'
     *
     * If you specify dynamic parameters, pass those values directly into your function.
     * The variable names must match the specified tokens.
     *
     *     actionExampleRoute($lorem, $ipsum)
     *
     */
    public function actionExampleRoute()
    {
        // ... whatever your route accomplishes...
        $twigVariable = 'I added this with a route!';
        return $this->renderTemplate('your/destination/template', [
            'twigVariable' => $twigVariable
        ]);
    }

    public function actionCreateBooking()
    {
    
        $this->requireAdmin();
        $this->requirePostRequest();
        // make sure user is logged in
        $request = Craft::$app->getRequest();

        // get the params
        $name = $request->getBodyParam('name');
        $email = $request->getBodyParam('attendees_email');
        $notes = $request->getBodyParam('additional_notes');
        $start_date = $request->getBodyParam('start_date');
        $start_time = $request->getBodyParam('start_time');
        $event_type = $request->getBodyParam('event_type');

        // process event id
        if(empty( $event_type )){
            return $this->asFailure('The event type id is missing');       
        }
        $event_type_id = substr( $event_type['id'], 7 );

        // grab the event type data from Cal.com
        $event = CalApi::getInstance()->cal->getEventTypeById( $event_type_id );
        $length = $event->length;

        $time = $start_time['time'];
        $title = $event->title;
        // $end = Carbon::create( $start_date['date'] )->addMinutes($length);

        // set timezone to 'America/Chicago'
        // $dtime = \DateTime::createFromFormat(\DateTimeInterface::ISO8601,$start_date['date']);

        $dt = date(\DateTimeInterface::ISO8601, strtotime($start_date['date'].$time) );
        $end = Carbon::create( $dt )->addMinutes($length);
        // format of reserve time
        // 2023-03-04T17:00:00.000Z

        // prep data
        $data = [
            'eventTypeId'       => $event_type_id,
            'start'             => $start_date,
            'name'              => $name,
            'email'             => $email,
            'timeZone'          => 'central',        
            'metadata'          => null,
            'customInputs'      => [],
            'location'          => 'HQ',
            'title'             => "Meeting between $name and Car Care Solutions USA",
            'description'       => $title,
            'status'            => 'ACCEPTED',
            'duration'          => $length,
            'end'               => $end,
            'ti'                => $dt
        ];


        // send to API via Guzzle or Curl
        // CalApi::getInstance()->cal->createBooking($data);
        return $this->asJson(['response' => '', 'data' => $data]);

    }

    public function actionGetEventData()
    {
        // check if this is an ajax request and user is logged in

        $this->requireAdmin();
        $this->requirePostRequest();
    
        $request = Craft::$app->getRequest();
        $params = $request->getBodyParams();
        // var_dump(Craft::$app->getRequest()->post());


        $selectedEvent = $request->getBodyParam('event_id');
        // return $selectedEvent;
        $event_type_id = substr( $selectedEvent, 7 );
        
        // call cal service
        $eventData = CalApi::getInstance()->cal->getEventTypeById( $event_type_id );
        return $this->asJson(['response' => $eventData]);
    }

    /**
     * Summary of actionGetBookings
     * @return \yii\web\Response
     */
    public function actionGetBookings()
    {
        // use service to send request to API
        $bookings =  CalApi::getInstance()->cal->GetBookings();
        return $bookings;
    }

    public function actionGetProfile()
    {
        // this will get the users profile
        
    }

}
