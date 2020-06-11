<?php

namespace app\modules\reservation\controllers;

include_once("Processes.php");

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;

use app\models\User;
use app\modules\reservation\models\Reservation;

class DefaultController extends Controller
{
    public $modelClass = 'app\modules\reservations\models\Reservation';
    
    public function beforeAction($action)
    {
        $access_token = Yii::$app->request->headers['access_token'];
        if ($access_token)
        {
            if (User::findOne(['access_token' => $access_token]))
                return parent::beforeAction($action);
            else
                throw new \yii\web\BadRequestHttpException($message='User is not found');

        }

        throw new \yii\web\BadRequestHttpException($message='No header "ACCESS_TOKEN');

    }

    public function actionIndex($id=null, $status=null)
    {   
        if ($id && $status)
            $data = Reservation::find()->where(['id' => $id, 'status' => $status]);
        elseif ($id)
            $data = Reservation::find()->where(['id' => $id]);
        elseif ($status)
            $data = Reservation::find()->where(['status' => $status]);
        else
            $data = Reservation::find();
            

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $data,
            
            'pagination' => [
                'totalCount' => $data->count(),
                'pageSize' => 5,
                'defaultPageSize' => 5,
            ]
        ]);

        return $dataProvider;
    }

    public function actionCreate()
    {
        $request = Yii::$app->getRequest();
        $data =  $request->bodyParams;
        
        validate_data($data);

        $model = new Reservation();
        $serializer_data = $this->serializeData($data);

        create_model($model, $serializer_data);

        return ['success' => true, 'status_code' => 200];
    }

    public function actionDelete($id)
    {
        
        validate_id($id);

        delete_number($id);
        
        return ['success' => true, 'status_code' => 200];
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->getRequest();
        $data =  $request->bodyParams;

        validate_data_for_update($data);

        update_number($id, $data);
        
        return ['success' => true, 'status_code' => 200];
    }

    public function actionGet($user_id, $status=null)
    {
        if ($status)
            $data = Reservation::find()->where(['user_id' => $user_id, 'status' => $status]);
        else
            $data = Reservation::find()->where(['user_id' => $user_id]);
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $data,
            
            'pagination' => [
                'totalCount' => $data->count(),
                'pageSize' => 5,
                'defaultPageSize' => 5,
            ]
        ]);

        return $dataProvider;
    }
}   