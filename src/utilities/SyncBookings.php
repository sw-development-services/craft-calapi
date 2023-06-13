<?php 

/**
 * Summary of SyncBookings
 * @author Tim Strawbridge
 * @copyright (c) 2023
 */

namespace swdevelopment\craftcalapi\utilities;

use Craft;
use craft\base\Utility;
use swdevelopment\craftcalapi\assetbundles\SyncBookingsAsset;

class SyncBookings extends Utility
{
    public static function displayName(): string
    {
        return Craft::t('app', 'Sync Bookings');
    }

    public static function id(): string
    {
        return 'sync-bookings';
    }

    public static function iconPath(): ?string
    {
        return Craft::getAlias('@appicons/tools.svg');
    }

    public static function contentHtml(): string
    {
        $view = Craft::$app->getView();

        // register asset bundle
        $view->registerAssetBundle(SyncBookingsAsset::class);
        // $view->registerJs('');
        // return some view 
        return Craft::$app->view->renderTemplate('calapi/_components/utilities/syncBookings.twig');
    }

    public static function footerHtml(): string{
        return 'Brought to you by Tim Strawbridge and SW Development Services, LLC with Love emoji';
    }


}