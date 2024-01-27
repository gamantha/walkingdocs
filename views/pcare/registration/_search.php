<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistrationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pcare-registration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kdProviderPeserta') ?>

    <?= $form->field($model, 'tglDaftar') ?>

    <?= $form->field($model, 'noKartu') ?>

    <?= $form->field($model, 'kdPoli') ?>

    <?php // echo $form->field($model, 'kunjSakit') ?>

    <?php // echo $form->field($model, 'keluhan') ?>

    <?php // echo $form->field($model, 'sistole') ?>

    <?php // echo $form->field($model, 'diastole') ?>

    <?php // echo $form->field($model, 'beratBadan') ?>

    <?php // echo $form->field($model, 'tinggiBadan') ?>

    <?php // echo $form->field($model, 'respRate') ?>

    <?php // echo $form->field($model, 'heartRate') ?>

    <?php // echo $form->field($model, 'rujukBalik') ?>

    <?php // echo $form->field($model, 'kdTkp') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
