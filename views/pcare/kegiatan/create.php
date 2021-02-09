<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareKegiatan */

$this->title = Yii::t('app', 'Create Pcare Kegiatan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Kegiatans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-kegiatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
