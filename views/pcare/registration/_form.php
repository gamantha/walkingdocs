<?php

use kartik\date\DatePicker;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pcare-registration-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'pcareregistration-cons_id']) ?>
    <?php

    //echo $form->field($model, 'kdProviderPeserta')->textInput(['maxlength' => true, 'readonly' => false])

    ?>


    <?php
    echo '<label class="control-label">Tanggal Daftar </label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'tglDaftar',
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
//                   'format' => 'dd-mm-yyyy'
    ]
//        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>
<br/>
    <?= $form->field($model, 'noKartu')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nik')->textInput(['maxlength' => true])->label('KTP - digunakan untuk cek peserta apabila no Kartu kosong')  ?>

    <?php

    $refPoli = [];

    if ($model->cons_id) {
        $refPoli = $this->context->getPoli($model->cons_id);
    } else {

    }

    $url = \yii\helpers\Url::to(['getpolicodes']);


    echo $form->field($model, 'kdPoli')->dropDownList(
        $refPoli,
        ['prompt'=>'Select...']);

    ?>



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
    <?= $form->field($model, 'sistole')->textArea(['maxlength' => true]) ?>
    <?= $form->field($model, 'diastole')->textArea(['maxlength' => true]) ?>
    <?php

    echo $form->field($model, 'beratBadan')->textArea(['maxlength' => true]);
    echo $form->field($model, 'tinggiBadan')->textArea(['maxlength' => true]);
    echo $form->field($model, 'respRate')->textArea(['maxlength' => true]);
    echo $form->field($model, 'heartRate')->textArea(['maxlength' => true]);

    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
