<?php
/**
 * ConfigBootstrap class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\configModule;

use bariew\configModule\controllers\ItemController;
use bariew\configModule\models\Main;
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
        if (!Main::validateConfig()) {
            $module = new Module('config');
            \Yii::$app->controller = $controller = new ItemController('item', $module);
            echo $controller->runAction('update', ['name' => 'components\Db']);
            \Yii::$app->end();
        }
    }
}