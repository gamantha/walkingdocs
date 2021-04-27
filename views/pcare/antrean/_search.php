<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\AntreanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="antrean-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'noKartu') ?>

    <?= $form->field($model, 'nik') ?>

    <?= $form->field($model, 'clinicId') ?>

    <?= $form->field($model, 'tanggalPeriksa') ?>

    <?php // echo $form->field($model, 'kdPoli') ?>

    <?php // echo $form->field($model, 'nmPoli') ?>

    <?php // echo $form->field($model, 'noAntrean') ?>

    <?php // echo $form->field($model, 'angkaAntrean') ?>

    <?php // echo $form->field($model, 'antreanPanggil') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
