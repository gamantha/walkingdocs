<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\PcareKegiatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pcare Kegiatans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-kegiatan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Pcare Kegiatan'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'consId',
            'eduId',
            'clubId',
            'tglPelayanan',
            //'kdKegiatan',
            //'kdKelompok',
            //'materi:ntext',
            //'pembicara',
            //'lokasi',
            //'keterangan:ntext',
            //'biaya',
            //'status',
            //'created_at',
            //'modified_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
