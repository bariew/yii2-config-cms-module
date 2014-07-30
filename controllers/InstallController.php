<?php

namespace bariew\configModule\controllers;

use bariew\configModule\models\ComponentsDb;
use bariew\configModule\models\Local;
use bariew\configModule\models\Params;
use Yii;
use yii\web\Controller;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class InstallController extends Controller
{
    public $layout = 'install';
    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Local();
        $db = new ComponentsDb();
        $params = new Params();

        if (
            $model->load(Yii::$app->request->post())
            && $db->load(Yii::$app->request->post())
            && $params->load(Yii::$app->request->post())
            && $model->save(['components' => compact('db'), 'params' => $params])
        ) {
            return $this->redirect(['/']);
        }
        $this->getView()->params = compact('model', 'db', 'params');
        echo $this->render('create');
        Yii::$app->end();
    }
}
