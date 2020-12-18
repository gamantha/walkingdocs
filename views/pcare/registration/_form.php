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

<div class="pcare-registration-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cons_id')->textInput(['maxlength' => true, 'readonly' => false]) ?>
    <?= $form->field($model, 'kdProviderPeserta')->textInput(['maxlength' => true, 'readonly' => true]) ?>


    <?php
    echo '<label class="control-label">Tanggal Daftar </label>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'tglDaftar',
        //'language' => 'ru',
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
//        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>

    <?= $form->field($model, 'noKartu')->textInput(['maxlength' => true]) ?>

    <?php

    $refPoli = [];

//    if ($model->cons_id) {
//        $refPoli = $this->context->getPoli($model->id);
//    } else {
//
//    }

    $url = \yii\helpers\Url::to(['getpolicodes']);

    echo $form->field($model, 'kdPoli')->widget(DepDrop::classname(), [
        'options'=>['id'=>'subcat-id'],
        'data' => [$model->kdPoli],
        'pluginOptions'=>[
            'depends'=>['pcareregistration-cons_id'],
            'placeholder'=>'Select...',
            'url'=>$url
        ]
    ]);

//    echo $form->field($model, 'kdPoli')->dropDownList(
//        $refPoli,
//        ['prompt'=>'Select...']);




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



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
