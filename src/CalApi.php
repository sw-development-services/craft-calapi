<?php

namespace swdevelopment\craftcalapi;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\helpers\UrlHelper;
use swdevelopment\craftcalapi\models\Settings;
use swdevelopment\craftcalapi\services\Cal;
use swdevelopment\craftcalapi\services\Stripe;
use swdevelopment\craftcalapi\services\BookingService;
use swdevelopment\craftcalapi\widgets\Cal as CalWidget;
use swdevelopment\craftcalapi\twig\ClassBookings;
use swdevelopment\craftcalapi\variables\CalAPIVariable;
use swdevelopment\craftcalapi\utilities\SyncBookings;

use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use yii\base\Event;

use craft\services\Dashboard;
use craft\services\Utilities;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;


/**
 * cal.com plugin
 *
 * @method static CalApi getInstance()
 * @method Settings getSettings()
 * @author Tim Strawbridge <tstrawbridge@swdevteam.com>
 * @copyright Tim Strawbridge
 * @license MIT
 */
class CalApi extends Plugin
{
    public string $schemaVersion = '1.0.0';

    public ?string $name = "Cal.com API";
    public bool $hasCpSettings = true;

    public bool $hasCpSection = true;

    public static ?CalApi $plugin;

    public static bool $devMode;

    public static ?CalAPIVariable $calApiVariable = null; 

    public static function config(): array
    {
        return [
            'components' => [
                'cal' => Cal::class,
                'stripe' => Stripe::class,
                'booking' => BookingService::class,
            ],
        ];
    }

    public function init() : void
    {
        parent::init();
        self::$plugin = $this;
        Craft::setAlias('@calapi', __DIR__);            // set the alias

        //self::$settings = self::$plugin->getSettings();
        self::$devMode = Craft::$app->getConfig()->getGeneral()->devMode;

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->attachEventHandlers();
        });

    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('calapi/settings', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    public function getSettingsResponse(): mixed{
        return Craft::$app->controller->redirect(UrlHelper::cpUrl('calapi/settings'));
    }

    public function getSettings(): Settings
    {
        return parent::getSettings();
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'calapi/cal';
                $event->rules['calapi/get-event-data'] = 'calapi/cal/get-event-data';
            }
        );

         // Register variables
         Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('calApi', CalAPIVariable::class);
                $variable->set('calapiService', Cal::class);
            }
        );

        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = SyncBookings::class;
            }
        );

        // Craft::$app->view->registerTwigExtension( new ClassBookings() );

        // register nav items
        /* Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url' => 'section-url',
                    'label' => 'Cal.com API',
                    'icon' => '@calapi/icon.svg',
                ];
            }
        );*/

        // register url's for rest


        // register our widget
        /* Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CalWidget::class;
            }
        );*/

    }

    public function getCpNavItem(): ?array
    {
        $currentUser = Craft::$app->getUser()->getIdentity();

        $item = parent::getCpNavItem();
        $item['subnav'] = [
            'settings' => ['label' => Craft::t('calapi', 'Settings'), 'url' => 'calapi/settings'],
            'dashboard' => ['label' => Craft::t('calapi', 'Dashboard'), 'url' => 'calapi/dashboard'],
            //'general' => ['label' => Craft::t('calapi', 'General'), 'url' => 'calapi/general'],
            'bookings' => ['label' => Craft::t('calapi', 'Bookings'), 'url' => 'calapi/bookings'],
           
            
        ];
        return $item;
    }
}
