<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\learning\ToolOutput */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tool-output-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tool_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'output_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'output_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
