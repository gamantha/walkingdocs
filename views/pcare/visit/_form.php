<?php

use kartik\date\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
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
        $('#rujukan').hide();
        if (this.value == 4) {
           $('#rujukan').show();
        } else if (this.value == 6){
        alert('rujuk horizontal belum dipakai'); 
        }
       
        
        });
        
        if($('#pcarevisit-kdstatuspulang').val() == 4) {
      
          $('#rujukan').show();
        } else {
       
         $('#rujukan').hide();
        }
        
        

        
        
        $('input[name=\"PcareVisit[spesialis_type]\"]').on('change', function() { 
        if (this.value == 'khusus') {

        $('#khusus').show();
        $('#spesialis').hide();
        } else {    
        $('#khusus').hide();
        $('#spesialis').show();
        }

        });
                $('#khusus_subspesialis').show();
                
                if($('#khusus-id.form-control :selected').val() == 'HDL') {
      
                } else {
            
                }
         
         
         
                 $('#khusus-id.form-control').on('change', function() { 
            if (this.value == 'HEM') {
        
                    $('#khusus_subspesialis').show();
                    
            } else if(this.value == 'THA') {
        
                    $('#khusus_subspesialis').show();
            } else {
            $('#khusus_subspesialis').hide();
            }
            

        }); 
        
               

        
        $('#pcarevisit-subspesialis_kdsubspesialis1').on('change', function() { 
        $('#pcarevisit-subspesialis_nmsubspesialis1').val($('#pcarevisit-subspesialis_kdsubspesialis1 option:selected').text());
        
//alert($('#pcarevisit-subspesialis_kdsubspesialis1 option:selected').text());

        }); 
        
        
                $('#pcarevisit-kdppk_subspesialis').on('change', function() { 
        $('#pcarevisit-nmppk_subspesialis').val($('#pcarevisit-kdppk_subspesialis option:selected').text());
        

        }); 
        
        
  if($('input[name=\"PcareVisit[spesialis_type]\"]:checked').val() == 'khusus') {
        $('#khusus').show();
        $('#spesialis').hide();
        } else {    
        $('#khusus').hide();
        $('#spesialis').show();
        }                
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

    //    kdTkp
    //    10 -> rawat jalan
    //    20 -> rawat inap
    //    50 -> promotif

    $refspesialis = [];
    $refsarana = [];
    $listData2 = [];
    $refkhususdata = [];
    $refKesadaran = [];
    $refStatuspulang = [];

    $listData2 = $this->context->getDokter($model->pendaftaranId);
    if (!empty($listData2)) {
        $refsarana = $this->context->getSarana($model->pendaftaranId);
        $refspesialis = $this->context->getReferensiSpesialis($model->pendaftaranId);
        $refkhususdata = $this->context->getReferensiKhusus($model->pendaftaranId);
        $refStatuspulang = $this->context->getStatuspulang($model->pendaftaranId);
        $refKesadaran = $this->context->getKesadaran($model->pendaftaranId);
    } else {
        Yii::$app->session->addFlash('danger', 'pcare web service is DOWN');
    }




    echo $form->field($model, 'kdSadar')->dropDownList(
        $refKesadaran,
        ['prompt'=>'Select...']);



    ?>

    <?= $form->field($model, 'terapi')->textarea(['rows' => 6]) ?>



    <?php
//    kdTkp
//    10 -> rawat jalan
//    20 -> rawat inap
//    50 -> promotif




    ?>



    <?php

    echo '<label class="control-label">Tanggal Pulang </label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'tglPulang',
        //'language' => 'ru',
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
//        'format' => 'dd-mm-yyyy'
        ]
    ]);
    ?>

    <?php


    echo Html::hiddenInput('PcareVisit[subSpesialis_nmSubSpesialis1]', $model->subSpesialis_nmSubSpesialis1, ['id' => 'pcarevisit-subspesialis_nmsubspesialis1']);

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
                'data' => new JsExpression('function(params) { return {q:params.term, id:'.$model->id.'}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text + " : " + city.nonspesialis); }'),
            'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text + " : " + city.nonspesialis); }'),
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
                'data' => new JsExpression('function(params) { return {q:params.term, id:'.$model->id.'}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text + " : " + city.nonspesialis); }'),
            'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text + " : " + city.nonspesialis); }'),
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
                'data' => new JsExpression('function(params) { return {q:params.term, id:'.$model->id.'}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return (city.id + " : " + city.text + " : " + city.nonspesialis); }'),
            'templateSelection' => new JsExpression('function (city) { return (city.id + " : " + city.text + " : " + city.nonspesialis); }'),
        ],
    ]);

    ?>



    <?= $form->field($registrationModel, 'sistole')->textInput(['maxlength' => true]) ?>

    <?= $form->field($registrationModel, 'diastole')->textInput(['maxlength' => true]) ?>

    <?= $form->field($registrationModel, 'beratBadan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($registrationModel, 'tinggiBadan')->textInput(['maxlength' => true]) ?>


    <?= $form->field($registrationModel, 'respRate')->textInput(['maxlength' => true]) ?>


    <?= $form->field($registrationModel, 'heartRate')->textInput(['maxlength' => true]) ?>

    HANYA KALAU PILIH RUJUK maka pilihan dibawah jadi nyala .Saat ini hanya ada rujukan vertikal (spesialis , khusus)

    <?php

    //    echo $form->field($model, 'kdPoliRujukInternal')->textInput(['maxlength' => true]);

    echo $form->field($model, 'kdStatusPulang')->label('Status Pulang')->dropDownList(
        $refStatuspulang,
        ['prompt'=>'Select...']);




    ?>

        <div id="rujukan">

        <h3>Rujukan</h3>

        <?php

        echo '<label class="control-label">Tanggal Rencana Berkunjung / rujuk </label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'tglEstRujuk',
            //'language' => 'ru',
            'pluginOptions' => [
                'autoclose'=>true,
                'todayHighlight' => true,
                'todayBtn' => true,
                'format' => 'yyyy-mm-dd'
            ]
//        'dateFormat' => 'yyyy-MM-dd',
        ]);



        echo $form->field($model, 'spesialis_type')->radioList(['khusus' => 'Kondisi Khusus',
            'spesialis' => 'Spesialis']);


 ?>
