<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */

$this->title = Yii::t('app', 'Update Pcare Registration: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pcare-registration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'visitmodel' => $visitmodel
    ]) ?>

</div>
