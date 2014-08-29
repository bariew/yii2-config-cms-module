<?php
/**
 * ConfigBootstrap class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\configModule;

use bariew\configModule\controllers\ItemController;
use bariew\configModule\models\components\Db;
use yii\base\BootstrapInterface;
use yii\web\Application;

/**
 * Bootstrap class initiates config check.
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class ConfigBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (!$app instanceof Application) {
            return true;
        }
        if (!Db::validateConfig()) {
            $module = new Module('config');
            \Yii::$app->controller = $controller = new ItemController('item', $module);
            $controller->layout = '//' . \Yii::$app->layout;
            echo $controller->runAction('update', ['name' => 'components\Db']);
            \Yii::$app->end();
        }
    }
}