<div class="well">
    <div id="spesialis" style="display:none">
        <h2>Spesialis</h2><br/>
        <?php
        echo $form->field($model, 'subSpesialis_kdSpesialis')->dropDownList(
            $refspesialis,
            ['prompt'=>'Select...']);

        echo $form->field($model, 'subSpesialis_kdSubSpesialis1')->widget(DepDrop::classname(), [
//            'options'=>['id'=>'subspesialis-id'],
        'data'=>[$model->subSpesialis_kdSubSpesialis1=>$model->subSpesialis_nmSubSpesialis1],
            'pluginOptions'=>[
                'depends'=>['pcarevisit-subspesialis_kdspesialis'],
                'placeholder'=>'Select...',
                'url'=>Url::to(['subspesialis','id' => $model->id])
            ]
        ]);

        echo $form->field($model, 'subSpesialis_kdSarana')->dropDownList(
            $refsarana,
            ['id'=>'pcarevisit-subspesialis_kdsarana','prompt'=>'Select...']);


        echo Html::hiddenInput('PcareVisit[nmppk_subSpesialis]', $model->nmppk_subSpesialis, ['id' => 'pcarevisit-nmppk_subspesialis']);

        echo $form->field($model, 'kdppk_subSpesialis')->widget(DepDrop::classname(), [
                'data'=>[$model->kdppk_subSpesialis=>$model->nmppk_subSpesialis],
            'pluginOptions'=>[
                    'depends'=>['pcarevisit-subspesialis_kdsubspesialis1', 'pcarevisit-subspesialis_kdsarana', 'pcarevisit-tglestrujuk'],
                'placeholder'=>'Select...',
                'url'=>Url::to(['rujukanspesialis','id' => $model->id])
            ]
        ]);

        ?>
    </div>



























    <div id="khusus" style="display:none">
        <h2>Keadaan Khusus</h2><br/>

        <?php


        echo $form->field($model, 'khusus_kdKhusus')->label('Kategori')->dropDownList(
            $refkhususdata,
            ['id'=>'khusus-id','prompt'=>'Select...']);


        $datasubspesialis = [
    "3" => "PENYAKIT DALAM",
    "8" => "HEMATOLOGI - ONKOLOGI MEDIK",
    "26" => "ANAK",
    "30" => "ANAK HEMATOLOGI ONKOLOGI"
];

?>
    <div id="khusus_subspesialis">
        <?php


        echo $form->field($model, 'khusus_kdSubSpesialis')->label('Spesialis')->dropDownList(
            $datasubspesialis,
            ['prompt'=>'Select...']);


        ?>
    </div>

    <?= $form->field($model, 'khusus_catatan')->textarea(['rows' => 6]) ?>
        <?php

        echo Html::hiddenInput('PcareVisit[nmppk]', $model->nmppk, ['id' => 'pcarevisit-nmppk']);


        echo $form->field($model, 'kdppk')->widget(DepDrop::classname(), [
//            'data'=>[$model->kdppk_subSpesialis=>$model->nmppk_subSpesialis],
            'pluginOptions'=>[
                'depends'=>['pcarevisit-khusus_kdkhusus','pcarevisit-khusus_kdsubspesialis', 'pcarevisit-tglestrujuk'],
                'placeholder'=>'Select...',
                'url'=>Url::to(['rujukankhusus','id' => $model->id])
            ]
        ]);






        ?>
        </div>



</div>

            <?php

            $ref_tacc = [
              "-1" => "Tanpa TACC",
                "1" => "Time",
                "2" => "Age",
                "3" => "Complication",
                "4" => "Comorbidity"

            ];

            ?>
    <?= $form->field($model, 'kdTacc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alasanTacc')->textarea(['rows' => 6]) ?>

        </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
