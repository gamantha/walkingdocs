<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\PcareVisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tindakan');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-visit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Add Tindakan'), ['pcare/tindakan/create?id=' . $id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kdTindakanSK',
            'kdTindakan',
            'biaya',
            'keterangan',
            'hasil',




            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $url);
                    },
                    'link' => function ($url,$model,$key) {
                        return Html::a('Action', $url);
                    },
                ],
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
