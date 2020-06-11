<?php

namespace app\modules\reservation\controllers;

use app\models\User;
use app\modules\reservation\models\Reservation;

function _check_keys_in_data($keys, $data)
{
    $counter = 0;
    foreach ($keys as $value) {
        if (!in_array($value, $data))
            return false;
    }
    return true;
}

function _check_keys_in_data_for_update($keys, $data)
{
    $counter = 0;
    foreach ($keys as $value) {
        if (in_array($value, $data))
            $counter ++;
    }

    if ($counter)
        return true;
    return false;
}

function _is_date_or_datetime($date)
{
    $regular_for_datetime = '(^\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}$)';
    $regular_for_date = '(^\d{4}-\d{2}-\d{2}$)';
    preg_match('/'.$regular_for_datetime.'|'.$regular_for_date.'/', $date, $matches);
    if (!$matches)
        return false;
    return true;
}


function validate_data($data)
{
    $attributes_from_data = array_keys($data);
    
    $default_attributes = ['datatime_created', 'data_arrival', 'status'];

    if (!_check_keys_in_data($default_attributes, $attributes_from_data))
    {
        throw new \yii\web\BadRequestHttpException($message='No attribute');
    }

    if (!_is_date_or_datetime($data['datatime_created']))
    {
        throw new \yii\web\BadRequestHttpException($message='False "datetime_created". Example: "1999-12-24 12:48:50" or "1999-12-24"');
    }

    if ($data['data_arrival'] && !_is_date_or_datetime($data['data_arrival']))
    {
        throw new \yii\web\BadRequestHttpException($message='False "data_arrival". Example: "1999-12-24"');
    }

    if (in_array('user_id', $attributes_from_data) && $data['user_id']){
        if (!User::findOne(['id' => $data['user_id']]))
            throw new \yii\web\BadRequestHttpException($message='Error "user_id"');
    }
}

function validate_id($id)
{
    if (!is_numeric($id))
    {
        throw new \yii\web\BadRequestHttpException($message='Attribute id mus be int');
    }
}

function validate_data_for_update($data)
{
    $attributes_from_data = array_keys($data);

    $default_attributes = ['datatime_created', 'user_id', 'data_arrival', 'status'];

    if (!_check_keys_in_data_for_update($default_attributes, $attributes_from_data))
    {
        throw new \yii\web\BadRequestHttpException($message='No attributes');
    }
    
    if (in_array($default_attributes[0], $attributes_from_data))
    {
        throw new \yii\web\BadRequestHttpException($message='"datatime_created" is immutable');
    }
}

function change_status($status)
{
    if ((int) $status > 0)
        return $status = 1;
    return $status = 0;
}

function create_model($model, $data)
{
    $data['status'] = change_status($data['status']);
    
    $model->attributes = $data;
    $model->save();    
}

function delete_number($id)
{
    $reservation_number = Reservation::findOne(['id' => $id]);
    $reservation_number->delete();
}

function update_number($id, $data)
{
    $reservation_number = Reservation::findOne(['id' => $id]);
    $reservation_number->attributes = $data;
    $reservation_number->update();
}

