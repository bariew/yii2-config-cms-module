<?php

namespace bariew\configModule\controllers;

use bariew\configModule\components\Config;
use Yii;
use yii\bootstrap\Nav;
use yii\web\Controller;
use yii\widgets\Menu;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    public $layout = 'install';

    public function getMenu()
    {
        $items = [];
        foreach (Config::listAll() as $name) {
            $items[] = [
                'label' => $name,
                'url' => ['update', 'name' => $name],
                'active' => Yii::$app->request->get('name') == $name
            ];
        }
        return Nav::widget(['items' => $items]);
    }

    public function actionUpdate($name)
    {
        /**
         * @var Config $model
         */
        $model = $this->getModel($name);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('modules/config', 'Saved'));
        }
        return $this->render('update', compact('model'));

    }

    public function getModel($name)
    {
        $className = '\bariew\configModule\models\\' . $name;
        return new $className();
    }
}
