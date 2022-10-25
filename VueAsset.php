<?php
namespace seisvalt\vue3;

/**
 * Description of VueAsset
 *
 */
class VueAsset extends \yii\web\AssetBundle{
    public $js = [
        'assets/js/vue.global.'
    ];
    
    public function init()
    {
        $this->js[] = YII_ENV_DEV ? 'min.js' : 'prod.min.js';
    }
}
