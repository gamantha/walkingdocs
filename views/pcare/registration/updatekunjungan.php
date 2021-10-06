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


            echo $form->field($visitmodel, 'kdStatusPulang')->widget(DepDrop::classname(), [
//                'data' => [$model->kdPoli => 'Poli ...'],
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




            ?>

            <?php


            ?>


            <?= $form->field($model, 'keluhan')->textArea(['maxlength' => true]) ?>
            <?= $form->field($visitmodel, 'sistole')->textArea(['maxlength' => true]) ?>
            <?= $form->field($visitmodel, 'diastole')->textArea(['maxlength' => true]) ?>
            <?php

            echo $form->field($visitmodel, 'beratBadan')->textArea(['maxlength' => true]);
            echo $form->field($visitmodel, 'tinggiBadan')->textArea(['maxlength' => true]);
            echo $form->field($visitmodel, 'respRate')->textArea(['maxlength' => true]);
            echo $form->field($visitmodel, 'heartRate')->textArea(['maxlength' => true]);

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



            ?>

            <div class="well">

                <label class="control-label" style="color:blue;font-size: 100%">Diagnosa Daftar Tilik</label>
                <?php
                echo $form->field($wdmodel, 'checklistNames')->textArea(['maxlength' => true,'readonly' => true,'rows' => '3'])
                    ->label(false)
                ;

                echo $form->field($wdmodel, 'manualDiagnoses')->textArea(['maxlength' => true,'readonly' => true,'rows' => '3'])
                    ->label(false)
                ;



                //            echo Html::label('Diagnosa Manual', 'treatment', ['class' => 'control-label','style'=>'color:blue;font-size: 100%']);
                //            echo '<br />';

                $diagnoses = json_decode($wdmodel->manualDiagnoses);
                //            echo $diagnoses->treatment;
                //            echo $form->field($wdmodel, 'manualDiagnoses')->textInput(['maxlength' => true,'readonly' => true,'rows' => '6'])->label(false);


                echo Html::label('Diagnosa Manual', 'description', ['class' => 'control-label','style'=>'color:blue;font-size: 100%; font-weight:200;']);

                $wdmodel->manualDiagnose_description = isset($diagnoses->description)? $diagnoses->description : "";
                $wdmodel->manualDiagnose_treatment = isset($diagnoses->treatment)? $diagnoses->treatment : "";
                echo Html::input('text', 'description', $wdmodel->manualDiagnose_description , ['class' =>'form-control', 'readonly' => true]);
                echo '<div class="help-block"></div>';
                echo Html::label('Treatment', 'treatment', ['class' => 'control-label','style'=>'color:blue;font-size: 100%; font-weight:200;']);
                echo Html::input('text', 'treatment', $wdmodel->manualDiagnose_treatment, ['class' =>'form-control', 'readonly' => true]);





                echo $form->field($wdmodel, 'clinicId')->hiddenInput(['maxlength' => true,'readonly' => true,'rows' => '3'])->label(false);

                echo $form->field($wdmodel, 'wdVisitId')->hiddenInput(['maxlength' => true, 'readonly' => true, 'rows' => '3'])->label(false);
                ?>


            </div>
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
