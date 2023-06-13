<?php


namespace swdevelopment\craftcalapi\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * undocumented class
 */
class SyncBookingsAsset extends AssetBundle
{
    public function init(){
        $this->sourcePath = '@calapi' . '/web/assets/dist';

        $this->depends = [
            CpAsset::class,
        ];
    
        $this->js = [
            'SyncBookingsUtility.js'
        ];

        $this->css = [
            'SyncBookingsUtility.css',
            'input.css'
        ];


        parent::init();
    }
    
    

}
