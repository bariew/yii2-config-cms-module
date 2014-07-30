<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bariew\configModule\models\EmailConfig $model
 */

$this->title = 'Installation';
?>
<div class="email-config-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', $this->params) ?>

</div>
