<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pendaftaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pendaftaran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_bpjs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_peserta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jenis_peserta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_lahir')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelamin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ppk_umum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_handphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_rekam_medis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'modified_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
