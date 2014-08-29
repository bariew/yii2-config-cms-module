<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var bariew\configModule\models\EmailConfigSearch $searchModel
 */

$this->title = Yii::t('modules/config', 'Email Configs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-config-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a(Yii::t('modules/config', 'Create {modelClass}', [
  'modelClass' => 'Email Config',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'subject',
            'content:ntext',
            'owner_name',
            'owner_event',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
