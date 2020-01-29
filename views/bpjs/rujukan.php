<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Bpjs;
use app\models\Icd10;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

use kartik\widgets\TypeaheadBasic;

/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */

$this->title = $kunjungan_model->pendaftaran_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pendaftaran / Kunjungan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);



$js=<<<js


$('#rujukanradio').on('change', function() {
   alert($('[name=rujukanmodelradio]:checked').val()); 
});


;


    $( "#catstatuspulang-id" ).change(function() {
        var id = $( "#catstatuspulang-id" ).val();
        if (id == 6) {
                $( "#6-modal" ).show();
                $( "#4-modal" ).hide();
        } else {
                $( "#4-modal" ).show();
                $( "#6-modal" ).hide();
        }
    
    });

var statuspulang = $( "#catstatuspulang-id" ).val();
if (statuspulang == 6) {
                $( "#6-modal" ).show();
                $( "#4-modal" ).hide();
        } else {
                $( "#4-modal" ).show();
                $( "#6-modal" ).hide();
        }
            
js;
$this->registerJs($js);



?>



<div class="kunjungan-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php
    $saranares = Bpjs::getSarana();
    $saranaresponse = json_decode($saranares);
    $saranaarray = ArrayHelper::map($saranaresponse->response->list, 'kdSarana', 'nmSarana');

    $khususres = Bpjs::getKhusus();
    $khususresponse = json_decode($khususres);
    $khususarray = ArrayHelper::map($khususresponse->response->list, 'kdKhusus', 'nmKhusus');

    $statuspulang = Bpjs::getStatuspulang('false');
    $statuspulangresponse = json_decode($statuspulang);
    $statuspulangarray = ArrayHelper::map($statuspulangresponse->response->list, 'kdStatusPulang', 'nmStatusPulang');
    $subspesialis_list = [];


    $spesialisres = Bpjs::getSpesialis();
    $spesialisresponse = json_decode($spesialisres);


    $spesialisarray = ArrayHelper::map($spesialisresponse->response->list, 'kdSpesialis', 'nmSpesialis');


    if (isset($rujukanModel->kdSubSpesialis1)) {
        $ss1 = json_decode(Bpjs::getSubspesialis($rujukanModel->kdSpesialis));
        $temp_array1 = [];
        foreach ($ss1->response->list as $ss){
            array_push($temp_array1, ['id' => $ss->kdSubSpesialis,'name' => $ss->nmSubSpesialis]);
        }
        $subspesialis_list =  ArrayHelper::map($temp_array1, 'id', 'name');


    }
    $subspesialiskhusus_list = [];

    $khusus_array = ['THA', 'HEM'];
    if (in_array($rujukanModel->kdKhusus, $khusus_array))
    {
        $subspesialiskhusus_array=[
            ['id' => '3', 'name' => 'PENYAKIT DALAM'],
            ['id' => '8', 'name' => 'HEMATOLOGI - ONKOLOGI MEDIK'],
            ['id' => '26', 'name' => 'ANAK'],
            ['id' => '30', 'name' => 'ANAK HEMATOLOGI ONKOLOGI']
        ];
    } else {
        $subspesialiskhusus_array=[
            ['id' => '0', 'name' => 'NOT APPLICABLE']
        ];
    }

    $subspesialiskhusus_list = ArrayHelper::map($subspesialiskhusus_array, 'id', 'name');



    $ppk_list = ['0' => 'N/A'];
    $ppk_container = $rujukanModel->kdppk;
    if (isset($ppk_container) && $ppk_container != '0') {
        $ppk1 = json_decode(Bpjs::getFaskesrujukansubspesialis($rujukanModel->kdSubSpesialis1,$rujukanModel->kdSarana,$rujukanModel->tanggal_estimasi));
        $ppk_array1 = [];
        foreach ($ppk1->response->list as $ss){
            array_push($ppk_array1, ['id' => $ss->kdppk,'name' => $ss->nmppk]);
        }
        $ppk_list =  ArrayHelper::map($ppk_array1, 'id', 'name');

    }


    $ppkkhusus_list = [];
    $ppkkhusus_container = $rujukanModel->kdPpkKhusus;
    if (isset($ppkkhusus_container) && ($ppkkhusus_container != 'null')) {
        $ppkkhusus1 = json_decode(Bpjs::getFaskesrujukankhusus($rujukanModel->kdKhusus, $rujukanModel->kdSubSpesialisKhusus,$rujukanModel->kunjungan->pendaftaran->no_bpjs,$rujukanModel->tanggal_estimasi));
        $ppkkhusus_array1 = [];
        foreach ($ppkkhusus1->response->list as $ss){
            array_push($ppkkhusus_array1, ['id' => $ss->kdppk,'name' => $ss->nmppk]);
        }
        $ppkkhusus_list =  ArrayHelper::map($ppkkhusus_array1, 'id', 'name');

    }




    echo '<h2>Pulang / Rujuk</h2>';

    echo $form->field($rujukanModel, 'kunjungan_id')->textInput(['readonly' => true, 'id' => 'kunjungan-id']);
    echo $form->field($rujukanModel, 'tanggal_estimasi')->widget(DatePicker::classname(),[
        'options' => ['placeholder' => 'Select time ...','id' => 'rujukandate-id'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-M-d',
            //'startDate' => '01-Mar-2019 12:00 AM',
            'todayHighlight' => true
        ]

    ]);

