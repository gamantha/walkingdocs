<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisit */

$this->title = Yii::t('app', 'Tindakan: {name}', [
    'name' => $model->id,
]);

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kunjungan'), 'url' => ['pcare/registration/index']];
//$this->params['breadcrumbs'][] = ['label' => 'go back', 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = $this->title;





?>
<div class="pcare-visit-update">

    <h1>Tindakan</h1>

    <div class="tindakan-form">

        <?php $form = ActiveForm::begin(); ?>
        <?php


        $listData=ArrayHelper::map($list,'kdTindakan','nmTindakan');

//        echo $form->field($model, 'visitId')->textInput(['maxlength' => true]);
//        echo $form->field($model, 'kdTindakan')->textInput(['maxlength' => true]);
        echo $form->field($model, 'kdTindakan')->dropDownList(
            $listData,
            ['prompt'=>'Select...']
        );



//        echo $form->field($model, 'kdTindakanSK')->textInput(['maxlength' => true]);
        echo $form->field($model, 'biaya')->textInput(['maxlength' => true]);
        echo $form->field($model, 'keterangan')->textArea(['maxlength' => true]);
        echo $form->field($model, 'hasil')->textInput(['maxlength' => true]);

        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
