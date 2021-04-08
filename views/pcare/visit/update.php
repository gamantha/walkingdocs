<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisit */

$this->title = Yii::t('app', 'Update Pcare Visit: {name}', [
    'name' => $model->id,
]);

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kunjungan'), 'url' => ['pcare/registration/index']];
//$this->params['breadcrumbs'][] = ['label' => 'go back', 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = $this->title;





?>
<div class="pcare-visit-update">

    <h1>Data Kunjungan</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'registrationModel' => $registrationModel
    ]) ?>

</div>
