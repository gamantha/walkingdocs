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

$this->title = $kunjungan_model->pendaftaran_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pendaftaran / Kunjungan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;




?>



<div class="kunjungan-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($kunjungan_model, 'pendaftaran_id')->textInput(['readonly' => true]) ?>
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

$dokterres = Bpjs::getDokter();
$dokterresponse = json_decode($dokterres);

$spesialisres = Bpjs::getSpesialis();
$spesialisresponse = json_decode($spesialisres);

$saranares = Bpjs::getSarana();
$saranaresponse = json_decode($saranares);
$saranaarray = ArrayHelper::map($saranaresponse->response->list, 'kdSarana', 'nmSarana');

$khususres = Bpjs::getKhusus();
$khususresponse = json_decode($khususres);
$khususarray = ArrayHelper::map($khususresponse->response->list, 'kdKhusus', 'nmKhusus');


$spesialisarray = ArrayHelper::map($spesialisresponse->response->list, 'kdSpesialis', 'nmSpesialis');


$listDokter = ArrayHelper::map($dokterresponse->response->list, 'kdDokter', 'nmDokter');
$statuspulang = Bpjs::getStatuspulang('false');
$statuspulangresponse = json_decode($statuspulang);
$statuspulangarray = ArrayHelper::map($statuspulangresponse->response->list, 'kdStatusPulang', 'nmStatusPulang');
$subspesialis_list = [];



echo $form->field($kunjungan_model, 'jenis_kunjungan')->dropDownList(
        $listDataKunjungan,
        ['prompt'=>'Select...','id'=>'catkunjungan-id']
        );


if (is_null($kunjungan_model->poli_tujuan)) {
$data = [];
} else {
    $out=[];
    $out2=[];
    $poliList = json_decode(Bpjs::getPoli());
    foreach ($poliList->response->list as $poli){
        if($poli->poliSakit == true) {
            array_push($out, ['id' => $poli->kdPoli,'name' => $poli->nmPoli]);
        } else {
            array_push($out2, ['id' => $poli->kdPoli,'name' => $poli->nmPoli]);
        }

    }

    if ($kunjungan_model->jenis_kunjungan == 'sakit') {
        $data =  ArrayHelper::map($out, 'id', 'name');
    } else {
        $data =  ArrayHelper::map($out2, 'id', 'name');
    }
}
//echo '<pre>';
//print_r($data);
    echo $form->field($kunjungan_model, 'poli_tujuan')->widget(DepDrop::classname(), [
        'data' => $data,
        'options'=>['id'=>'subcatpoli-id'],
        'pluginOptions'=>[
            'depends'=>['catkunjungan-id'],
            'placeholder'=>'Select...',
            'url'=>Url::to(['/bpjs/subcatpoli'])
        ]
    ]);
/*} else {
    echo $form->field($kunjungan_model, 'poli_tujuan')->dropDownList(
        $listDataKunjungan,
        ['prompt'=>'Select...','id'=>'subcatpoli-id']
    );
}

*/

        echo $form->field($kunjungan_model, 'kode_dokter')->dropDownList(
            $listDokter,
            ['prompt'=>'Select...']
            );
    

        echo $form->field($kunjungan_model, 'tanggal_kunjungan')->widget(DatePicker::classname(),[
            'options' => ['placeholder' => 'Select time ...','id' => 'kunjungandate-id'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-M-d',
                'todayHighlight' => true
            ]

        ]);



        echo $form->field($kunjungan_model, 'perawatan')->dropDownList(
            $listDataPerawatan,
            ['prompt'=>'Select...']
            );

            echo $form->field($kunjungan_model, 'kode_sadar')->dropDownList(
                $listDataKodeSadar,
                ['prompt'=>'Select...']
                );

echo $form->field($kunjungan_model, 'terapi')->textarea(['rows' => 6]);

                $icd10 = Icd10::find()
                ->limit(200)
                ->All();
                $icd10list = ArrayHelper::map($icd10, 'icd10', 'name');


echo $form->field($kunjungan_model, 'kode_diagnosa1')->widget(select2::classname(), [
    'data' => $icd10list,
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
echo $form->field($kunjungan_model, 'kode_diagnosa2')->widget(select2::classname(), [
    'data' => $icd10list,
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

echo $form->field($kunjungan_model, 'kode_diagnosa3')->widget(select2::classname(), [
    'data' => $icd10list,
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);



                    
?>


<?= $form->field($kunjungan_model, 'keluhan')->textarea(['rows' => 6]) ?>
<?php
echo '<h2>Pemeriksaan Fisik</h2>';
?>
<?= $form->field($kunjungan_model, 'tinggi_badan')->textInput() ?>
<?= $form->field($kunjungan_model, 'berat_badan')->textInput() ?>
<?= $form->field($kunjungan_model, 'lingkar_perut')->textInput(['maxlength' => true]) ?>
<?= $form->field($kunjungan_model, 'imt')->textInput(['maxlength' => true]) ?>
<?php
echo '<h2>Tekanan Darah</h2>';
?>
<?= $form->field($kunjungan_model, 'sistole')->textInput(['maxlength' => true]) ?>
<?= $form->field($kunjungan_model, 'diastole')->textInput(['maxlength' => true]) ?>
<?= $form->field($kunjungan_model, 'respiratory_rate')->textInput(['maxlength' => true]) ?>
<?= $form->field($kunjungan_model, 'heart_rate')->textInput(['maxlength' => true]) ?>
    <?php

    echo '<h2>Pulang / Rujuk</h2>';



    echo $form->field($kunjungan_model, 'kode_status_pulang')->dropDownList(
        $statuspulangarray,
        ['prompt' => 'Select...', 'id' => 'catstatuspulang-id']
    );

?>



    <?= Html::a('Pulang / Rujukan', ['rujukan', 'id' => $kunjungan_model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Obat', ['obat', 'id' => $kunjungan_model->id], ['class' => 'btn btn-primary']) ?>

<div class="form-group">

    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'name' => 'submit1','value' => 'save']) ?>
    <?= Html::submitButton(Yii::t('app', 'Pendaftaran BPJS'), ['class' => 'btn btn-info', 'name' => 'submit1','value' => 'addpendaftaran']) ?>
    <?= Html::submitButton(Yii::t('app', 'Kunjungan BPJS'), ['class' => 'btn btn-info', 'name' => 'submit1','value' => 'addkunjungan']) ?>

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


