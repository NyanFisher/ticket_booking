<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

use app\models\User;

class SiteController extends Controller
{
    public $modelClass = 'app\models\User';

    public function actionRegistration()
    {
        $request = Yii::$app->getRequest();
        $data =  $request->bodyParams;

        validate_data($data);

        $serializer = $this->serializeData($data);

        $user = new User();
        
        $user->create($serializer);

        return ['access_token' => $user->access_token];
    }

    public function actionLogin()
    {
        $request = Yii::$app->getRequest();
        $data =  $request->bodyParams;

        validate_data($data);

        $serializer = $this->serializeData($data);
        
        $user = User::findOne(['username' => $serializer['username']]);
        if (!$user)
            throw new \yii\web\BadRequestHttpException($message='User is not found');

        if (!$user->validatePassword($serializer['password']))
            throw new \yii\web\BadRequestHttpException($message='Error password');

        return ['access_token' => $user->access_token];
    }
}

function validate_data($data)
{
    $attributes_from_data = array_keys($data);

    if (!in_array('password', $attributes_from_data) || !in_array('username', $attributes_from_data))
    {
        throw new \yii\web\BadRequestHttpException($message='No attribute');
    }
}
