<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pcare-visit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pendaftaranId') ?>

    <?= $form->field($model, 'noKunjungan') ?>

    <?= $form->field($model, 'kdSadar') ?>

    <?= $form->field($model, 'terapi') ?>

    <?php // echo $form->field($model, 'kdStatusPulang') ?>

    <?php // echo $form->field($model, 'tglPulang') ?>

    <?php // echo $form->field($model, 'kdDokter') ?>

    <?php // echo $form->field($model, 'kdDiag1') ?>

    <?php // echo $form->field($model, 'kdDiag2') ?>

    <?php // echo $form->field($model, 'kdDiag3') ?>

    <?php // echo $form->field($model, 'kdPoliRujukInternal') ?>

    <?php // echo $form->field($model, 'tglEstRujuk') ?>

    <?php // echo $form->field($model, 'kdppk') ?>

    <?php // echo $form->field($model, 'subSpesialis_kdSubSpesialis1') ?>

    <?php // echo $form->field($model, 'subSpesialis_kdSarana') ?>

    <?php // echo $form->field($model, 'khusus_kdKhusus') ?>

    <?php // echo $form->field($model, 'khusus_kdSubSpesialis') ?>

    <?php // echo $form->field($model, 'khusus_catatan') ?>

    <?php // echo $form->field($model, 'kdTacc') ?>

    <?php // echo $form->field($model, 'alasanTacc') ?>

    <?php // echo $form->field($model, 'json') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
