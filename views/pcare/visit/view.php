<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisit */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kunjungan'), 'url' => ['pcare/registration/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pcare-visit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Modify visit data'), ['update', 'id' => $model->pendaftaranId], ['class' => 'btn btn-primary']) ?>
        <?php
        if ($model->pendaftaran->status != null) {
            echo Html::a(Yii::t('app', 'Pcare registered'), ['pcare/registration/register', 'id' => $model->id], ['class' => 'btn btn-default disabled']);


        }  else {
            echo Html::a(Yii::t('app', 'Register to Pcare'), ['pcare/registration/register', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }

//        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ])
//
        ?>
        <?php
        if ($model->status == null) {
            echo Html::a(Yii::t('app', 'submit data to pcare'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }  else {

        }


        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'pendaftaranId',
//            'noKunjungan',
            'kdSadar',
            'terapi:ntext',
            'kdStatusPulang',
            'tglPulang',
            'kdDokter',
            'kdDiag1',
            'kdDiag2',
            'kdDiag3',
            'kdPoliRujukInternal',
            'tglEstRujuk',
            'kdppk',
            'subSpesialis_kdSubSpesialis1',
            'subSpesialis_kdSarana',
            'khusus_kdKhusus',
            'khusus_kdSubSpesialis',
            'khusus_catatan:ntext',
            'kdTacc',
            'alasanTacc:ntext',
//            'json:ntext',
//            'status',
//            'created_at',
//            'modified_at',
        ],
    ]) ?>

</div>
