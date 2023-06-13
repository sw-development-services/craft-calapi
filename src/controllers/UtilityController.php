<?php
namespace swdevelopment\craftcalapi\controllers;

use Craft;
use craft\web\Controller;
use swdevelopment\craftcalapi\CalApi;
use craft\helpers\Json;

use swdevelopment\craftcalapi\services\BookingService;


class UtilityController extends Controller
{
    // this allows the utility controller to run 
    protected array|bool|int $allowAnonymous = true;


    public function init(): void 
    {
        parent::init();
    }   


    /**
     * This will sync any bookings from Cal.com that have not been synced over to Craft
     * @return void
     */
    public function actionSyncBookings(){
        // check the last booking that we have synced from Cal.com to Craft CMS
        // check the records in the database

        $this->requirePermission('utility:sync-bookings');
        // grab the last booking
        $calBookings = $this->getAllCalBookings();
        if(empty($calBookings)){
            return $this->asFailure('Cal.com does not have any bookings.');
        }
        
        $counter = 0;
        foreach ( $calBookings['bookings'] as $booking ){
            $bookingID = $booking['id'];
            // check if booking exists in Craft
            $craftBookings = CalApi::getInstance()->booking->getBookingById($bookingID);    
            if(!$craftBookings){
                // save booking data to database
                $newBooking = CalApi::getInstance()->booking->save($booking);
                $counter++;
            }
        }
        // save sync data
        $bookingSync = CalApi::getInstance()->booking->createBookingSyncRecord($counter);
        if(!$bookingSync){
            return $this->asFailure($bookingSync);
        }
        
        if($counter == 0){
            return $this->asSuccess("It looks like there is nothing to add.");
        }
        
        return $this->asSuccess("Bookings are in-sync: $counter bookings were added.");
    }

    function getAllCalBookings()
    {
        return JSON::decode( CalApi::getInstance()->cal->GetBookings(), true );
    }

    function loopResults($bookings)
    {
        $success = false;
        foreach( $bookings['bookings'] as $booking ){
            // save line
            $savedBooking = CalApi::getInstance()->booking->save($booking);
        }
        // set flag
    }
    
}
