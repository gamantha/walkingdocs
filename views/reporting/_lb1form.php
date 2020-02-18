<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reportId')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'indicatorName')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'indicatorId')->hiddenInput()->label(false) ?>


    <?= $form->field($model, 'm_0d7d')->textInput()->label('L 0-7 days') ?>
    <?= $form->field($model, 'f_0d7d')->textInput()->label('P 0-7 days') ?>
    <?= $form->field($model, 'm_8d28d')->textInput()->label('L 8-28 days') ?>
    <?= $form->field($model, 'f_8d28d')->textInput()->label('P 8-28 days') ?>
    <?= $form->field($model, 'm_1m1y')->textInput()->label('L 1 Month - 1 Year') ?>
    <?= $form->field($model, 'f_1m1y')->textInput()->label('P 1 Month - 1 Year') ?>
    <?= $form->field($model, 'm_1y4y')->textInput() ?>
    <?= $form->field($model, 'f_1y4y')->textInput() ?>
    <?= $form->field($model, 'm_5y9y')->textInput() ?>
    <?= $form->field($model, 'f_5y9y')->textInput() ?>
    <?= $form->field($model, 'm_10y14y')->textInput() ?>
    <?= $form->field($model, 'f_10y14y')->textInput() ?>
    <?= $form->field($model, 'm_15y19y')->textInput() ?>
    <?= $form->field($model, 'f_15y19y')->textInput() ?>
    <?= $form->field($model, 'm_20y44y')->textInput() ?>
    <?= $form->field($model, 'f_20y44y')->textInput() ?>
    <?= $form->field($model, 'm_45y54y')->textInput() ?>
    <?= $form->field($model, 'f_45y54y')->textInput() ?>
    <?= $form->field($model, 'm_55y59y')->textInput() ?>
    <?= $form->field($model, 'f_55y59y')->textInput() ?>
    <?= $form->field($model, 'm_60y69y')->textInput() ?>
    <?= $form->field($model, 'f_60y69y')->textInput() ?>
    <?= $form->field($model, 'm_70y')->textInput() ?>
    <?= $form->field($model, 'f_70y')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
