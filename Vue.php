<?php

namespace seisvalt\vue3;

use Yii;
use yii\helpers\Json;


class Vue extends \yii\base\Widget
{
    public $jsName = 'app';

    /**
     *
     * @var Array
     */
    public $data;


    /**
     * 'methods' => [
     *  'reverseMessage' => new yii\web\JsExpression("function(){"
     *      . "this.message =1; "
     *      . "}"),
     *  ]
     * @var Array
     */
    public $methods;

    /**
     *
     * @var Array 
     */
    public $watch;

    /**
     *
     * @var Array
     */
    public $computed;

    /**
     *
     * @var \yii\web\JsExpression
     */
    public $beforeCreate;

    /**
     *
     * @var \yii\web\JsExpression
     */
    public $created;

    /**
     *
     * @var \yii\web\JsExpression
     */
    public $beforeMount;

    /**
     *
     * @var \yii\web\JsExpression
     */
    public $mounted;

    /**
     *
     * @var \yii\web\JsExpression
     */
    public $unMounted;

    /**
     *
     * @var \yii\web\JsExpression
     */
    public $sockets;

    public function init()
    {
        $this->view->registerAssetBundle(VueAsset::class);

        $this->view->registerCss("
            [v-cloak] {
                display:none;
            }
        ");
    }

    public static function begin($config = array())
    {
        $obj =  parent::begin($config);
        echo '<div v-cloak id="' . $obj->id . '">';
        return $obj;
    }


    public static function end()
    {
        echo '</div>';
        return parent::end();
    }

    public function run()
    {
        return $this->renderVue();
    }

    public function renderVue()
    {
        
        $data = $this->generateData();
        $methods = $this->generateMethods();
        $created = $this->generateCreated();
        $watch = $this->generateWatch();
        $computed = $this->generateComputed();
        $sockets = $this->generateSockets();

        $use  = $this->initUse();
        
        $js = " 
            const {$this->id} = {
                data() { return " . $data ?? '{}' . "} ,
                " . (!empty($created) ? "created :" . $created . "," : null) . "
                " . (!empty($this->mounted) ? "mounted :" . $this->mounted->expression . "," : null) . "
                " . (!empty($this->unMounted) ? "unmounted :" . $this->unMounted->expression . "," : null) . "
                " . (!empty($computed) ? "computed :" . $computed . "," : null) . "
                " . (!empty($methods) ? "methods :" . $methods . "," : null) . "
                " . (!empty($watch) ? "watch :" . $watch . "," : null) . "
                
                " . (!empty($this->beforeCreate) ? "beforeCreate :" . $this->beforeCreate->expression . "," : null) . "
                " . (!empty($this->beforeMount) ? "beforeMount :" . $this->beforeMount->expression . "," : null) . "
                " . (!empty($this->beforeUnmount) ? "beforeUnmount :" . $this->beforeUnmount->expression . "," : null) . "
                
                
      
            }; 
            
            const app = Vue.createApp({$this->id});
            app.mount('#{$this->id}')
        ";
        Yii::$app->view->registerJs($js, \yii\web\View::POS_END);
    }

    public function generateData()
    {
        if (!empty($this->data)) {
            return json_encode($this->data);
        }
    }

    public function generateMethods()
    {
        if (is_array($this->methods) && !empty($this->methods)) {
            $str = '';
            foreach ($this->methods as $key => $value) {
                if ($value instanceof \yii\web\JsExpression) {
                    $str .= $key . ":" . $value->expression . ',';
                }
            }
            $str = rtrim($str, ',');
            return "{" . $str . "}";
        }
    }


    public function generateWatch()
    {
        if (is_array($this->watch) && !empty($this->watch)) {
            $str = '';
            foreach ($this->watch as $key => $value) {
                if ($value instanceof \yii\web\JsExpression) {
                    $str .= $key . ":" . $value->expression . ',';
                }
                else{
                    $str .= $key . ":" . $value.',';
                }
            }
            $str = rtrim($str, ',');
            return "{" . $str . "}";
        }
    }

    public function generateComputed()
    {
        if (is_array($this->computed) && !empty($this->computed)) {
            $str = '';
            foreach ($this->computed as $key => $value) {
                if ($value instanceof \yii\web\JsExpression) {
                    $str .= $key . ":" . $value->expression . ',';
                }
            }
            $str = rtrim($str, ',');
            return "{" . $str . "}";
        }
    }

    public function component($tagName, $option)
    {
        $option = json_encode($option);
        $this->view->registerJs("
            Vue.component($tagName, $option);
            ");
    }

    public function generateSockets()
    {
        if (is_array($this->sockets) && !empty($this->sockets)) {
            $str = '';
            foreach ($this->sockets as $key => $value) {
                if ($value instanceof \yii\web\JsExpression) {
                    $str .= $key . ":" . $value->expression . ',';
                }
            }
            $str = rtrim($str, ',');
            return "{" . $str . "}";
        }
    }


}
