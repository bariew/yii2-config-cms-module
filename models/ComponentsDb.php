<?php

namespace bariew\configModule\models;

use Yii;
use yii\base\Model;

class ComponentsDb extends Model
{
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

    public static function validateConfig($config)
    {
        $model = new self();
        $model->attributes = (array) $config;
        return !empty($config) && $model->validate();
    }

    public function init()
    {
        $config = Local::getConfig();
        if (isset($config['components']['db'])) {
            $this->attributes = $config['components']['db'];
        }
    }

}
