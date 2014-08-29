<?php

namespace bariew\configModule\controllers;

use bariew\configModule\components\Config;
use bariew\configModule\models\Main;
use Yii;
use yii\bootstrap\Nav;
use yii\web\Controller;
use yii\widgets\Menu;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    public function getMenu()
    {
        $items = [];
        foreach (Config::listAll() as $name) {
            $path = explode('\\', $name);
            $data = [
                'label' => $name,
                'url' => ['update', 'name' => $name],
                'active' => Yii::$app->request->get('name') == $name
            ];
            $items[] = $data;
        }
        return Nav::widget(['items' => $items]);
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
        }
        return $this->render('update', compact('model'));

    }

    public function actionDelete($name)
    {
        /**
         * @var Config $model
         */
        $model = $this->getModel($name);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('modules/config', 'Deleted'));
            return $this->redirect(['index']);
        }
        return $this->render('update', compact('model'));

    }

    public function getModel($name)
    {
        $className = Config::getClass($name);
        return new $className();
    }
}
