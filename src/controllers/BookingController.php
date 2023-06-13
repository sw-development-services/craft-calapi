<?php
namespace swdevelopment\craftcalapi\controllers;

use Craft;
use craft\web\Controller;
use swdevelopment\craftcalapi\CalApi;
use craft\helpers\Json;

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

class BookingController extends Controller
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
    

    public function actionCreateBooking()
    {
        $this->requireAdmin();
        $this->requirePostRequest();

        return 'booking created';


    }


}
