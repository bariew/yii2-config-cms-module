<?php

namespace bariew\configModule\controllers;

use bariew\configModule\components\Config;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    public $enableCsrfValidation = false;

    public function getMenu()
    {
        return \bariew\configModule\widgets\Menu::widget();
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate($name)
    {
        /**
         * @var Config $model
         */
        $model = $this->getModel($name);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('modules/config', 'Saved'));
            return $this->refresh();
        }
        return $this->render('update', compact('model'));

    }

    public function getModel($name)
    {
        $className = Config::getClass($name);
        if (!class_exists($className)) {
            throw new HttpException(404, Yii::t('modules/config', "Class does not exist"));
        }
        return new $className();
    }
}