//    echo DatePicker::widget([
//        'name' => 'dp_1',
//        'type' => DatePicker::TYPE_INPUT,
//        'value' => '23-Feb-1982',
//        'pluginOptions' => [
//            'autoclose'=>true,
//            'format' => 'dd-M-yyyy'
//        ]
//    ]);






    ?>
    <div id="4-modal" style="display: none;">
        <?php

        $radio_ary = [
            'spesialis' => 'Spesialis',
            'khusus' => 'Kondisi Khusus'
        ];
        ?>

            <?php
            //echo Html::radioList('rujukanmodelradio ', null,$radio_ary );

            echo $form->field($rujukanModel, 'tipe_rujukan')->dropDownList(
                ['spesialis' => 'Spesialis', 'khusus' => 'Khusus'],
                ['prompt' => 'Select...']
            );
            ?>


        <div id="#spesialis">
            <?php
            echo $form->field($rujukanModel, 'kdSpesialis')->dropDownList(
                $spesialisarray,
                ['prompt' => 'Select...', 'id' => 'spesialis-id']
            );

            echo Html::hiddenInput('input-type-1', 'Additional value 1', ['id' => 'input-type-1']);
            echo Html::hiddenInput('input-type-2', 'Additional value 2', ['id' => 'input-type-2']);

            echo $form->field($rujukanModel, 'kdSubSpesialis1')->widget(DepDrop::classname(), [
                'data' => $subspesialis_list,
                'options'=>['id'=>'subspesialis1-id'],
                'pluginOptions'=>[
                    'depends'=>['spesialis-id'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['/bpjs/subspesialis']),
                    'params' => ['input-type-1', 'input-type-2']
                ]
            ]);

            echo $form->field($rujukanModel, 'kdSarana')->dropDownList(
                $saranaarray,
                ['prompt' => 'Select...', 'id' => 'sarana-id']
            );

            echo $form->field($rujukanModel, 'kdppk')->widget(DepDrop::classname(), [
                'data' => $ppk_list,
                'options'=>['id'=>'ppk-id','placeholder' => 'Select ...'],
                'pluginOptions'=>[
                    'depends'=>['sarana-id','subspesialis1-id', 'rujukandate-id'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['/bpjs/faskes'])
                ]
            ]);



            ?>
        </div>
        <div id="#khusus">
            <h2>KHUSUS DIBAWAH INI</h2>
            <?php
            echo $form->field($rujukanModel, 'kdKhusus')->dropDownList(
                $khususarray,
                ['prompt' => 'Select...', 'id' => 'khusus-id']
            );



            echo $form->field($rujukanModel, 'kdSubSpesialisKhusus')->widget(DepDrop::classname(), [
                'data' => $subspesialiskhusus_list,
                'options'=>['id'=>'subspesialiskhusus-id'],
                'pluginOptions'=>[
                    'depends'=>['khusus-id'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['/bpjs/subspesialiskhusus']),
                    //'params' => ['input-type-1', 'input-type-2']
                ]
            ]);


            echo $form->field($rujukanModel, 'kdPpkKhusus')->widget(DepDrop::classname(), [
                'data' => $ppkkhusus_list,
                'options'=>['id'=>'ppkkhusus-id'],
                'pluginOptions'=>[
                    'depends'=>['khusus-id', 'subspesialiskhusus-id','kunjungan-id','rujukandate-id'],
                    'placeholder'=>'Select...',
                    'url'=>Url::to(['/bpjs/faskeskhusus'])
                ]
            ]);

            ?>
        </div>


    </div>




    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Save & Return'), ['class' => 'btn btn-success', 'name' => 'submit1','value' => 'save']) ?>

    </div>


    <?php ActiveForm::end(); ?>

</div>


