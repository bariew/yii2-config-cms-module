<?php

namespace bariew\configModule\models\components;

use bariew\configModule\components\Config;
use Yii;

class Db extends Config
{
    protected static $key = ['components', 'db'];

    public $class = 'yii\db\Connection';
    public $dsn = 'mysql:host=localhost;dbname=cms';
    public $username = 'root';
    public $password = '';
    public $charset = 'utf8';
    public $enableSchemaCache = true;
    public $schemaCacheDuration = 3600;

    public function rules()
    {
        return [
            [['dsn', 'username'], 'required'],
            [['dsn', 'username', 'password'], 'string'],
            [['dsn'], 'dbValidate'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'dsn' => Yii::t('modules/config', 'Connection string (dsn)'),
            'username' => Yii::t('modules/config', 'Username'),
            'password' => Yii::t('modules/config', 'Password'),
            'charset' => Yii::t('modules/config', 'Charset'),
            'enableSchemaCache' => Yii::t('modules/config', 'Enable schema cache'),
            'schemaCacheDuration' => Yii::t('modules/config', 'Schema cache duration'),
        ];
    }

    public function dbValidate($attribute)
    {
        /**
         * @var \yii\db\Connection $connection
         */
        $connection = Yii::createObject($this->attributes);
        try {
            $connection->open();
        } catch (\Exception $e) {
            return $this->addError($attribute, $e->getMessage());
        }

        if (!$connection->isActive) {
            return $this->addError($attribute, "Could not connect to database");
        }
    }

    public static function validateConfig()
    {
        $model = new self();
        return $model->validate();
    }

}
