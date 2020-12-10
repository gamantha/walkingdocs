<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\PcareRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pcare Registrations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-registration-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Check registrasi by date'), ['registrationbydate'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a(Yii::t('app', 'Create Pcare Registration'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'tglDaftar',
            'no_urut',
            'kdProviderPeserta',

            'noKartu',
            'kdPoli',
            //'kunjSakit',
            //'keluhan:ntext',
            //'sistole',
            //'diastole',
            //'beratBadan',
            //'tinggiBadan',
            //'respRate',
            //'heartRate',
            //'rujukBalik',
            //'kdTkp',
            //'created_at',
            //'modified_at',
            'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'download' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-arrow-down"></span>',
                            $url,
                            [
                                'title' => 'Download',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
