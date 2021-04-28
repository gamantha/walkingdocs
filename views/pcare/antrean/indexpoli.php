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

    <?= Html::submitButton('Go to Date', ['name' => 'date', 'class' => 'btn btn-primary']) ?>


</p>



    <div style="">
        <span style="font-size: 15em;"><?php
        echo $antreanTerakhir->nomorpanggilterakhir;
        ?></span>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Next', ['name' => 'next', 'class' => 'btn btn-primary', 'data-confirm' => 'Are you sure?']) ?>
        <?= Html::submitButton('Skip', ['name' => 'skip', 'class' => 'btn btn-primary', 'data-confirm' => 'Are you sure?']) ?>
    </div>
    <?php
    ActiveForm::end();
    ?>
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
