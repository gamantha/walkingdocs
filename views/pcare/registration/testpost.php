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
    <?php
    echo '<pre>';
    print_r($params);
    echo '</pre>';
    ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'pcareregistration-cons_id']) ?>

    <h2>Registration Data</h2>
    <div class="well">

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



    $listData = ['true' => 'Kunjungan Sakit', 'false' => 'Kunjungan Sehat'];
    echo $form->field($model, 'kunjSakit')->dropDownList(
        $listData,
        ['prompt'=>'Select...'])->label("Jenis Kunjungan");




    echo $form->field($model, 'kdPoli')->widget(DepDrop::classname(), [
//            'data' => $initPoli,
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


    <?= $form->field($model, 'keluhan')->textArea(['maxlength' => true]) ?>
    <?= $form->field($model, 'sistole')->textArea(['maxlength' => true]) ?>
    <?= $form->field($model, 'diastole')->textArea(['maxlength' => true]) ?>
    <?php

    echo $form->field($model, 'beratBadan')->textArea(['maxlength' => true]);
    echo $form->field($model, 'tinggiBadan')->textArea(['maxlength' => true]);
    echo $form->field($model, 'respRate')->textArea(['maxlength' => true]);
    echo $form->field($model, 'heartRate')->textArea(['maxlength' => true]);

    ?>
</div>
    <h2>Visit Data</h2>
    <div class="well">





        <?php

        echo $form->field($wdmodel, 'doctor')->textInput(['maxlength' => true,'readonly' => true]);
        echo $form->field($visitmodel, 'kdDokter')->dropDownList(
            $listData2,
            ['prompt'=>'Select...']);
//        echo '<hr/>';
        echo $form->field($visitmodel, 'kdSadar')->dropDownList(
            $refKesadaran,
            ['prompt'=>'Select...']);

        $url = \yii\helpers\Url::to(['diagnosecode','consid' => $model->cons_id]);
        echo $form->field($visitmodel, 'kdDiag1')->widget(Select2::classname(), [
            'options' => ['placeholder' => 'Search for diagnose...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term, id:'.$model->cons_id.'}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text); }'),
                'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text); }'),
            ],
        ]);

        echo $form->field($visitmodel, 'kdDiag2')->widget(Select2::classname(), [
            'options' => ['placeholder' => 'Search for diagnose...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term, id:'.$model->cons_id.'}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text); }'),
                'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text); }'),
            ],
        ]);

        echo $form->field($visitmodel, 'kdDiag3')->widget(Select2::classname(), [
            'options' => ['placeholder' => 'Search for diagnose...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term, id:'.$model->cons_id.'}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text); }'),
                'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text); }'),
            ],
        ]);

//echo '<hr/>';
        echo $form->field($visitmodel, 'terapi')->textArea(['maxlength' => true,'readonly' => true,'rows' => '3']);

//        foreach ($prescribed_list as $prescribed)
//        {
//            echo $prescribed;
//            echo '<br/>';
//        }

        //        echo $visitmodel->terapi;



        ?>

        <div class="well">

            <label class="control-label" style="color:blue;font-size: 100%">Diagnosa Daftar Tilik</label>
            <?php
            echo $form->field($wdmodel, 'checklistNames')->textArea(['maxlength' => true,'readonly' => true,'rows' => '3'])
                ->label(false)
            ;

//            echo Html::label('Diagnosa Manual', 'treatment', ['class' => 'control-label','style'=>'color:blue;font-size: 100%']);
//            echo '<br />';

            $diagnoses = json_decode($wdmodel->manualDiagnoses);
//            echo $diagnoses->treatment;
//            echo $form->field($wdmodel, 'manualDiagnoses')->textInput(['maxlength' => true,'readonly' => true,'rows' => '6'])->label(false);


            echo Html::label('Diagnosa Manual', 'description', ['class' => 'control-label','style'=>'color:blue;font-size: 100%; font-weight:200;']);

            $description = isset($diagnoses->description)? $diagnoses->description : "";
            $treatment = isset($diagnoses->treatment)? $diagnoses->treatment : "";
            echo Html::input('text', 'description', $description, ['class' =>'form-control', 'readonly' => true]);
            echo '<div class="help-block"></div>';
            echo Html::label('Treatment', 'treatment', ['class' => 'control-label','style'=>'color:blue;font-size: 100%; font-weight:200;']);
            echo Html::input('text', 'treatment', $treatment, ['class' =>'form-control', 'readonly' => true]);



            echo $form->field($wdmodel, 'clinicId')->hiddenInput(['maxlength' => true,'readonly' => true,'rows' => '3'])->label(false);

            echo $form->field($wdmodel, 'wdVisitId')->hiddenInput(['maxlength' => true, 'readonly' => true, 'rows' => '3'])->label(false);
            ?>


        </div>
</div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Register to Pcare'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
