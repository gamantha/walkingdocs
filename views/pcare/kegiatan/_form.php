<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareKegiatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pcare-kegiatan-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php

    $jeniskelompok   = [
        "00" => "Non Prolanis",
        "01" => "Diabetes Melitus",
        "02" => "Hipertensi"
    ];





    ?>
    <?= $form->field($model, 'consId')->textInput() ?>

    <?= $form->field($model, 'eduId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clubId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tglPelayanan')->textInput() ?>


    <?php

    echo $form->field($model, 'kdKegiatan')
//        ->label('Spesialis')
        ->dropDownList(
        $jeniskelompok,
//        ['prompt'=>'Select...']
        );
    ?>

    <?= $form->field($model, 'kdKelompok')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'materi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pembicara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'biaya')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'modified_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
