<?php
/**
 * ConfigBootstrap class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\configModule;

use bariew\configModule\controllers\InstallController;
use bariew\configModule\models\Local;
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
        if (($app instanceof Application) && !Local::validateConfig()) {
            $module = new Module('config');
            $controller = new InstallController('install', $module);
            $controller->runAction('create');
        }
    }
}