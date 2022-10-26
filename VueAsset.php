<?php
namespace seisvalt\vue;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Description of VueAsset
 *
 */
class VueAsset extends AssetBundle{
    public $sourcePath = '@seisvalt/vue/assets';
    public $jsOptions = ['position' => View::POS_HEAD];

    public $js = [
    ];
    
    public function init()
    {
        $this->js[] = YII_ENV_DEV ? 'js/vue.global.min.js' : 'js/vue.global.prod.min.js';
    }
}
