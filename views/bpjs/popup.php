<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Bpjs;
use app\models\Icd10;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use yii\web\JsExpression;

use kartik\widgets\TypeaheadBasic;

/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */

$this->title = $kunjunganModel->pendaftaran_id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pendaftaran / Kunjungan'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;




?>



<div class="kunjungan-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="well">
    <?= $form->field($kunjunganModel, 'pendaftaran_id')->textInput(['readonly' => true]) ?>
    <?php

    $listDataPerawatan=[
        'rawat inap' => 'rawat inap',
        'rawat jalan' => 'rawat jalan',
        'promotif preventif' => 'promotif preventif',
    ];

    $listDataKunjungan=[
        'sakit' => 'kunjungan sakit',
        'sehat' => 'kunjungan sehat',
    ];

    $listDataKodeSadar=[
        '01' => 'Compos Mentis',
        '02' => 'Somnolence',
        '03' => 'Sopor',
        '04' => 'Coma'
    ];



    echo    $form->field($kunjunganModel->pendaftaran, 'nama')->textInput(['readonly' => true]);
    ?>
    <?php
    echo '<h2>Pemeriksaan Fisik</h2>';
    ?>
    <?= $form->field($kunjunganModel, 'tinggi_badan')->textInput() ?>
    <?= $form->field($kunjunganModel, 'berat_badan')->textInput() ?>
    <?= $form->field($kunjunganModel, 'lingkar_perut')->textInput(['maxlength' => true]) ?>
    <?= $form->field($kunjunganModel, 'imt')->textInput(['maxlength' => true]) ?>
    <?php
    echo '<h2>Tekanan Darah</h2>';
    ?>
    <?= $form->field($kunjunganModel, 'sistole')->textInput(['maxlength' => true]) ?>
    <?= $form->field($kunjunganModel, 'diastole')->textInput(['maxlength' => true]) ?>
    <?= $form->field($kunjunganModel, 'respiratory_rate')->textInput(['maxlength' => true]) ?>
    <?= $form->field($kunjunganModel, 'heart_rate')->textInput(['maxlength' => true]) ?>
    <?= $form->field($kunjunganModel, 'keluhan')->textarea(['rows' => 6]) ?>
    <?php
echo    $form->field($kunjunganModel, 'jenis_kunjungan')->textInput(['readonly' => false]);
echo    $form->field($kunjunganModel, 'poli_tujuan')->textInput(['readonly' => false]);
    echo    $form->field($kunjunganModel, 'kode_dokter')->textInput(['readonly' => false]);



    echo $form->field($kunjunganModel, 'tanggal_kunjungan')->widget(DatePicker::classname(),[
        'options' => ['placeholder' => 'Select time ...','id' => 'kunjungandate-id'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-M-d',
            'todayHighlight' => true
        ]

    ]);

    echo    $form->field($kunjunganModel, 'perawatan')->textInput(['readonly' => false]);
    echo    $form->field($kunjunganModel, 'kode_sadar')->textInput(['readonly' => false]);



    echo $form->field($kunjunganModel, 'terapi')->textarea(['rows' => 6]);

    $icd10 = Icd10::find()
        ->limit(200)
        ->All();
    $icd10list = ArrayHelper::map($icd10, 'icd10', 'name');


    echo $form->field($kunjunganModel, 'kode_diagnosa1')->widget(select2::classname(), [
        'data' => $icd10list,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    echo $form->field($kunjunganModel, 'kode_diagnosa2')->widget(select2::classname(), [
        'data' => $icd10list,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    echo $form->field($kunjunganModel, 'kode_diagnosa3')->widget(select2::classname(), [
        'data' => $icd10list,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);




    ?>

</div>


    <?php

    echo '<h2>Pulang / Rujuk</h2>';

    echo $form->field($kunjunganModel, 'kode_status_pulang')->textInput(['maxlength' => true]);
    ?>



    <?= Html::a('Pulang / Rujukan', ['rujukansimple', 'id' => $kunjunganModel->id], ['class' => 'btn btn-primary']) ?>


    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Send to BPJS'), ['class' => 'btn btn-success', 'name' => 'submit1','value' => 'send']) ?>


    </div>


    <?php ActiveForm::end(); ?>

</div>

<?php

//echo sizeof($poli_list->response->list );

//echo '<pre>';
//print_r($icd10list);
//print_r($poli_list->response->list);
//print_r($result);




?>


