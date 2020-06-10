<?php

namespace app\modules\reservation\models;

use app\models\User;

function check_keys_in_data($keys, $data)
{
    foreach ($keys as $value) {

        if (!in_array($value, $data))
            return false;
    }
    return true;
}


function is_date_or_datetime($date)
{
    $regular_for_datetime = '(^\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}$)';
    $regular_for_date = '(^\d{4}-\d{2}-\d{2}$)';
    preg_match('/'.$regular_for_datetime.'|'.$regular_for_date.'/', $date, $matches);
    if (!$matches)
        return false;
    return true;
}

class Processes{
    static function validate_data($data)
    {
        $r_data = $data;
        $default_attributes = ['datatime_created', 'user_id', 'data_arrival', 'status'];
        
        $attributes_from_data = array_keys($r_data);

        if (!check_keys_in_data($default_attributes, $attributes_from_data))
        {
            throw new \yii\web\BadRequestHttpException($message='No attribute');
        }

        if (!is_date_or_datetime($r_data['datatime_created']))
        {
            throw new \yii\web\BadRequestHttpException($message='False "datetime_created". Example: "1999-12-24 12:48:50" or "1999-12-24"');
        }

        if ($r_data['data_arrival'] && !is_date_or_datetime($r_data['data_arrival']))
        {
            throw new \yii\web\BadRequestHttpException($message='False "data_arrival". Example: "1999-12-24"');
        }

        if ($r_data['user_id']){
            if (!User::findOne(['id' => $r_data['user_id']]))
                throw new \yii\web\BadRequestHttpException($message='Error "user_id"');
        }
    }

    static function create_model($model, $data)
    {
        $model->attributes = $data;
        $model->save();    
    }

    static function validate_id($id)
    {
        if (!is_numeric($id))
        {
            throw new \yii\web\BadRequestHttpException($message='Attribute id mus be int');
        }
    }
    
    static function delete_ticket($id)
    {
        $reservation_ticket = Reservation::findOne(['id' => $id]);
        $reservation_ticket->delete();
    }
}
