<?php

use kartik\date\DatePicker;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="pcare-registration-create">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="pcare-registration-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'pcareregistration-cons_id']) ?>

    <h2>Registration Data</h2>
    <div class="well">
        <?php
        echo '<pre>';
        print_r($model->params);
        echo '</pre>';
        ?>

        <?= $form->field($model, 'params')->textInput(['maxlength' => true]) ?>

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

    <?php
echo $form->field($model, 'nik')->textInput(['maxlength' => true])->label('KTP - digunakan untuk cek peserta apabila no Kartu kosong');
    $refPoli = [];


    $url = \yii\helpers\Url::to(['getpolicodes']);


    ?>



    <?php

    $listData = ['10' => 'RJTP', '20' => 'RITP', '50' => 'Promotif'];
    echo $form->field($model, 'kdTkp')->dropDownList(
        $listData,
        ['prompt'=>'Select...']);

    echo '<label class="control-label">Tanggal Pulang (HARUS APABILA RITP) </label>';
    echo DatePicker::widget([
        'model' => $visitmodel,
        'attribute' => 'tglPulang',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
//                   'format' => 'dd-mm-yyyy'
        ]
//        'dateFormat' => 'yyyy-MM-dd',
    ]);




    echo $form->field($visitmodel, 'kdStatusPulang')->widget(DepDrop::classname(), [
                'data' => [$visitmodel->kdStatusPulang => 'Poli ...'],
        'pluginOptions'=>[
            'depends'=>['pcareregistration-kdtkp'],
            'initialize' => true,
            'initDepends' => ['pcareregistration-kdtkp'],
            'placeholder'=>'Select...',
            'url'=>Url::to(['getstatuspulang','consid' => $model->cons_id])

        ]
    ]);


//    echo $form->field($visitmodel, 'kdStatusPulang')->label('Status Pulang')->dropDownList(
//        $refStatuspulang,
//        ['prompt'=>'Select...']);




    $listData = ['true' => 'Kunjungan Sakit', 'false' => 'Kunjungan Sehat'];
    echo $form->field($model, 'kunjSakit')->dropDownList(
        $listData,
        ['prompt'=>'Select...'])->label("Jenis Kunjungan");




    echo $form->field($model, 'kdPoli')->widget(DepDrop::classname(), [
            'data' => [$model->kdPoli => 'Poli ...'],
        'pluginOptions'=>[
            'depends'=>['pcareregistration-kunjsakit'],
            'initialize' => true,
            'initDepends' => ['pcareregistration-kunjsakit'],
            'placeholder'=>'Select...',
            'url'=>Url::to(['getfilteredpolicodes','consid' => $model->cons_id])
//            'url'=>Url::to(['/site/prod'])
        ]
    ]);


    ?>

    <?php


        ?>


    <?= $form->field($visitmodel, 'keluhan')->textArea(['maxlength' => true]) ?>
    <?= $form->field($visitmodel, 'sistole')->textArea(['maxlength' => true]) ?>
    <?= $form->field($visitmodel, 'diastole')->textArea(['maxlength' => true]) ?>
    <?php

    echo $form->field($visitmodel, 'beratBadan')->textArea(['maxlength' => true]);
    echo $form->field($visitmodel, 'tinggiBadan')->textArea(['maxlength' => true]);
    echo $form->field($visitmodel, 'respRate')->textArea(['maxlength' => true]);
    echo $form->field($visitmodel, 'heartRate')->textArea(['maxlength' => true]);

    ?>
</div>


Once sent cannot be undone
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Next'), ['name' => 'confirm','class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('app', 'Confirm & Register'), ['name' => 'register','class' => 'btn btn-success']) ?>
        <?= Html::submitButton(Yii::t('app', 'Update Visit'), ['name' => 'update','class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
