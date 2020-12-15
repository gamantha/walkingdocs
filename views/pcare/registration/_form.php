<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pcare-registration-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($model, 'kdProviderPeserta')->textInput(['maxlength' => true, 'readonly' => true]) ?>


    <?php
    echo '<label class="control-label">Tanggal Daftar </label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'tglDaftar',
        //'language' => 'ru',
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
//        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>

    <?= $form->field($model, 'noKartu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kdPoli')->textInput(['maxlength' => true]) ?>


    <?php

    $listData = ['true' => 'true', 'false' => 'false'];
    echo $form->field($model, 'kunjSakit')->dropDownList(
        $listData,
        ['prompt'=>'Select...']);

    ?>

    <?php

    $listData = ['10' => 'RJTP', '20' => 'RITP', '50' => 'Promotif'];
    echo $form->field($model, 'kdTkp')->dropDownList(
        $listData,
        ['prompt'=>'Select...']);

        ?>


    <?= $form->field($model, 'keluhan')->textArea(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
