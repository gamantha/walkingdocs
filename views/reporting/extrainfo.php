<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */

$this->title = Yii::t('app', 'Update Report: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="report-update">

    <h1>Additional Infos</h1>

    <div class="report-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::label('Kepala Puskesmas name', 'kepala_puskesmas', ['class' => '']) ?>
        <?= Html::input('text', 'kepala_puskesmas', $prefill['kepala_puskesmas'], []) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
