<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\learning\ToolCalculation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tool-calculation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tool_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'formula')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
