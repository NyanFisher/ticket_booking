<?php

namespace app\modules\reservation\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;


use app\modules\reservation\models\Reservation;
use app\modules\reservation\models\Processes;

class DefaultController extends Controller
{
    public $modelClass = 'app\modules\reservations\models\Reservation';

    public function actionIndex()
    {
        $data = Reservation::find()->all();
        return $data;
    }

    public function actionCreate()
    {
        $request = Yii::$app->getRequest();
        $data =  $request->bodyParams;

        Processes::validate_data($data);

        $model = new Reservation();
        $serializer_data = $this->serializeData($data);

        Processes::create_model($model, $serializer_data);

        return ['success' => true, 'status_code' => 200];
    }

    public function actionDelete($id)
    {
        
        Processes::validate_id($id);

        Processes::delete_ticket($id);
        
        return ['success' => true, 'status_code' => 200];
    }
}   