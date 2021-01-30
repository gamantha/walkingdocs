<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Consid */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consid-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wd_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'secretkey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kdaplikasi')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>