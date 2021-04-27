<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\Antrean */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="antrean-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'noKartu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nik')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clinicId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggalPeriksa')->textInput() ?>

    <?= $form->field($model, 'kdPoli')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nmPoli')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noAntrean')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'angkaAntrean')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'antreanPanggil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
