<?php

use kartik\date\DatePicker;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="pcare-registration-create">
    <?php
    $this->registerJs(

        "
              $('#spesialis').hide();
                        $('#khusus').hide();
        $('#pcarevisit-kdstatuspulang').on('change', function() { 
  if (this.value == 4) {
alert('4');
       $('#rujukan').show();
  } else {
       $('#rujukan').hide();
       
  }
        });
        

        
        $('input[name=\"PcareVisit[spesialis_type]\"]').on('change', function() { 

        if (this.value == 'khusus') {

        $('#khusus').show();
        $('#spesialis').hide();
        } else {    
        $('#khusus').hide();
        $('#spesialis').show();
        }

        });

         
         
         
                 $('#pcarevisit-khusus_kdkhusus.form-control').on('change', function() { 
            if (this.value == 'HEM') {
        
                    $('#khusus_subspesialis').show();
               
                    
            } else if(this.value == 'THA') {
        
                    $('#khusus_subspesialis').show();
               
            } else {
 $('#khusus_subspesialis').hide();
            }
            

        }); 
        
               
$('#pcarevisit-kddiag1').on('change', function() { 
$('#pcarevisit-nmdiag1').val($('#pcarevisit-kddiag1 option:selected').text());
}); 

$('#pcarevisit-kddiag2').on('change', function() { 
$('#pcarevisit-nmdiag2').val($('#pcarevisit-kddiag2 option:selected').text());
}); 

$('#pcarevisit-kddiag3').on('change', function() { 
$('#pcarevisit-nmdiag3').val($('#pcarevisit-kddiag3 option:selected').text());
}); 
        
        $('#pcarevisit-subspesialis_kdsubspesialis1').on('change', function() { 
        $('#pcarevisit-subspesialis_nmsubspesialis1').val($('#pcarevisit-subspesialis_kdsubspesialis1 option:selected').text());
        

        }); 
        
        
                $('#pcarevisit-kdppk_subspesialis').on('change', function() { 
        $('#pcarevisit-nmppk_subspesialis').val($('#pcarevisit-kdppk_subspesialis option:selected').text());

       
        
        var ajaxResults = $('#pcarevisit-kdppk_subspesialis').depdrop('getAjaxResults');
        $('#schedule').val(ajaxResults.output.results[0].jadwal);

         $('#pcarevisit-meta_rujukan').val(JSON.stringify(ajaxResults.output.results[0]));

        }); 
        
        $('#pcarevisit-kdppk_subspesialis').on('depdrop:beforeChange', function(event, id, value, jqXHR, textStatus) {


});


        $('#pcarevisit-kdppk_subspesialis').on('depdrop:change', function(event, id, value, count, textStatus, jqXHR) {

});


                  if($('#pcarevisit-kdstatuspulang').val() == 4) {
     $('#rujukan').show();
          } else {

          $('#rujukan').hide();
          }
        
        
          if($('input[name=\"PcareVisit[spesialis_type]\"]:checked').val() == 'khusus') {
        $('#khusus').show();
  
        } else if($('input[name=\"PcareVisit[spesialis_type]\"]:checked').val() == 'spesialis') {    
      
        $('#spesialis').show();

        } else {
          $('#khusus').hide();
            $('#khusus').hide();
        }


        ",
        View::POS_READY,
        'my-button-handler'
    );



    ?>
    <h1><?= Html::encode($this->title) ?></h1>

<div class="pcare-registration-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'pcareregistration-cons_id']) ?>

    <h2>Registration Data</h2>
    <div class="well">
        <?php
//        echo '<pre>';
//        print_r($model->params);
//        echo '</pre>';
//echo $form->field($model, 'params')->textInput(['maxlength' => true]);
        // ?>

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

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'noKartu')->textInput(['maxlength' => true,'readonly' => true,]) ?>
            </div>
            <div class="col-md-6">
                <?php
                echo $form->field($model, 'nik')->textInput(['maxlength' => true])->label('KTP - digunakan untuk cek peserta apabila no Kartu kosong');
                //                    $refPoli = [];
                //                    $url = \yii\helpers\Url::to(['getpolicodes']);
                ?>
                <?= Html::submitButton(Yii::t('app', 'Cek'), ['name' => 'cek','class' => 'btn btn-success']) ?>
            </div>

        </div>

    <?php






