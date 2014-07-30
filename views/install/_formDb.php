<?php
/**
 * @var yii\web\View $this
 * @var bariew\configModule\models\ComponentsDb $db
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php echo $form->field($db, 'dsn')->textInput(['maxlength' => 255, 'placeholder' => 'mysql:host=localhost;dbname=cms']) ?>
<?php echo $form->field($db, 'username')->textInput(['maxlength' => 255]) ?>
<?php echo $form->field($db, 'password')->textInput(['maxlength' => 255]) ?>

