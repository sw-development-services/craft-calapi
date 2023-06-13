<?php

namespace swdevelopment\craftcalapi\widgets;

use Craft;
use craft\base\Widget;

class Cal extends Widget
{
    public static function displayName(): string
    {
        return Craft::t('app', 'Cal.com Calendar ');
    }

    /**
     * @var string|null The date range
     */
    public ?string $dateRange = null;

    /**
     * Summary of title
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @inheritdoc
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public static function icon(): ?string
    {
        return Craft::getAlias('@calapi/calendar.svg');
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml(): ?string
    {
        return "<div class='centeralign'><h2 style='font-size:3rem;'>10</h2><p class='centeralign'>New Calendar Entries</p></div>";
    }

    /* public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('settings.twig',
            [
                'widget' => $this,
            ]);
    }*/


}
