<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\reporting\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Report'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'report_template_id',
            'report_name',
            'report_period',
            'report_date',
            //'facility_id',
            //'author_id',
            //'author_name',
            //'created_at',
            //'updated_at',

//            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                    'urlCreator' => function ($action, $model, $key, $index) {
        return Url::to([$action . $model->reportTemplate->template_code, 'id' => $model->id]);
    },
                'header' => 'Action',
                'template' => '{view} {delete}',
                'buttons' => [

                    'fill' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url . 'lb1', [

                            'title' => Yii::t('app', 'Fill'),

                        ]);

                    },
                    'view' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [

                            'title' => Yii::t('app', 'View'),

                        ]);

                    }

                ],
            ]

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
