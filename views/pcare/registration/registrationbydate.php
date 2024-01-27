<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\PcareRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Confirm Registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-registration-index">
    <?php
//    echo '<pre>';
//    print_r($model);
//    echo '</pre>';

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'params',
            'cons_id',
            'tglDaftar',
            'noKartu',
            'nik',
            'kdTkp',
            'kunjSakit',
            'kdPoli',
            'keluhan','sistole',
            'diastole','beratBadan','tinggiBadan','respRate','heartRate',
            'kdProviderPeserta','status'
        ],
    ]);

echo '</hr>';
//    echo '<pre>';
//    print_r($visitmodel);
//    echo '</pre>';
    echo DetailView::widget([
        'model' => $visitmodel,
        'attributes' => [
'kdSadar',
            'kdDokter',
            'kdDiag1',
            'kdDiag2',
            'kdDiag2'
        ],
    ]);
//    echo '<pre>';
//    print_r($wdmodel);
//    echo '</pre>';

    echo DetailView::widget([
        'model' => $wdmodel,
        'attributes' => [
            'wdVisitId',
            'clinicId',
            'doctor',
            'checklistNames',
            'manualDiagnoses',
            'manualDiagnose_description',
            'manualDiagnose_treatment',
            'disposition',
            'statusAssessment',
            'sistole',
            'diastole'
        ],
    ]);


    ?>
    <div class="pcare-registration-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Are you sure?'), ['name' => 'confirm', 'class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>
