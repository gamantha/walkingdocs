<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KunjunganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kunjungan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pendaftaran_id') ?>

    <?= $form->field($model, 'jenis_kunjungan') ?>

    <?= $form->field($model, 'perawatan') ?>

    <?= $form->field($model, 'poli_tujuan') ?>

    <?php // echo $form->field($model, 'keluhan') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
