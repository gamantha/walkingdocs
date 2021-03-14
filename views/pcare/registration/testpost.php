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
<div class="pcare-registration-create">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="pcare-registration-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'pcareregistration-cons_id']) ?>
    <?php

    //echo $form->field($model, 'kdProviderPeserta')->textInput(['maxlength' => true, 'readonly' => false])

    ?>
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
</div>
    <h2>Visit Data</h2>
    <div class="well">





        <?php

        $listData2 = [];
        $refKesadaran = [];



        $listData2 = $this->context->getDokter($model);
        $refKesadaran = $this->context->getKesadaran($model);

        echo $form->field($wdmodel, 'doctor')->textInput(['maxlength' => true,'readonly' => true]);
        echo $form->field($visitmodel, 'kdDokter')->dropDownList(
            $listData2,
            ['prompt'=>'Select...']);
        echo '<hr/>';
        echo $form->field($visitmodel, 'kdSadar')->dropDownList(
            $refKesadaran,
            ['prompt'=>'Select...']);

        echo $form->field($wdmodel, 'checklistNames')->textInput(['maxlength' => true,'readonly' => true])
            //->label("Diagnose")
        ;

//echo $form->field($visitmodel, 'kdDiag1')->textInput(['maxlength' => true]);
        $url = \yii\helpers\Url::to(['diagnosecode']);
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

echo '<hr/>';
        echo $form->field($wdmodel, 'manualDiagnoses')->textInput(['maxlength' => true,'readonly' => true]);


        ?>
</div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
