<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareKegiatan */

$this->title = Yii::t('app', 'Update Pcare Kegiatan: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Kegiatans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pcare-kegiatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
