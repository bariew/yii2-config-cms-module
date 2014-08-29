<?php

namespace bariew\configModule\models;

use bariew\configModule\components\Config;
use Yii;

class Params extends Config
{
    public $adminEmail;

    public function rules()
    {
        return [
            [['adminEmail'], 'required'],
            [['adminEmail'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'adminEmail'    => Yii::t('modules/config', 'Admin email'),
        ];
    }
}