//    echo $form->field($visitmodel, 'kdStatusPulang')->label('Status Pulang')->dropDownList(
//        $refStatuspulang,
//        ['prompt'=>'Select...']);




    $listData = ['true' => 'Kunjungan Sakit', 'false' => 'Kunjungan Sehat'];




    ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'kunjSakit')->dropDownList(
                    $listData,
                    ['prompt'=>'Select...'])->label("Jenis Kunjungan") ?>
            </div>
            <div class="col-md-6">
                <?php

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
            </div>
        </div>
    <?php


        ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($visitmodel, 'sistole')->textArea(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($visitmodel, 'diastole')->textArea(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($visitmodel, 'beratBadan')->textArea(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($visitmodel, 'tinggiBadan')->textArea(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($visitmodel, 'respRate')->textArea(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($visitmodel, 'heartRate')->textArea(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">

            <div class="col-md-3">
                <?php
                $listData = ['10' => 'RJTP', '20' => 'RITP', '50' => 'Promotif'];
                echo $form->field($model, 'kdTkp')->dropDownList(
                    $listData,
                    ['prompt'=>'Select...', 'readonly' => false]);
                ?>
            </div>
            <div class="col-md-3">
                <?php


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

                ?>
            </div>
            <div class="col-md-6">
                <?php
                echo '<label class="control-label">Tanggal Pulang (HARUS APABILA RITP) </label>';
                echo DatePicker::widget([
                    'model' => $visitmodel,
                    'attribute' => 'tglPulang',
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);

                ?>
            </div>
        </div>

</div>

    <h2>Visit Data</h2>
    <div class="well">
        <?php
        echo $form->field($wdmodel, 'doctor')->textInput(['maxlength' => true,'readonly' => true]);
?>
        <div class="row">
            <div class="col-md-6">
                <?php

                echo $form->field($visitmodel, 'kdDokter')->dropDownList(
                    $listData2,
                    ['prompt'=>'Select...']);
                ?>
            </div>
            <div class="col-md-6">
                <?php
                echo $form->field($visitmodel, 'kdSadar')->dropDownList(
                    $refKesadaran,
                    ['prompt'=>'Select...']);

                ?>
            </div>
        </div>
        <?php

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

            $diagnoses = json_decode($wdmodel->manualDiagnoses);

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


    <div id="rujukan" class="">
        <h2>Rujukan</h2>
        HANYA KALAU PILIH RUJUK maka pilihan dibawah jadi nyala .Saat ini hanya ada rujukan vertikal (spesialis , khusus)
        <div class="well">
            <?php
            $ref_tacc = [
                "-1" => "Tanpa TACC",
                "1" => "Time",
                "2" => "Age",
                "3" => "Complication",
                "4" => "Comorbidity"

            ];
            echo '<label class="control-label">Tanggal Rencana Berkunjung / rujuk </label>';
            echo DatePicker::widget([
                'model' => $visitmodel,
                'attribute' => 'tglEstRujuk',
                //'language' => 'ru',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'format' => 'yyyy-mm-dd',
                    'startDate'=> date('d-m-Y H:i',time()),
                    'endDate'=> Date('Y-m-d', strtotime('+7 days')),
                ]
//        'dateFormat' => 'yyyy-MM-dd',
            ]);
            //echo '<br/>';
            echo $form->field($visitmodel, 'spesialis_type')->radioList(['khusus' => 'Kondisi Khusus',
                'spesialis' => 'Spesialis']);
            //    echo '<br/>';
            ?>
        </div>

        <div class="well">

            <div id="spesialis">
                <h2>Spesialis</h2><br/>

            <?php
            echo $form->field($visitmodel, 'subSpesialis_kdSpesialis')->dropDownList(
                $refSpesialis,
                ['prompt'=>'Select...']);

            echo $form->field($visitmodel, 'subSpesialis_kdSubSpesialis1')->widget(DepDrop::classname(), [
//                'data' => [2 => 'Tablets'],
                    'data'=>[$visitmodel->subSpesialis_kdSubSpesialis1=>$visitmodel->subSpesialis_nmSubSpesialis1],
                'pluginOptions'=>[
                    'initialize' => true,
                    'depends'=>['pcarevisit-subspesialis_kdspesialis'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['subspesialis','consid' => $model->cons_id])
                ]
            ]);

            echo $form->field($visitmodel, 'subSpesialis_kdSarana')->widget(DepDrop::classname(), [
//            'options'=>['id'=>'subspesialis-id'],
                'data'=>[$visitmodel->subSpesialis_kdSarana =>$visitmodel->subSpesialis_nmSarana],
                'pluginOptions'=>[
                    'initialize' => true,
                    'depends'=>['pcarevisit-subspesialis_kdsubspesialis1'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['subspesialiskdsarana','consid' => $model->cons_id])
                ]
            ]);


            echo Html::hiddenInput('PcareVisit[subSpesialis_nmSubSpesialis1]', $visitmodel->subSpesialis_nmSubSpesialis1, ['id' => 'pcarevisit-subspesialis_nmspesialis1']);
            echo Html::hiddenInput('PcareVisit[subSpesialis_nmSarana]', $visitmodel->subSpesialis_nmSarana, ['id' => 'pcarevisit-subspesialis_nmsarana']);

            echo Html::hiddenInput('PcareVisit[nmppk_subSpesialis]', $visitmodel->nmppk_subSpesialis, ['id' => 'pcarevisit-nmppk_subspesialis']);
            echo Html::hiddenInput('PcareVisit[meta_rujukan]', $visitmodel->meta_rujukan, ['id' => 'pcarevisit-meta_rujukan']);
            //        echo Html::hiddenInput('PcareVisit[nmppk_subSpesialis]', $model->meta_rujukan, ['id' => 'pcarevisit-meta_rujukan']);

            echo $form->field($visitmodel, 'kdppk_subSpesialis')->widget(DepDrop::classname(), [
                'data'=>[$visitmodel->kdppk_subSpesialis=>$visitmodel->nmppk_subSpesialis],
                'pluginOptions'=>[
                    'initialize' => true,
                    'depends'=>['pcarevisit-subspesialis_kdsubspesialis1','pcarevisit-subspesialis_kdsarana', 'pcarevisit-tglestrujuk'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['rujukanspesialis','consid' => $model->cons_id]),
                ]
            ]);
            echo '<label class="control-label">Info Jadwal</label>';
            echo Html::textArea('schedule',"",['id'=>'schedule', 'class' => 'form-control']);
            ?>
                    </div>

                    <div id="khusus">
            <h2>Keadaan Khusus</h2><br/>
            <div id="khusus_spesialis">


            <?php
            echo $form->field($visitmodel, 'khusus_kdKhusus')->label('Khusus')->dropDownList(
                $refKhususdata,
                ['id'=>'pcarevisit-khusus_kdkhusus','prompt'=>'Select...']);


            $datasubspesialis = [
                "3" => "PENYAKIT DALAM",
                "8" => "HEMATOLOGI - ONKOLOGI MEDIK",
                "26" => "ANAK",
                "30" => "ANAK HEMATOLOGI ONKOLOGI"
            ];
            echo Html::hiddenInput('PcareVisit[nmppk]', $visitmodel->nmppk, ['id' => 'pcarevisit-nmppk']);

            echo $form->field($visitmodel, 'kdppk')->widget(DepDrop::classname(), [
                'data'=>[$visitmodel->kdppk  =>$visitmodel->nmppk],
                'pluginOptions'=>[
                    'depends'=>['pcarevisit-khusus_kdkhusus', 'pcarevisit-tglestrujuk'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['rujukankhusus1','consid' => $model->cons_id, 'nokartu' => $model->noKartu])
                ],
                'pluginEvents' => [
                    'depdrop:afterChange'=>'function(event, id, value) { 
    
                            }',
                ]
            ]);


            ?>
            </div>
            <div id="khusus_subspesialis">
                <?php


                echo $form->field($visitmodel, 'khusus_kdSubSpesialis')->label('Khusus SubSpesialis THALASEMIA & HEMOFILI')->dropDownList(
                    $datasubspesialis,
                    ['prompt'=>'Select...']);

                echo $form->field($visitmodel, 'kdppk_khusus')->label("Rujukan khusus THA & HEM")->widget(DepDrop::classname(), [
                    'data'=>[$visitmodel->kdppk_khusus  =>$visitmodel->nmppk_khusus],
                    'pluginOptions'=>[
                        'depends'=>['pcarevisit-khusus_kdkhusus','pcarevisit-khusus_kdsubspesialis', 'pcarevisit-tglestrujuk'],
                        'placeholder'=>'Select...',
                        'url'=>Url::to(['rujukankhusus2','consid' => $model->cons_id, 'nokartu' => $model->noKartu])
                    ],
                    'pluginEvents' => [
                        'depdrop:afterChange'=>'function(event, id, value) { 
     
                            }',
                    ]
                ]);

                ?>
            </div>

            <?= $form->field($visitmodel, 'khusus_catatan')->textarea(['rows' => 6]) ?>
            <?php




            ?>
        </div>

    </div>
    </div>

    <div class="form-group">
        <?php
        //Html::submitButton(Yii::t('app', 'Next'), ['name' => 'confirm','class' => 'btn btn-success'])
        echo Html::submitButton(Yii::t('app', 'Confirm & Register'), ['name' => 'register','class' => 'btn btn-success']);
        //Html::submitButton(Yii::t('app', 'Update Visit'), ['name' => 'update','class' => 'btn btn-success'])
        ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
