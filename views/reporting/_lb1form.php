<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\grid\GridView;
app\models\reporting\lb1;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php


    echo GridView::widget([
        'dataProvider'=> $dataProvider,
        //'filterModel' => $searchModel,
        //'columns' => $gridColumns,
        'responsive'=>true,
        'hover'=>true
    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
