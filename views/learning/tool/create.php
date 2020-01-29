<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\learning\Tool */

$this->title = Yii::t('app', 'Create Tool');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
