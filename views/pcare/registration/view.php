<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pcare-registration-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Modify data registrasi'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php

//        if ($model->kdProviderPeserta != null) {
//            echo Html::a(Yii::t('app', 'peserta aktif (re-check)'), ['checkpeserta', 'id' => $model->id], ['class' => 'btn btn-success']);
//
//        }  else {
//            echo Html::a(Yii::t('app', 'check peserta bpjs'), ['checkpeserta', 'id' => $model->id], ['class' => 'btn btn-primary']);
//        }
        echo Html::a(Yii::t('app', 'check peserta bpjs'), ['checkpeserta', 'id' => $model->id], ['class' => 'btn btn-primary']);



//        echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ];
        ?>
        <?php
        if ($model->status != null) {
            echo Html::a(Yii::t('app', 'Pcare registered'), ['register', 'id' => $model->id], ['class' => 'btn btn-default disabled']);


        }  else {
            echo Html::a(Yii::t('app', 'Register to Pcare'), ['register', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
        echo Html::a(Yii::t('app', 'VISIT DATA'), ['pcare/visit/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'no_urut',
//            'status',
//            'kdProviderPeserta',
            'tglDaftar',
            'noKartu',
            'kdPoli',
            'kunjSakit',
            'keluhan:ntext',
            'sistole',
            'diastole',
            'beratBadan',
            'tinggiBadan',
            'respRate',
            'heartRate',
            'rujukBalik',
            'kdTkp',
//            'created_at',
//            'modified_at',
        ],
    ]) ?>

</div>
