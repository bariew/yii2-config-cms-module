<?php

namespace bariew\configModule\models;

use bariew\configModule\components\Config;
use bariew\configModule\models\components\Db;
use Yii;

class Main extends Config
{
    protected static $key = [];

    public $id;
    public $language;
    public $components;
    public $params;


    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id', 'language'], 'string'],
            [['components', 'params'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('modules/config', 'Application name'),
            'language' => Yii::t('modules/config', 'Language'),
            'components' => Yii::t('modules/config', 'Components'),
            'params' => Yii::t('modules/config', 'Params'),
        ];
    }


    public static function validateConfig()
    {
        return Db::validateConfig();
    }
}
