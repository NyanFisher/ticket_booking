<?php

namespace app\modules\reservation;

class Module extends \yii\base\Module
{
    public $defaultController = 'default';

    public $controllerNamespace = 'app\modules\reservation\controllers';

    public function init()
    {
        parent::init();
    }  

}