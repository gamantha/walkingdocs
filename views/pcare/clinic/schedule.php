<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clinics'), 'url' => ['index']];
$this->title = Yii::t('app', 'Schedule');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consid-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Add schedule'), ['createschedule', 'id' => $id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'clinicId',
            'dayofweek',
            'starttime',
            'endtime',
            'status',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{deleteschedule}',
//                'contentOptions' => ['style' => 'width: 8.7%'],
//                'visible'=> Yii::$app->user->isGuest ? false : true,
                'buttons'=>[
                    'deleteschedule'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-info-sign"></span>', $url, [

                            'title' => Yii::t('app', 'Info'),
                            ]);
                    },


                ],

        ],
            ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
