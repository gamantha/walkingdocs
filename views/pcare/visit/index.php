<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\PcareVisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pcare Visits');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-visit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Pcare Visit'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pendaftaranId',
            'noKunjungan',
            'kdSadar',
            'terapi:ntext',
            //'kdStatusPulang',
            //'tglPulang',
            //'kdDokter',
            //'kdDiag1',
            //'kdDiag2',
            //'kdDiag3',
            //'kdPoliRujukInternal',
            //'tglEstRujuk',
            //'kdppk',
            //'subSpesialis_kdSubSpesialis1',
            //'subSpesialis_kdSarana',
            //'khusus_kdKhusus',
            //'khusus_kdSubSpesialis',
            //'khusus_catatan:ntext',
            //'kdTacc',
            //'alasanTacc:ntext',
            //'json:ntext',
            //'status',
            //'created_at',
            //'modified_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
