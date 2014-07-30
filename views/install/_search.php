<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var bariew\configModule\models\EmailConfigSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="email-config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'title') ?>

    <?php echo $form->field($model, 'subject') ?>

    <?php echo $form->field($model, 'content') ?>

    <?php echo $form->field($model, 'owner_name') ?>

    <?php // echo $form->field($model, 'owner_event') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('modules/config', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('modules/config', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
