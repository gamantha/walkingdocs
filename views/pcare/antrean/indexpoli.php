<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\AntreanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $kdPoli . " / " . $date);
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="antrean-index">

    <h1><?= "Poli : " . Html::encode($kdPoli) ?></h1>
<p>

    <?php
    $form = ActiveForm::begin();
    echo DatePicker::widget([
        'name' => 'tanggalDaftar',
        'value' => $date,
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
//                   'format' => 'dd-mm-yyyy'
        ]
//        'dateFormat' => 'yyyy-MM-dd',
    ]);


    ?>
    <span class="input-group-btn">
        <button class="btn btn-default" type="submit">Go</button>
      </span>


    <?php
    ActiveForm::end();
    ?>
</p>
    <p>
        <?php // Html::a(Yii::t('app', 'Create Antrean'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Next'), ['next', 'clinicId'=> $antreanTerakhir->clinicId, 'kdPoli' => $kdPoli,'tanggalPeriksa' => $date], ['class' => 'btn btn-success', 'style' => 'width:20%;height:50px; font-size:2em;']) ?>
        <?= Html::a(Yii::t('app', 'Skip'), ['skip','clinicId'=> $antreanTerakhir->clinicId, 'kdPoli' => $kdPoli,'tanggalPeriksa' => $date], ['class' => 'btn btn-warning', 'style' => 'width:20%;height:50px; font-size:2em;']) ?>
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
