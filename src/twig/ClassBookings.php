<?php

namespace swdevelopment\craftcalapi\twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

use swdevelopment\craftcalapi\CalApi;

class ClassBookings extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {

        $request = Craft::$app->getRequest();

        

        // Keys are variable names!
       // return [ 'calapi' => CalApi::getInstance() ];
    }
}
