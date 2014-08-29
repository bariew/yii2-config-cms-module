<?php

namespace bariew\configModule\models;

use bariew\configModule\components\Config;
use Yii;

class Main extends Config
{
    public $name = 'My Application';
    public $language = 'en';
    public $sourceLanguage = 'en-US';
    public $layout = 'main';
    public $charset = 'UTF-8';
    public $version = '1.0';

    protected static $key = [];


    public function rules()
    {
        return [
            [['name', 'language', 'sourceLanguage', 'charset'], 'required'],
            [['charset', 'sourceLanguage', 'name', 'version', 'layout'], 'string'],
            [['language'], 'string', 'min' => 2, 'max' => 2]
        ];
    }

    public function attributeLabels()
    {
        return [
            'language' => Yii::t('modules/config', 'Language'),
            'sourceLanguage' => Yii::t('modules/config', 'Source language'),
            'layout' => Yii::t('modules/config', 'Layout'),
            'charset' => Yii::t('modules/config', 'Charset'),
            'version' => Yii::t('modules/config', 'Version'),
            'name' => Yii::t('modules/config', 'Application name'),
        ];
    }
}
