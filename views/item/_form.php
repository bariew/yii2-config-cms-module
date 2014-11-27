<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var bariew\configModule\components\Config $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="email-config-form">

    <?php $form = ActiveForm::begin();  ?>
        <?php foreach($model->safeAttributes() as $attribute): ?>
            <?php if($model->getIsSerializable($attribute)) : ?>
                <?= $form->field($model, $attribute)->textarea(); ?>
            <?php else: ?>
                <?= $form->field($model, $attribute)->textInput(); ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="form-group">
            <?php echo Html::a(Yii::t('modules/config', 'Reset'), ['delete', 'name'=>$model::getName()], ['class' => 'btn btn-danger']); ?>
            <?php echo Html::submitButton(Yii::t('modules/config', 'Save'), ['class' => 'btn btn-primary']); ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
