<?php

namespace app\models;

use Yii;

class SimrsModel extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->dbSimrs;
    }
}