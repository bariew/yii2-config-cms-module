<?php

namespace bariew\configModule\models\components\mail;

use bariew\configModule\components\Config;
use Yii;

class Transport extends Config
{

    public $class = 'yii\swiftmailer\Mailer';
    public $host = 'yii\swiftmailer\Message';
    public $username = 'layouts/html';
    public $password = 'layouts/text';
    public $port = false;
    public $encryption = '@runtime/mail';


    public function rules()
    {
        return [
            [['class'], 'required'],
            [['class', 'host', 'username', 'password', 'port', 'encryption'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'host' => Yii::t('modules/config', 'Host'),
            'username' => Yii::t('modules/config', 'Username'),
            'password' => Yii::t('modules/config', 'Password'),
            'port' => Yii::t('modules/config', 'Port'),
            'encryption' => Yii::t('modules/config', 'Encryption'),
        ];
    }
}
