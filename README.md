# vuejs

for yii2 web application

<p align="center">
    
[![Latest Stable Version](https://poser.pugx.org/aki/yii2-vue/v/stable)](https://packagist.org/packages/aki/yii2-vue)   
[![Total Downloads](https://poser.pugx.org/aki/yii2-vue/downloads)](https://packagist.org/packages/aki/yii2-vue)

</p>

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require seisvalt/yii2-vue3 "*"
```

or add

```
"seisvalt/yii2-vue3": "*"
```

to the require section of your `composer.json` file.

Usage

---

Once the extension is installed, simply use it in your code by :

```php
<?php
use aki\vue\Vue;
?>
<?php Vue::begin([
    'id' => "vue-app",
    'data' => [
        'message' => "hello world!!",
        'seen' => true,
        'todos' => [
            ['text' => "akbar joudi"],
            ['text' => "aref mohhamdzadeh"]
        ]
    ],
    'methods' => [
        'reverseMessage' => new yii\web\JsExpression("function(){"
                . "this.message = this.message.split('').reverse().join(''); "
                . "}"),
    ],
    'watch' => [
        'message' => new JsExpression('function(newval, oldval){
            console.log(newval)
        }'),
    ]
]); ?>

    <p>{{ message }}</p>
    <button v-on:click="reverseMessage">Reverse Message</button>

    <p v-if="seen">Now you see me</p>


    <ol>
        <li v-for="todo in todos">
          {{ todo.text }}
        </li>
    </ol>

    <p>{{ message }}</p>
    <input v-model="message">


<?php Vue::end(); ?>
```

