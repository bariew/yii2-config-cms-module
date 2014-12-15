<?php

namespace bariew\configModule\models\components;

use bariew\configModule\components\Config;
use Yii;

class Request extends Config
{
    public $class = 'yii\web\Request';
    public $acceptableContentTypes = '[]';
    public $acceptableLanguages = '[]';
    public $enableCookieValidation = 1;
    public $enableCsrfValidation = 1;
    public $cookieValidationKey = '';
    public $methodParam = '_method';

    /**
     * @inheritdoc
     */
    protected $jsonAttributes = ['acceptableContentTypes', 'acceptableLanguages'];

    public function rules()
    {
        return [
            [['class'], 'required'],
            [['class'], 'classValidation'],
            [['enableCookieValidation', 'enableCsrfValidation'], 'in', 'range' => [0,1]],
            [['cookieValidationKey', 'methodParam'], 'string', 'min'=>3, 'skipOnEmpty' => false],
            [['acceptableContentTypes', 'acceptableLanguages'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'acceptableContentTypes' => Yii::t('modules/config', 'Acceptable content types'),
            'acceptableLanguages' => Yii::t('modules/config', 'Acceptable languages'),
            'enableCookieValidation' => Yii::t('modules/config', 'Enable cookie validation'),
            'enableCsrfValidation' => Yii::t('modules/config', 'Enable csrf validation'),
            'cookieValidationKey' => Yii::t('modules/config', 'Cookie validation key'),
            'methodParam' => Yii::t('modules/config', 'Method param'),
        ];
    }
}
