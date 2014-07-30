<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var bariew\configModule\models\Local $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="email-config-form">

    <?php $this->params['form'] = $form = ActiveForm::begin();  ?>

        <?php echo $form->field($model, 'id')->textInput(['maxlength' => 255]) ?>

        <?php echo $form->field($model, 'language')->textInput(['maxlength' => 255, 'placeholder' => 'en']) ?>

        <?= $this->render('_formDb', $this->params); ?>

        <?= $this->render('_formParams', $this->params); ?>

        <div class="form-group">
            <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
