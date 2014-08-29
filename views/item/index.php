<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 */

$this->title = Yii::t('modules/config', 'Config models');
$this->params['breadcrumbs'][] = Yii::t('modules/config', 'Index');
?>
<div class="row">
    <div class="col-md-3 well">
        <?= $this->context->menu; ?>
    </div>
    <div class="col-md-9">
        <div class="config-update">
            <h1><?php echo Html::encode($this->title) ?></h1>
        </div>
    </div>
</div>

