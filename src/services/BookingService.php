<?php

namespace swdevelopment\craftcalapi\services;

use Craft;
use craft\base\Component;
use craft\events\ExceptionEvent;
use craft\helpers\ArrayHelper;
use craft\helpers\UrlHelper;

use Carbon\Carbon;

use swdevelopment\craftcalapi\records\BookingRecord;
use swdevelopment\craftcalapi\records\BookingSchedule;

class BookingService extends Component
{
    public function getAllBookings(){
        // this is retrieve all Bookings
        return BookingRecord::find()->orderBy(['date' => SORT_DESC])->all();
    }

    public function getBookingById( $id ){
        return BookingRecord::find()->where(['cal_booking_id' => $id])->one();
    }

    public function getLastBooking(){
        // return the last record - cal_booking_id 
        return BookingRecord::find()
            ->orderBy(['id' => SORT_DESC])->one();
    }

    public function save($data)
    {
        // save booking to the database
        $record = new BookingRecord();
        $status = 0;
        if(!empty( $data['attendees'] )){
            $record->email = $data['attendees'][0]['email'];
            $record->name = $data['attendees'][0]['name'];
        }else{
            $record->email = 'Placeholder Email';
            $record->name = 'Placeholder Name';
        }

        $record->cal_booking_id = $data['id'];
        $record->date = $data['startTime'];
        $record->time = $data['startTime'];
        $record->title = $data['title'];
        $record->description = $data['description'];
        if(!empty($data['status'])){
           if( $data['status'] == 'ACCEPTED'){
                $status = 1;
           } 
        }
        $record->status = $status;
        // $data['status']  -- ACCEPTED or CANCELLED
        
        // responses
        // $data['responses']['email'] && ['responses']['name'] && ['responses']['location'] && ['responses']['location']['optionValue']  

        $record->save();
        if(!$record->save()){
            return $record->getErrors();
        }

        return $record->id;

    }

    /**
     * Summary of createBookingSyncRecord
     * creates a record of this sync in the craft database
     * @return void
     */
    public function createBookingSyncRecord($count){
        // add record 
        $record = new BookingSchedule();
        $record->records_added = $count;
        $record->save();

        if(!$record->save()){
            return $record->getErrors();
        }

        return $record->id;
    }

    public function getSyncedBookings()
    {
        return BookingSchedule::find()->all();   
    }

    public function getLastSync()
    {
        return BookingSchedule::find()
            ->orderBy(['id' => SORT_DESC])->one();
    }

    public function getBookingsLastDays($days)
    {
        if($days > 0){
            return BookingRecord::find()->where( ['>','date', Carbon::now()->subDays( $days )] )->all();
        }
        return BookingRecord::find()->where( ['date' => Carbon::now()] )->all();   
    }

    


}

