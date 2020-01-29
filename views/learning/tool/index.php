<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\learning\ToolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tools');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tool'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'background:ntext',
            'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete} {run}',
                'buttons' => [

                    'delete' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $url,
                            [
                                'title' => 'Delete',
                                'data-pjax' => '0',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => Yii::t('app', 'Are you sure you want to disable this item?'),
                                ],
                            ]
                        );
                    },
                    'run' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon">RUN</span>',
                            $url,
                            [
                                'title' => 'Run',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
