<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\PcareVisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tindakan');
//$this->params['breadcrumbs'][] = $this->title;
echo Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
     'homeLink'=>false,
    'links' => [
        [
            'label' => 'Back',
//            'url' => ['post-category/view', 'id' => 10],
        'url' => ['pcare/visit/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
//        ['label' => 'Sample Post', 'url' => ['post/edit', 'id' => 1]],
    ],
]);


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
