<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareKegiatanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pcare-kegiatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'consId') ?>

    <?= $form->field($model, 'eduId') ?>

    <?= $form->field($model, 'clubId') ?>

    <?= $form->field($model, 'tglPelayanan') ?>

    <?php // echo $form->field($model, 'kdKegiatan') ?>

    <?php // echo $form->field($model, 'kdKelompok') ?>

    <?php // echo $form->field($model, 'materi') ?>

    <?php // echo $form->field($model, 'pembicara') ?>

    <?php // echo $form->field($model, 'lokasi') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'biaya') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
