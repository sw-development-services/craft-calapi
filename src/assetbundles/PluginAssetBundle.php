<?php

namespace swdevelopment\craftcalapi\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;


class PluginAssetBundle extends AssetBundle
{
    public function init(){
        $this->sourcePath = '@calapi' . '/web/assets/dist';

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'PluginBundle.css'
        ];

        $this->js = [
            'PluginBundle.js'
        ];

        parent::init();
    }
}
