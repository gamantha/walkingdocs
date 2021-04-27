<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\AntreanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $kdPoli . " / " . $date);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="antrean-index">

    <h1><?= "Poli : " . Html::encode($kdPoli) ?></h1>
    <h1>Tanggal : <?= Html::encode($date) ?></h1>

    <p>
        <?php // Html::a(Yii::t('app', 'Create Antrean'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Next'), ['next', 'id'=>'sasaa'], ['class' => 'btn btn-success', 'style' => 'width:20%;height:50px; font-size:2em;']) ?>
        <?= Html::a(Yii::t('app', 'Skip'), ['skip'], ['class' => 'btn btn-warning', 'style' => 'width:20%;height:50px; font-size:2em;']) ?>
    </p>
    <div style="">
        <span style="font-size: 15em;"><?php
        echo $antreanTerakhir->nomorpanggilterakhir;
        ?></span>
    </div>
    <?php Pjax::begin(); ?>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    <h3>Daftar Antrean</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'noKartu',
            'nik',
//            'clinicId',
//            'tanggalPeriksa',
            //'kdPoli',
            'nmPoli',
            'noAntrean',
            'angkaAntrean',
            //'antreanPanggil',
            'keterangan',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php
//
//    GridView::widget([
//        'dataProvider' => $dataProvider2,
//        'filterModel' => $searchModel2,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
////            'id',
//            'noKartu',
//            'nik',
////            'clinicId',
////            'tanggalPeriksa',
//            //'kdPoli',
//            'nmPoli',
//            'noAntrean',
//            'angkaAntrean',
//            //'antreanPanggil',
//            'keterangan',
//            'status',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]);
//
    ?>


    <?php Pjax::end(); ?>

</div>
