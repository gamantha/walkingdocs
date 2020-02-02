<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PendaftaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pendaftaran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no_bpjs') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'status_peserta') ?>

    <?= $form->field($model, 'jenis_peserta') ?>

    <?php // echo $form->field($model, 'tanggal_lahir') ?>

    <?php // echo $form->field($model, 'kelamin') ?>

    <?php // echo $form->field($model, 'ppk_umum') ?>

    <?php // echo $form->field($model, 'no_handphone') ?>

    <?php // echo $form->field($model, 'no_rekam_medis') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
