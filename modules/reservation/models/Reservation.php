<?php

namespace app\modules\reservation\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "reservation".
 *
 * @property int $id
 * @property string $datatime_created
 * @property string|null $data_arrival
 * @property int|null $status
 * @property int|null $user_id
 *
 * @property User $user
 */
class Reservation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datatime_created'], 'required'],
            [['datatime_created', 'data_arrival'], 'safe'],
            [['status', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datatime_created' => 'Datatime Created',
            'data_arrival' => 'Data Arrival',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
