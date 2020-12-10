<?php

use kartik\date\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pcare-visit-form">

    <?php


    $this->registerJs(
        "$('#pcarevisit-kdstatuspulang').on('change', function() { 
        
        if (this.value == 4) {
//         alert('value ' + this.value); 
        } else if (this.value == 6){
        alert('rujuk horizontal belum dipakai'); 
        }
       
        
        });
        
        $('input:radio[name=tipe_rujukan_vertikal]').on('change', function() { 
        if (this.value == 'khusus') {
   
        $('#khusus').show();
        $('#spesialis').hide();
        } else {

        $('#khusus').hide();
        $('#spesialis').show();
        }

        });
        
        
        ",
        View::POS_READY,
        'my-button-handler'
    );


    echo '<h3>Tanggal / No Urut : ';
    echo $model->pendaftaran->tglDaftar . ' / ' . $model->pendaftaran->no_urut;
    echo '</h3>';
    ?>
    <?php $form = ActiveForm::begin(); ?>







    <?php
//    $listData = $this->context->getKesadaran();
//    echo $form->field($model, 'kdSadar')->dropDownList(
//        $listData,
//        ['prompt'=>'Select...']);
//
//

    ?>

    <?= $form->field($model, 'terapi')->textarea(['rows' => 6]) ?>



    <?php
//    kdTkp
//    10 -> rawat jalan
//    20 -> rawat inap
//    50 -> promotif

//    $listData = $this->context->getStatuspulang($model->pendaftaran->kdTkp);
//    echo $form->field($model, 'kdStatusPulang')->dropDownList(
//        $listData,
//        ['prompt'=>'Select...']);
//


    ?>



    <?php

    echo '<label class="control-label">Tanggal Pulang </label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'tglPulang',
        //'language' => 'ru',
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?php
    //    kdTkp
    //    10 -> rawat jalan
    //    20 -> rawat inap
    //    50 -> promotif

    $refspesialis = [];
    $refsarana = [];
    $listData2 = [];
    $refkhususdata = [];

    $listData2 = $this->context->getDokter();
        if (!empty($listData2)) {
                $refsarana = $this->context->getSarana();
    $refspesialis = $this->context->getReferensiSpesialis();
    $refkhususdata = $this->context->getReferensiKhusus();
        } else {
            Yii::$app->session->addFlash('danger', 'pcare web service is DOWN');
        }


    echo $form->field($model, 'kdDokter')->dropDownList(
        $listData2,
        ['prompt'=>'Select...']);

    $url = \yii\helpers\Url::to(['diagnosecode']);
    echo $form->field($model, 'kdDiag1')->widget(Select2::classname(), [
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
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text); }'),
            'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text); }'),
        ],
    ]);
    echo $form->field($model, 'kdDiag2')->widget(Select2::classname(), [
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
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text); }'),
            'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text); }'),
        ],
    ]);

    echo $form->field($model, 'kdDiag3')->widget(Select2::classname(), [
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
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text); }'),
            'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text); }'),
        ],
    ]);

    ?>

    HANYA KALAU PILIH RUJUK maka pilihan dibawah jadi nyala .Saat ini hanya ada rujukan vertikal (spesialis , khusus)

    <?php

//    echo $form->field($model, 'kdPoliRujukInternal')->textInput(['maxlength' => true]);
    ?>


        <h3>Rujukan</h3>

        <?php
        echo Html::radioList('tipe_rujukan_vertikal', '',[
            'khusus' => 'Kondisi Khusus',
            'spesialis' => 'Spesialis'
        ]);

        echo '<label class="control-label">Tanggal Rencana Berkunjung / rujuk </label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'tglEstRujuk',
            //'language' => 'ru',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
//        'dateFormat' => 'yyyy-MM-dd',
        ]);

        ?>


    <?= $form->field($model, 'kdppk')->textInput(['maxlength' => true]) ?>

    <div id="spesialis" class="well" style="display:none">
        <h2>Spesialis</h2><br/>

        <?php


        echo Html::dropDownList('spesialis', null,$refspesialis
            );




        ?>
    <?= $form->field($model, 'subSpesialis_kdSubSpesialis1')->textInput(['maxlength' => true]) ?>



        <?php



        echo $form->field($model, 'subSpesialis_kdSarana')->dropDownList(
            $refsarana,
            ['id'=>'khusus-id','prompt'=>'Select...']);


        ?>

    </div>
    <div id="khusus" class="well" style="display:none">
        <h2>Keadaan Khusus</h2><br/>

        <?php




        echo $form->field($model, 'khusus_kdKhusus')->dropDownList(
            $refkhususdata,
            ['id'=>'khusus-id','prompt'=>'Select...']);


        $datasubspesialis = [
    "3" => "PENYAKIT DALAM",
    "8" => "HEMATOLOGI - ONKOLOGI MEDIK",
    "26" => "ANAK",
    "30" => "ANAK HEMATOLOGI ONKOLOGI"
];



        echo $form->field($model, 'khusus_kdSubSpesialis')->dropDownList(
            $datasubspesialis,
            ['prompt'=>'Select...']);


        ?>


    <?= $form->field($model, 'khusus_catatan')->textarea(['rows' => 6]) ?>
        </div>

    <?= $form->field($model, 'kdTacc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alasanTacc')->textarea(['rows' => 6]) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
