<?php

namespace bariew\configModule\models\components;

use bariew\configModule\components\Config;
use Yii;

class Mail extends Config
{
    public $class = 'yii\swiftmailer\Mailer';
    public $messageClass = 'yii\swiftmailer\Message';
    public $htmlLayout = 'layouts/html';
    public $textLayout = 'layouts/text';
    public $useFileTransport = false;
    public $fileTransportPath = '@runtime/mail';



    public function rules()
    {
        return [
            [['class'], 'required'],
            [['class', 'messageClass'], 'classValidation'],
            [['class', 'messageClass', 'htmlLayout', 'textLayout', 'useFileTransport', 'fileTransportPath'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'messageClass' => Yii::t('modules/config', 'Message class'),
            'htmlLayout' => Yii::t('modules/config', 'Html layout'),
            'textLayout' => Yii::t('modules/config', 'Text layout'),
            'useFileTransport' => Yii::t('modules/config', 'Use file transport'),
            'fileTransportPath' => Yii::t('modules/config', 'File transport path'),
        ];
    }
}
