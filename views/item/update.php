<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bariew\configModule\models\EmailConfig $model
 */

$this->title = Yii::t('modules/config', 'Update {modelClass} config ', [
  'modelClass' => $model->getName(),
]);
$this->params['breadcrumbs'][] = Yii::t('modules/config', 'Update');
?>
<div class="row">
    <div class="col-md-3 well">
        <?= $this->context->menu; ?>
    </div>
    <div class="col-md-9">
        <div class="config-update">
            <h1><?php echo Html::encode($this->title) ?></h1>
            <?php echo $this->render('_form', compact('model')) ?>
        </div>
    </div>
</div>

