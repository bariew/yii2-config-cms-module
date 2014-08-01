<?php

namespace bariew\configModule\models;

use Yii;
use yii\base\Model;
use yii\console\Application;
use yii\console\Controller;

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

        if (!$connection->schema->tableNames) {
            $this->migrate();
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

    protected function migrate()
    {
        try {
            $webApp = Yii::$app;
            $consoleConfig = require_once Yii::getAlias('@app/config/console.php');
            $consoleConfig['components']['db'] = $this->attributes;
            $_SERVER['argv'] = ['migrate'];
            Yii::$app = new Application($consoleConfig);
            /**
             * @var Controller $controller
             */
            $controller =  Yii::$app->createController('migrate')[0];
            $controller->interactive = false;
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
            defined('YII_DEBUG') or define('YII_DEBUG', true);
            defined('YII_ENV') or define('YII_ENV', 'dev');
            $controller->runAction('up');
            Yii::$app->response->clearOutputBuffers();
            Yii::$app = $webApp;
        } catch (\Exception $e) {
            $this->addError('dsn', "Couldn't complete migrations");
            return false;
        }

        return true;
    }
}
