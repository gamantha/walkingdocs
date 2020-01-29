<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */

$this->title = Yii::t('app', 'Update Report: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_lb1form', [
        'model' => $model,
    ]) ?>

</div>
